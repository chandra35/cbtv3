<?php

namespace App\Services\Import;

use App\Models\Question;
use App\Models\QuestionGroup;
use Illuminate\Support\Collection;

class BlackboardImporter
{
    /**
     * Parse Blackboard QTI XML export
     * Blackboard exports dalam format XML yang kompleks
     */
    public function import(string $filePath, QuestionGroup $group, int $userId): Collection
    {
        $xml = simplexml_load_file($filePath);

        if (!$xml) {
            throw new \Exception('Invalid Blackboard XML file');
        }

        return $this->parseXml($xml, $group, $userId);
    }

    /**
     * Parse Blackboard XML
     */
    private function parseXml(\SimpleXMLElement $xml, QuestionGroup $group, int $userId): Collection
    {
        $questions = collect();

        // Blackboard stores questions dalam assessment items
        $namespace = $xml->getNamespaces(true);
        $items = $xml->xpath('//item');

        foreach ($items as $item) {
            // Skip non-question items
            if (!isset($item->presentation->material->text)) {
                continue;
            }

            $question = $this->parseQuestionItem($item, $group, $userId, $namespace);
            if ($question) {
                $questions->push($question);
            }
        }

        return $questions;
    }

    /**
     * Parse single question item
     */
    private function parseQuestionItem(
        \SimpleXMLElement $item,
        QuestionGroup $group,
        int $userId,
        array $namespace
    ): ?Question {
        try {
            // Extract question text
            $questionText = (string)$item->presentation->material->text;

            // Determine question type
            $questionType = $this->getQuestionType($item);

            // Extract responses
            $responses = $this->extractResponses($item);

            if (empty($responses)) {
                return null;
            }

            // Create question
            $question = Question::create([
                'question_group_id' => $group->id,
                'user_id' => $userId,
                'content' => $questionText,
                'question_type' => $questionType,
                'points' => $group->points_per_question ?? 1,
                'difficulty_level' => 'medium',
            ]);

            // Create options
            $order = 1;
            foreach ($responses as $response) {
                $question->options()->create([
                    'content' => $response['text'],
                    'order_index' => $order,
                    'is_correct' => $response['is_correct'] ?? false,
                ]);
                $order++;
            }

            return $question;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Determine question type from XML structure
     */
    private function getQuestionType(\SimpleXMLElement $item): string
    {
        $resProcessing = $item->resprocessing;

        // Check if multiple choice (multiple responses possible = true)
        if (isset($resProcessing) && (string)$item->attributes()->maxattempts) {
            return 'multiple_choice';
        }

        return 'multiple_choice';
    }

    /**
     * Extract response options
     */
    private function extractResponses(\SimpleXMLElement $item): array
    {
        $responses = [];

        // Blackboard stores responses dalam answer_allresponses
        $answerElements = $item->xpath('.//answer');

        foreach ($answerElements as $answer) {
            $response = [
                'text' => (string)$answer->material->text ?? (string)$answer->content,
                'is_correct' => false,
            ];

            // Check if this is correct answer
            if (isset($answer->attributes()->fraction) && (int)$answer->attributes()->fraction > 0) {
                $response['is_correct'] = true;
            }

            $responses[] = $response;
        }

        // If no answers found, try alternative structure
        if (empty($responses)) {
            $responseChoices = $item->xpath('.//response_choice');
            foreach ($responseChoices as $choice) {
                $responses[] = [
                    'text' => (string)$choice,
                    'is_correct' => false,
                ];
            }
        }

        return $responses;
    }
}
