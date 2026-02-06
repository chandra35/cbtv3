<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamParticipant;
use App\Models\Question;
use App\Models\CBTActivityLog;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function index()
    {
        // Total statistics
        $totalExams = Exam::count();
        $publishedExams = Exam::where('is_published', true)->count();
        $totalQuestions = Question::count();
        $totalParticipants = ExamParticipant::count();

        // Recent exams
        $recentExams = Exam::with('creator')
            ->latest()
            ->limit(5)
            ->get();

        // Active exams (ongoing)
        $activeExams = Exam::where('is_published', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->count();

        // Average score
        $averageScore = ExamParticipant::whereNotNull('score')
            ->average('score') ?? 0;

        // Participants by status
        $statusStats = ExamParticipant::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Status labels
        $statusLabels = [
            'not_started' => ['label' => 'Not Started', 'color' => '#6c757d'],
            'in_progress' => ['label' => 'In Progress', 'color' => '#0dcaf0'],
            'submitted' => ['label' => 'Submitted', 'color' => '#0d6efd'],
            'graded' => ['label' => 'Graded', 'color' => '#198754'],
            'completed' => ['label' => 'Completed', 'color' => '#ffc107'],
        ];

        // Exams by status
        $examsByStatus = [];
        foreach ($statusLabels as $status => $info) {
            $examsByStatus[$status] = ExamParticipant::where('status', $status)->count();
        }

        // Recent activities
        $recentActivities = CBTActivityLog::with('exam', 'user')
            ->latest()
            ->limit(10)
            ->get();

        // Exams by type
        $examsByType = Exam::selectRaw('exam_type, COUNT(*) as count')
            ->groupBy('exam_type')
            ->get()
            ->pluck('count', 'exam_type')
            ->toArray();

        // Top performing exams (by average score)
        $topExams = Exam::with('participants')
            ->get()
            ->map(function ($exam) {
                $avgScore = $exam->participants()
                    ->whereNotNull('score')
                    ->average('score') ?? 0;
                return [
                    'id' => $exam->id,
                    'name' => $exam->exam_name,
                    'avg_score' => round($avgScore, 2),
                    'participants' => $exam->participants()->count(),
                ];
            })
            ->sortByDesc('avg_score')
            ->take(5)
            ->values();

        return view('admin.dashboard', compact(
            'totalExams',
            'publishedExams',
            'totalQuestions',
            'totalParticipants',
            'recentExams',
            'activeExams',
            'averageScore',
            'statusStats',
            'recentActivities',
            'examsByType',
            'topExams',
            'statusLabels',
            'examsByStatus'
        ));
    }
}
