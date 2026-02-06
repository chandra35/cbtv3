<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\MobileAppSetting;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of exams
     */
    public function index()
    {
        $exams = Exam::with('creator', 'mobileSettings')
            ->latest()
            ->paginate(15);

        return view('admin.exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new exam
     */
    public function create()
    {
        return view('admin.exams.create');
    }

    /**
     * Store a newly created exam in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_name' => 'required|string|max:255',
            'exam_type' => 'required|in:test,quiz,assignment,final_exam',
            'description' => 'nullable|string',
            'jenjang' => 'required|in:SD,SMP,SMA,Madrasah',
            'duration' => 'required|integer|min:1',
            'passing_grade' => 'required|numeric|min:0|max:100',
            'passing_message' => 'nullable|string',
            'failing_message' => 'nullable|string',
            'show_answers_after' => 'boolean',
            'allow_review_before_submit' => 'boolean',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'is_published' => 'boolean',
        ]);

        $exam = Exam::create(array_merge($validated, [
            'user_id' => auth()->id(),
        ]));

        // Create default mobile settings
        MobileAppSetting::create([
            'exam_id' => $exam->id,
            'enable_password_protection' => false,
            'max_idle_time' => 300,
            'prevent_screenshot' => false,
            'prevent_screen_recording' => false,
            'prevent_app_switching' => false,
            'enable_camera_monitoring' => false,
            'require_face_detection' => false,
            'disable_copy_paste' => false,
            'disable_dev_tools' => false,
            'lock_device_orientation' => false,
        ]);

        return redirect()->route('admin.exams.show', $exam)
            ->with('success', 'Exam created successfully');
    }

    /**
     * Display the specified exam
     */
    public function show(Exam $exam)
    {
        $exam->load('questionGroups.questions', 'mobileSettings');

        return view('admin.exams.show', compact('exam'));
    }

    /**
     * Show the form for editing the specified exam
     */
    public function edit(Exam $exam)
    {
        return view('admin.exams.edit', compact('exam'));
    }

    /**
     * Update the specified exam in storage
     */
    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'exam_name' => 'required|string|max:255',
            'exam_type' => 'required|in:test,quiz,assignment,final_exam',
            'description' => 'nullable|string',
            'jenjang' => 'required|in:SD,SMP,SMA,Madrasah',
            'duration' => 'required|integer|min:1',
            'passing_grade' => 'required|numeric|min:0|max:100',
            'passing_message' => 'nullable|string',
            'failing_message' => 'nullable|string',
            'show_answers_after' => 'boolean',
            'allow_review_before_submit' => 'boolean',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'is_published' => 'boolean',
        ]);

        $exam->update($validated);

        return redirect()->route('admin.exams.show', $exam)
            ->with('success', 'Exam updated successfully');
    }

    /**
     * Delete the specified exam
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam deleted successfully');
    }

    /**
     * Publish exam
     */
    public function publish(Exam $exam)
    {
        $exam->update(['is_published' => true]);

        return redirect()->back()->with('success', 'Exam published');
    }

    /**
     * Unpublish exam
     */
    public function unpublish(Exam $exam)
    {
        $exam->update(['is_published' => false]);

        return redirect()->back()->with('success', 'Exam unpublished');
    }

    /**
     * Show exam results/analytics
     */
    public function results(Exam $exam)
    {
        $participants = $exam->participants()
            ->with('user:id,name,email')
            ->get()
            ->map(function ($participant) {
                return [
                    'user_name' => $participant->user->name,
                    'user_email' => $participant->user->email,
                    'status' => $participant->status,
                    'score' => $participant->score,
                    'percentage' => $participant->percentage,
                    'started_at' => $participant->started_at,
                    'submitted_at' => $participant->submitted_at,
                    'time_taken' => $participant->submitted_at ? 
                        $participant->submitted_at->diffInMinutes($participant->started_at) . ' min' : 'In Progress',
                ];
            });

        return view('admin.exams.results', compact('exam', 'participants'));
    }
}
