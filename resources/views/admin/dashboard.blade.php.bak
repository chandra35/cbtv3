@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back! Here\'s your exam system overview')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Exams -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Exams</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalExams }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $publishedExams }} published</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-file-alt text-2xl text-blue-500"></i>
                </div>
            </div>
        </div>

        <!-- Active Exams -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Active Exams</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $activeExams }}</p>
                    <p class="text-xs text-gray-500 mt-1">Currently running</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-clock text-2xl text-green-500"></i>
                </div>
            </div>
        </div>

        <!-- Total Questions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Questions</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalQuestions }}</p>
                    <p class="text-xs text-gray-500 mt-1">In system</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-question-circle text-2xl text-purple-500"></i>
                </div>
            </div>
        </div>

        <!-- Total Participants -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Participants</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalParticipants }}</p>
                    <p class="text-xs text-gray-500 mt-1">All time</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-users text-2xl text-yellow-500"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Exams by Type and Statistics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Exams by Type -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-chart-pie text-blue-500 mr-2"></i>
                Exams by Type
            </h3>
            <div class="space-y-3">
                @if(!empty($examsByType))
                    @foreach($examsByType as $type => $count)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">
                            @if($type === 'test')
                                <i class="fas fa-check-circle text-blue-500 mr-2"></i>Tests
                            @elseif($type === 'quiz')
                                <i class="fas fa-lightbulb text-purple-500 mr-2"></i>Quizzes
                            @elseif($type === 'assignment')
                                <i class="fas fa-tasks text-green-500 mr-2"></i>Assignments
                            @else
                                <i class="fas fa-graduation-cap text-red-500 mr-2"></i>Final Exams
                            @endif
                        </span>
                        <span class="font-semibold text-gray-900">{{ $count }}</span>
                    </div>
                    @endforeach
                @else
                    <p class="text-sm text-gray-500">No exams yet</p>
                @endif
            </div>
        </div>

        <!-- Participant Status -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-chart-bar text-green-500 mr-2"></i>
                Participant Status
            </h3>
            <div class="space-y-3">
                @php
                    $statusLabels = [
                        'not_started' => ['label' => 'Not Started', 'color' => 'gray'],
                        'in_progress' => ['label' => 'In Progress', 'color' => 'blue'],
                        'submitted' => ['label' => 'Submitted', 'color' => 'green'],
                        'graded' => ['label' => 'Graded', 'color' => 'purple'],
                    ];
                @endphp
                @foreach($statusLabels as $status => $info)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">{{ $info['label'] }}</span>
                    <span class="font-semibold text-gray-900">{{ $statusStats[$status] ?? 0 }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Average Score -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-star text-yellow-500 mr-2"></i>
                Performance
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Average Score</p>
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-bold text-gray-900">{{ round($averageScore, 1) }}%</p>
                        <span class="text-xs text-gray-500">System Average</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-gradient-to-r from-red-500 to-green-500 h-2 rounded-full" style="width: {{ $averageScore }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Performing Exams and Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Top Exams -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                Top Performing Exams
            </h3>
            @if($topExams->count() > 0)
                <div class="space-y-3">
                    @foreach($topExams as $index => $exam)
                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                        <div class="flex items-center gap-3 flex-1">
                            <span class="inline-block w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 text-white flex items-center justify-center text-sm font-bold">
                                {{ $index + 1 }}
                            </span>
                            <div class="flex-1">
                                <a href="{{ route('admin.exams.show', $exam['id']) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                    {{ Str::limit($exam['name'], 40) }}
                                </a>
                                <p class="text-xs text-gray-500">{{ $exam['participants'] }} participants</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">{{ $exam['avg_score'] }}%</p>
                            <div class="w-16 bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-green-500 h-1 rounded-full" style="width: {{ $exam['avg_score'] }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500">No exams available yet</p>
            @endif
        </div>

        <!-- Recent Exams -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-history text-blue-500 mr-2"></i>
                Recent Exams
            </h3>
            @if($recentExams->count() > 0)
                <div class="space-y-3">
                    @foreach($recentExams as $exam)
                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition border-l-4 {{ $exam->is_published ? 'border-green-500' : 'border-yellow-500' }}">
                        <div class="flex-1">
                            <a href="{{ route('admin.exams.show', $exam) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 block">
                                {{ Str::limit($exam->exam_name, 40) }}
                            </a>
                            <p class="text-xs text-gray-500 mt-1">By {{ $exam->creator->name ?? 'Unknown' }}</p>
                        </div>
                        <span class="inline-block px-2 py-1 rounded-full text-xs font-medium {{ $exam->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $exam->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500">No exams created yet</p>
            @endif
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-list text-purple-500 mr-2"></i>
            Recent Activity
        </h3>
        @if($recentActivities->count() > 0)
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @foreach($recentActivities as $activity)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition border-l-2 border-gray-200">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ ucfirst(str_replace('_', ' ', $activity->action)) }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    @if($activity->exam)
                                        {{ $activity->exam->exam_name }}
                                    @endif
                                    @if($activity->user)
                                        • {{ $activity->user->name }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <span class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</span>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 text-center py-6">No recent activity</p>
        @endif
    </div>
</div>
@endsection
