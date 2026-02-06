<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionGroup;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of questions for a group
     */
    public function index(QuestionGroup $group)
    {
        $questions = $group->questions()
            ->with('options', 'creator')
            ->paginate(15);

        $exam = $group->exam;

        return view('admin.questions.index', compact('group', 'exam', 'questions'));
    }

    /**
     * Show the form for creating a new question
     */
    public function create(QuestionGroup $group)
    {
        $exam = $group->exam;
        return view('admin.questions.create', compact('group', 'exam'));
    }

    /**
     * Store a newly created question in storage
     */
    public function store(Request $request, QuestionGroup $group)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,essay,fill_blank,matching',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'point' => 'required|numeric|min:0|max:1000',
            'instructions' => 'nullable|string',
            'explanation' => 'nullable|string',
            'image_url' => 'nullable|url',
            'is_randomized' => 'boolean',
        ]);

        $question = $group->questions()->create(array_merge($validated, [
            'created_by' => auth()->id(),
        ]));

        // Redirect to add options if multiple choice
        if (in_array($question->question_type, ['multiple_choice', 'matching', 'true_false'])) {
            return redirect()->route('admin.question-options.create', ['question' => $question])
                ->with('success', 'Question created. Now add the options.');
        }

        return redirect()->route('admin.questions.index', $group)
            ->with('success', 'Question created successfully');
    }

    /**
     * Show the form for editing the specified question
     */
    public function edit(Question $question)
    {
        $group = $question->questionGroup;
        $exam = $group->exam;
        
        return view('admin.questions.edit', compact('question', 'group', 'exam'));
    }

    /**
     * Update the specified question in storage
     */
    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,essay,fill_blank,matching',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'point' => 'required|numeric|min:0|max:1000',
            'instructions' => 'nullable|string',
            'explanation' => 'nullable|string',
            'image_url' => 'nullable|url',
            'is_randomized' => 'boolean',
        ]);

        $question->update($validated);

        return redirect()->route('admin.questions.index', $question->questionGroup)
            ->with('success', 'Question updated successfully');
    }

    /**
     * Remove the specified question from storage
     */
    public function destroy(Question $question)
    {
        $group = $question->questionGroup;
        
        // Delete all options
        $question->options()->delete();
        
        // Delete the question
        $question->delete();

        return redirect()->route('admin.questions.index', $group)
            ->with('success', 'Question deleted successfully');
    }
}
