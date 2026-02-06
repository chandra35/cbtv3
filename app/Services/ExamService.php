<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\ExamParticipant;
use App\Models\UserExamQuestion;
use App\Models\ExamSubmission;
use App\Models\CBTActivityLog;
use Illuminate\Support\Collection;

class ExamService
{
    /**
     * Start exam untuk seorang peserta
     */
    public function startExam(ExamParticipant $participant): bool
    {
        if (!$participant->exam->canStartExam()) {
            throw new \Exception('Ujian belum dimulai atau sudah berakhir');
        }

        if ($participant->isCompleted()) {
            throw new \Exception('Peserta sudah menyelesaikan ujian');
        }

        $participant->update([
            'status' => 'in_progress',
            'started_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Log activity
        CBTActivityLog::logAction($participant->id, 'start_exam', [
            'exam_id' => $participant->exam_id,
        ]);

        // Generate soal untuk peserta
        $this->generateQuestionsForParticipant($participant);

        return true;
    }

    /**
     * Generate soal yang akan dijawab peserta
     */
    private function generateQuestionsForParticipant(ExamParticipant $participant): void
    {
        $exam = $participant->exam;
        $questionOrder = 0;

        // Get question groups
        $questionGroups = $exam->questionGroups;

        foreach ($questionGroups as $group) {
            $questions = $this->getQuestionsForGroup($group, $exam->randomize_questions_per_user);

            foreach ($questions as $question) {
                $randomizedOptions = [];
                
                if ($group->randomize_options) {
                    $randomizedOptions = $this->getRandomizedOptions($question);
                }

                UserExamQuestion::firstOrCreate(
                    [
                        'exam_participant_id' => $participant->id,
                        'question_id' => $question->id,
                    ],
                    [
                        'order_in_exam' => $questionOrder++,
                        'randomized_options' => !empty($randomizedOptions) ? $randomizedOptions : null,
                    ]
                );
            }
        }
    }

    /**
     * Get soal untuk group, dengan opsi random jika needed
     */
    private function getQuestionsForGroup($group, $randomizePerUser = false): Collection
    {
        $questions = $group->questions();

        if ($randomizePerUser && $group->questionPool) {
            // Ambil soal secara random dari pool
            $questionIds = $group->questionPool->question_ids;
            $numToSelect = $group->questionPool->questions_to_show;
            
            $selectedIds = collect($questionIds)->random($numToSelect)->toArray();
            $questions = $questions->whereIn('id', $selectedIds);
        }

        return $questions->orderBy('order_index')->get();
    }

    /**
     * Get randomized options untuk soal
     */
    private function getRandomizedOptions($question): array
    {
        if (!$question->isMultipleChoice()) {
            return [];
        }

        $options = $question->options()->get();
        $randomized = $options->shuffle();

        return $randomized->map(function ($option) {
            return [
                'id' => $option->id,
                'content' => $option->content,
            ];
        })->toArray();
    }

    /**
     * Submit jawaban untuk satu soal
     */
    public function submitAnswer(ExamParticipant $participant, $questionId, $answer): ExamSubmission
    {
        if (!$participant->isInProgress()) {
            throw new \Exception('Ujian sudah selesai');
        }

        $question = $participant->exam->questions()->find($questionId);
        if (!$question) {
            throw new \Exception('Soal tidak ditemukan');
        }

        // Auto-score untuk MC questions
        $isCorrect = null;
        $pointsEarned = null;

        if ($question->isMultipleChoice()) {
            $isCorrect = $this->checkMultipleChoiceAnswer($question, $answer);
            $pointsEarned = $isCorrect ? $question->points : 0;
        }

        $submission = ExamSubmission::updateOrCreate(
            [
                'exam_participant_id' => $participant->id,
                'question_id' => $questionId,
            ],
            [
                'user_answer' => $answer,
                'is_correct' => $isCorrect,
                'points_earned' => $pointsEarned,
                'submitted_at' => now(),
            ]
        );

        // Log activity
        CBTActivityLog::logAction($participant->id, 'submit_answer', [
            'question_id' => $questionId,
            'question_type' => $question->question_type,
        ]);

        return $submission;
    }

    /**
     * Check if MC answer is correct
     */
    private function checkMultipleChoiceAnswer($question, $selectedOptionId): bool
    {
        $correctOption = $question->getCorrectOption();
        return $correctOption && $correctOption->id == $selectedOptionId;
    }

    /**
     * Submit ujian (selesaikan)
     */
    public function submitExam(ExamParticipant $participant): bool
    {
        if (!$participant->isInProgress()) {
            throw new \Exception('Ujian sudah selesai');
        }

        // Calculate score
        $totalPoints = $participant->submissions()
            ->sum('points_earned');

        $examTotalPoints = $participant->exam->getTotalPoints();
        $percentage = $examTotalPoints > 0 ? ($totalPoints / $examTotalPoints) * 100 : 0;

        $participant->update([
            'status' => 'submitted',
            'submitted_at' => now(),
            'finished_at' => now(),
            'score' => $totalPoints,
            'percentage' => round($percentage, 2),
        ]);

        // Log activity
        CBTActivityLog::logAction($participant->id, 'submit_exam', [
            'score' => $totalPoints,
            'percentage' => $percentage,
        ]);

        return true;
    }

    /**
     * Mark soal untuk di-review nanti
     */
    public function markForReview(ExamParticipant $participant, $questionId): bool
    {
        $submission = ExamSubmission::where('exam_participant_id', $participant->id)
            ->where('question_id', $questionId)
            ->firstOrFail();

        $submission->update(['marked_for_review' => true]);

        CBTActivityLog::logAction($participant->id, 'mark_review', [
            'question_id' => $questionId,
        ]);

        return true;
    }

    /**
     * Get status ujian (progress, remaining time, dll)
     */
    public function getExamStatus(ExamParticipant $participant): array
    {
        $totalQuestions = $participant->userExamQuestions()->count();
        $answeredQuestions = $participant->submissions()->whereNotNull('user_answer')->count();
        $markedQuestions = $participant->submissions()->where('marked_for_review', true)->count();

        return [
            'status' => $participant->status,
            'total_questions' => $totalQuestions,
            'answered_questions' => $answeredQuestions,
            'marked_questions' => $markedQuestions,
            'progress_percentage' => $participant->getProgressPercentage(),
            'remaining_seconds' => $participant->getRemainingTime(),
            'remaining_minutes' => floor($participant->getRemainingTime() / 60) ?? 0,
            'can_submit' => $participant->canSubmitExam(),
            'time_expired' => $participant->getRemainingTime() <= 0,
        ];
    }
}
