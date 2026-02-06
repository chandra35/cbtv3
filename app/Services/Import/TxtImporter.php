<?php

namespace App\Services\Import;

use App\Models\Question;
use App\Models\QuestionGroup;
use Illuminate\Support\Collection;

class TxtImporter
{
    /**
     * Parse TXT file dan extract soal
     * Format yang diharapkan sama dengan Word:
     * [1] Soal pertama?
     *     a) Option A
     *     b) Option B
     *     c) Option C
     *     d) Option D
     *     Jawaban: a
     */
    public function import(string $filePath, QuestionGroup $group, int $userId): Collection
    {
        $content = file_get_contents($filePath);

        return $this->parseContent($content, $group, $userId);
    }

    /**
     * Parse text content dan extract questions
     */
    private function parseContent(string $content, QuestionGroup $group, int $userId): Collection
    {
        $questions = collect();
        $lines = explode("\n", $content);
        $currentQuestion = null;
        $options = [];
        $correctAnswer = null;

        foreach ($lines as $line) {
            $line = trim($line);

            if (empty($line)) {
                continue;
            }

            // Detect question number pattern: [1], [2], etc.
            if (preg_match('/^\[\d+\]\s*(.+)/', $line, $matches)) {
                // Save previous question if exists
                if ($currentQuestion) {
                    $questions->push($this->saveQuestion(
                        $currentQuestion,
                        $options,
                        $correctAnswer,
                        $group,
                        $userId
                    ));
                }

                $currentQuestion = $matches[1];
                $options = [];
                $correctAnswer = null;
                continue;
            }

            // Detect options: a), b), c), d)
            if (preg_match('/^[a-d]\)\s*(.+)/', $line, $matches)) {
                $letter = strtolower($line[0]);
                $options[$letter] = $matches[1];
                continue;
            }

            // Detect correct answer
            if (preg_match('/^Jawaban:\s*([a-d])/i', $line, $matches)) {
                $correctAnswer = strtolower($matches[1]);
                continue;
            }

            // Add to current question if no pattern matched
            if ($currentQuestion && !preg_match('/^[a-d]\)/', $line)) {
                $currentQuestion .= ' ' . $line;
            }
        }

        // Save last question
        if ($currentQuestion) {
            $questions->push($this->saveQuestion(
                $currentQuestion,
                $options,
                $correctAnswer,
                $group,
                $userId
            ));
        }

        return $questions;
    }

    /**
     * Save question to database
     */
    private function saveQuestion(
        string $content,
        array $options,
        ?string $correctAnswer,
        QuestionGroup $group,
        int $userId
    ): Question {
        $question = Question::create([
            'question_group_id' => $group->id,
            'user_id' => $userId,
            'content' => $content,
            'question_type' => 'multiple_choice',
            'points' => $group->points_per_question ?? 1,
            'difficulty_level' => 'medium',
        ]);

        // Create options
        $order = 1;
        foreach ($options as $letter => $optionContent) {
            $question->options()->create([
                'content' => $optionContent,
                'order_index' => $order,
                'is_correct' => $letter === $correctAnswer,
            ]);
            $order++;
        }

        return $question;
    }
}
