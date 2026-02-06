<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionGroup;
use App\Models\ImportJob;
use App\Models\ImportLog;
use App\Services\Import\WordImporter;
use App\Services\Import\TxtImporter;
use App\Services\Import\BlackboardImporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionImportController extends Controller
{
    /**
     * Show import form
     */
    public function create(QuestionGroup $group)
    {
        return view('admin.imports.create', compact('group'));
    }

    /**
     * Handle file upload dan import
     */
    public function store(Request $request, QuestionGroup $group)
    {
        $validated = $request->validate([
            'import_file' => 'required|file|mimes:docx,txt,xml|max:10240',
            'import_type' => 'required|in:word,txt,blackboard',
        ]);

        // Create import job record
        $importJob = ImportJob::create([
            'question_group_id' => $group->id,
            'user_id' => auth()->id(),
            'import_type' => $validated['import_type'],
            'status' => 'pending',
            'file_path' => '',
        ]);

        try {
            // Store file
            $filePath = $request->file('import_file')->store('imports');
            $importJob->update(['file_path' => $filePath]);

            // Process import based on type
            $importer = $this->getImporter($validated['import_type']);
            $questions = $importer->import(
                Storage::path($filePath),
                $group,
                auth()->id()
            );

            // Log results
            $importJob->update([
                'status' => 'completed',
                'total_questions' => $questions->count(),
                'imported_at' => now(),
            ]);

            return redirect()->route('admin.groups.show', $group)
                ->with('success', 'Questions imported successfully. Total: ' . $questions->count());
        } catch (\Exception $e) {
            // Log error
            ImportLog::create([
                'import_job_id' => $importJob->id,
                'error_message' => $e->getMessage(),
                'line_number' => null,
            ]);

            $importJob->update(['status' => 'failed']);

            return redirect()->back()
                ->withErrors(['import_file' => 'Import failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Get appropriate importer based on type
     */
    private function getImporter(string $type)
    {
        return match ($type) {
            'word' => new WordImporter(),
            'txt' => new TxtImporter(),
            'blackboard' => new BlackboardImporter(),
            default => throw new \Exception('Unknown import type'),
        };
    }

    /**
     * View import history
     */
    public function history(QuestionGroup $group)
    {
        $imports = $group->importJobs()
            ->with('user:id,name')
            ->latest()
            ->paginate(10);

        return view('admin.imports.history', compact('group', 'imports'));
    }

    /**
     * Show import job details
     */
    public function show(ImportJob $importJob)
    {
        $importJob->load('questionGroup', 'user', 'logs');

        return view('admin.imports.show', compact('importJob'));
    }

    /**
     * Delete imported questions
     */
    public function deleteImportedQuestions(ImportJob $importJob)
    {
        // Get all questions imported in this job
        $questions = $importJob->questionGroup->questions()
            ->where('created_at', '>=', $importJob->created_at)
            ->where('created_at', '<=', $importJob->imported_at ?? now())
            ->get();

        $count = 0;
        foreach ($questions as $question) {
            $question->options()->delete();
            $question->delete();
            $count++;
        }

        $importJob->update(['status' => 'deleted']);

        return redirect()->back()
            ->with('success', "Deleted {$count} questions from this import");
    }
}
