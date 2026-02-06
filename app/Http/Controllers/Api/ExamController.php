<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamParticipant;
use App\Services\ExamService;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    protected $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    /**
     * List exam yang available untuk user
     */
    public function listAvailableExams(Request $request)
    {
        $user = $request->user();

        // Get exams based on user role/system
        $exams = Exam::where('is_published', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->with('creator', 'mobileSettings')
            ->get()
            ->map(function ($exam) use ($user) {
                return [
                    'id' => $exam->id,
                    'exam_name' => $exam->exam_name,
                    'exam_type' => $exam->exam_type,
                    'description' => $exam->description,
                    'duration' => $exam->duration,
                    'jenjang' => $exam->jenjang,
                    'passing_grade' => $exam->passing_grade,
                    'total_questions' => $exam->getTotalQuestions(),
                    'total_points' => $exam->getTotalPoints(),
                    'created_by' => $exam->creator->name,
                    'is_active' => $exam->isActive(),
                    'password_protected' => $exam->mobileSettings?->enable_password_protection ?? false,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $exams,
        ]);
    }

    /**
     * Get detail exam
     */
    public function getExamDetail(Exam $exam)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $exam->id,
                'exam_name' => $exam->exam_name,
                'exam_type' => $exam->exam_type,
                'description' => $exam->description,
                'duration' => $exam->duration,
                'jenjang' => $exam->jenjang,
                'passing_grade' => $exam->passing_grade,
                'passing_message' => $exam->passing_message,
                'failing_message' => $exam->failing_message,
                'total_questions' => $exam->getTotalQuestions(),
                'total_points' => $exam->getTotalPoints(),
                'show_answers_after' => $exam->show_answers_after,
                'allow_review_before_submit' => $exam->allow_review_before_submit,
                'start_date' => $exam->start_date,
                'end_date' => $exam->end_date,
                'start_time' => $exam->start_time,
                'end_time' => $exam->end_time,
            ],
        ]);
    }

    /**
     * Start exam untuk peserta
     */
    public function startExam(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'device_id' => 'required|string',
        ]);

        $user = $request->user();

        // Get atau create participant
        $participant = ExamParticipant::firstOrCreate(
            [
                'exam_id' => $exam->id,
                'user_id' => $user->id,
                'attempt_number' => 1,
            ],
            [
                'source_system' => 'cbt_internal',
            ]
        );

        try {
            $this->examService->startExam($participant);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Exam started',
            'data' => [
                'participant_id' => $participant->id,
                'exam_id' => $exam->id,
                'total_questions' => $participant->userExamQuestions()->count(),
                'duration_minutes' => $exam->duration,
            ],
        ]);
    }

    /**
     * Get exam status (progress, time remaining, dll)
     */
    public function getExamStatus(Request $request, Exam $exam)
    {
        $user = $request->user();
        $participant = ExamParticipant::where('exam_id', $exam->id)
            ->where('user_id', $user->id)
            ->latest()
            ->firstOrFail();

        $status = $this->examService->getExamStatus($participant);

        return response()->json([
            'success' => true,
            'data' => $status,
        ]);
    }

    /**
     * Get all questions untuk exam
     */
    public function getQuestions(Request $request, Exam $exam)
    {
        $user = $request->user();
        $participant = ExamParticipant::where('exam_id', $exam->id)
            ->where('user_id', $user->id)
            ->latest()
            ->firstOrFail();

        $questions = $participant->userExamQuestions()
            ->with(['question' => function ($query) {
                $query->select('id', 'content', 'question_type', 'image_url', 'points', 'difficulty_level');
            }])
            ->get()
            ->map(function ($userQuestion) {
                $question = $userQuestion->question;
                $submission = \App\Models\ExamSubmission::where('exam_participant_id', $userQuestion->exam_participant_id)
                    ->where('question_id', $question->id)
                    ->first();

                return [
                    'order' => $userQuestion->order_in_exam + 1,
                    'question_id' => $question->id,
                    'content' => $question->content,
                    'question_type' => $question->question_type,
                    'image_url' => $question->image_url,
                    'points' => $question->points,
                    'difficulty_level' => $question->difficulty_level,
                    'is_answered' => $submission && $submission->user_answer !== null,
                    'is_marked' => $submission?->marked_for_review ?? false,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $questions,
        ]);
    }

    /**
     * Get single question detail
     */
    public function getQuestion(Request $request, Exam $exam, $questionId)
    {
        $user = $request->user();
        $participant = ExamParticipant::where('exam_id', $exam->id)
            ->where('user_id', $user->id)
            ->latest()
            ->firstOrFail();

        $question = $exam->questions()->find($questionId);
        if (!$question) {
            return response()->json([
                'success' => false,
                'message' => 'Question not found',
            ], 404);
        }

        $data = [
            'id' => $question->id,
            'content' => $question->content,
            'question_type' => $question->question_type,
            'image_url' => $question->image_url,
            'instructions' => $question->instructions,
            'points' => $question->points,
            'difficulty_level' => $question->difficulty_level,
        ];

        // Add options untuk MC, true/false, matching
        if (in_array($question->question_type, ['multiple_choice', 'true_false', 'matching'])) {
            $data['options'] = $question->options()->get(['id', 'content', 'image_url', 'order_index'])->toArray();
        }

        // Get previous submission jika ada
        $submission = \App\Models\ExamSubmission::where('exam_participant_id', $participant->id)
            ->where('question_id', $questionId)
            ->first();

        $data['submitted_answer'] = $submission?->user_answer;
        $data['marked_for_review'] = $submission?->marked_for_review ?? false;

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Submit answer untuk soal
     */
    public function submitAnswer(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer' => 'required',
        ]);

        $user = $request->user();
        $participant = ExamParticipant::where('exam_id', $exam->id)
            ->where('user_id', $user->id)
            ->latest()
            ->firstOrFail();

        try {
            $submission = $this->examService->submitAnswer(
                $participant,
                $validated['question_id'],
                $validated['answer']
            );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Answer submitted',
            'data' => [
                'is_correct' => $submission->is_correct,
                'points_earned' => $submission->points_earned,
            ],
        ]);
    }

    /**
     * Mark soal untuk di-review
     */
    public function markForReview(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'question_id' => 'required|exists:questions,id',
        ]);

        $user = $request->user();
        $participant = ExamParticipant::where('exam_id', $exam->id)
            ->where('user_id', $user->id)
            ->latest()
            ->firstOrFail();

        $this->examService->markForReview($participant, $validated['question_id']);

        return response()->json([
            'success' => true,
            'message' => 'Question marked for review',
        ]);
    }

    /**
     * Submit exam (selesaikan)
     */
    public function submitExam(Request $request, Exam $exam)
    {
        $user = $request->user();
        $participant = ExamParticipant::where('exam_id', $exam->id)
            ->where('user_id', $user->id)
            ->latest()
            ->firstOrFail();

        try {
            $this->examService->submitExam($participant);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }

        $participant->refresh();

        $message = $participant->isPassed() ? $exam->passing_message : $exam->failing_message;

        return response()->json([
            'success' => true,
            'message' => 'Exam submitted',
            'data' => [
                'score' => $participant->score,
                'percentage' => $participant->percentage,
                'passed' => $participant->isPassed(),
                'result_message' => $message,
            ],
        ]);
    }

    /**
     * Get results setelah submit
     */
    public function getResults(Request $request, Exam $exam)
    {
        $user = $request->user();
        $participant = ExamParticipant::where('exam_id', $exam->id)
            ->where('user_id', $user->id)
            ->latest()
            ->firstOrFail();

        if (!$participant->isCompleted()) {
            return response()->json([
                'success' => false,
                'message' => 'Exam belum selesai',
            ], 400);
        }

        $results = [
            'score' => $participant->score,
            'percentage' => $participant->percentage,
            'passed' => $participant->isPassed(),
            'passing_grade' => $exam->passing_grade,
            'result_message' => $participant->isPassed() ? $exam->passing_message : $exam->failing_message,
            'submitted_at' => $participant->submitted_at,
        ];

        // Include answer review jika exam allows it
        if ($exam->show_answers_after) {
            $results['answer_review'] = $this->getAnswerReview($participant);
        }

        return response()->json([
            'success' => true,
            'data' => $results,
        ]);
    }

    /**
     * Get answer review
     */
    private function getAnswerReview(ExamParticipant $participant)
    {
        return $participant->submissions()
            ->with('question:id,content,question_type,points,explanation')
            ->get()
            ->map(function ($submission) {
                return [
                    'question_content' => $submission->question->content,
                    'question_type' => $submission->question->question_type,
                    'user_answer' => $submission->user_answer,
                    'is_correct' => $submission->is_correct,
                    'points_earned' => $submission->points_earned,
                    'explanation' => $submission->question->explanation,
                ];
            });
    }
