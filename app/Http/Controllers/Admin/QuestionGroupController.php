<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\QuestionGroup;
use Illuminate\Http\Request;

class QuestionGroupController extends Controller
{
    /**
     * Display a listing of question groups for an exam
     */
    public function index(Exam $exam)
    {
        $groups = $exam->questionGroups()
            ->with('creator')
            ->orderBy('order_index')
            ->paginate(15);

        return view('admin.question-groups.index', compact('exam', 'groups'));
    }

    /**
     * Show the form for creating a new question group
     */
    public function create(Exam $exam)
    {
        return view('admin.question-groups.create', compact('exam'));
    }

    /**
     * Store a newly created question group in storage
     */
    public function store(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'randomize_questions' => 'boolean',
            'randomize_options' => 'boolean',
            'show_questions_per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $maxOrder = $exam->questionGroups()->max('order_index') ?? 0;

        $group = $exam->questionGroups()->create(array_merge($validated, [
            'order_index' => $maxOrder + 1,
            'created_by' => auth()->id(),
        ]));

        return redirect()->route('admin.exams.show', $exam)
            ->with('success', 'Question group created successfully');
    }

    /**
     * Show the form for editing the specified question group
     */
    public function edit(QuestionGroup $questionGroup)
    {
        $exam = $questionGroup->exam;
        return view('admin.question-groups.edit', compact('questionGroup', 'exam'));
    }

    /**
     * Update the specified question group in storage
     */
    public function update(Request $request, QuestionGroup $questionGroup)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'randomize_questions' => 'boolean',
            'randomize_options' => 'boolean',
            'show_questions_per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $questionGroup->update($validated);

        return redirect()->route('admin.exams.show', $questionGroup->exam)
            ->with('success', 'Question group updated successfully');
    }

    /**
     * Remove the specified question group from storage
     */
    public function destroy(QuestionGroup $questionGroup)
    {
        $exam = $questionGroup->exam;
        
        // Delete all questions in this group
        $questionGroup->questions()->delete();
        
        // Delete the group
        $questionGroup->delete();

        return redirect()->route('admin.exams.show', $exam)
            ->with('success', 'Question group deleted successfully');
    }
}
