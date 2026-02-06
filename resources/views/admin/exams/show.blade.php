@extends('layouts.admin')
@section('title', $exam->exam_name)
@section('page-title', $exam->exam_name)
@section('page-subtitle', 'View and manage exam details')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header with Actions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $exam->exam_name }}</h2>
                <p class="text-gray-600 mt-1">
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                        @if($exam->exam_type === 'test') bg-blue-100 text-blue-800
                        @elseif($exam->exam_type === 'quiz') bg-purple-100 text-purple-800
                        @elseif($exam->exam_type === 'assignment') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $exam->exam_type)) }}
                    </span>
                    <span class="ml-3 inline-block px-3 py-1 rounded-full text-sm font-medium
                        {{ $exam->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $exam->is_published ? 'Published' : 'Draft' }}
                    </span>
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.exams.edit', $exam) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('admin.exams.results', $exam) }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    <i class="fas fa-chart-bar mr-2"></i>Results
                </a>
                <button onclick="confirmDelete('{{ route('admin.exams.destroy', $exam) }}')" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    <i class="fas fa-trash mr-2"></i>Delete
                </button>
            </div>
        </div>

        <!-- Exam Details Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6 pt-6 border-t border-gray-200">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Jenjang</p>
                <p class="text-lg font-medium text-gray-900">{{ $exam->jenjang }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Duration</p>
                <p class="text-lg font-medium text-gray-900">{{ $exam->duration }} min</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Passing Grade</p>
                <p class="text-lg font-medium text-gray-900">{{ $exam->passing_grade }}%</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Created By</p>
                <p class="text-lg font-medium text-gray-900">{{ $exam->creator->name ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Description -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-align-left text-blue-500 mr-2"></i>
                    Description
                </h3>
                <p class="text-gray-700">{{ $exam->description ?? 'No description provided' }}</p>
            </div>

            <!-- Schedule Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-calendar-alt text-purple-500 mr-2"></i>
                    Schedule
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Start</p>
                        <p class="text-lg text-gray-900">
                            {{ $exam->start_date?->format('d M Y') ?? 'N/A' }}<br>
                            <span class="text-sm text-gray-500">{{ $exam->start_time?->format('H:i') ?? 'N/A' }}</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">End</p>
                        <p class="text-lg text-gray-900">
                            {{ $exam->end_date?->format('d M Y') ?? 'N/A' }}<br>
                            <span class="text-sm text-gray-500">{{ $exam->end_time?->format('H:i') ?? 'N/A' }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-question-circle text-orange-500 mr-2"></i>
                        Question Groups
                    </h3>
                    <a href="{{ route('admin.question-groups.create', ['exam' => $exam]) }}" class="px-4 py-2 bg-green-500 text-white text-sm rounded-lg hover:bg-green-600 transition">
                        <i class="fas fa-plus mr-2"></i>Add Group
                    </a>
                </div>

                @if($exam->questionGroups->count() > 0)
                    <div class="space-y-3">
                        @foreach($exam->questionGroups as $group)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $group->group_name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $group->questions->count() }} questions • {{ $group->questions->sum('point') }} points</p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.question-groups.edit', $group) }}" class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition">
                                        Edit
                                    </a>
                                    <button onclick="confirmDelete('{{ route('admin.question-groups.destroy', $group) }}')" class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200 transition">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3 opacity-50 block"></i>
                        <p>No question groups yet</p>
                        <a href="{{ route('admin.question-groups.create', ['exam' => $exam]) }}" class="text-blue-500 hover:underline mt-2 inline-block">
                            Create your first group
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Mobile Settings -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-mobile-alt text-green-500 mr-2"></i>
                    Mobile Settings
                </h3>
                @if($exam->mobileSettings)
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Password Protected</span>
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-medium {{ $exam->mobileSettings->enable_password_protection ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $exam->mobileSettings->enable_password_protection ? 'Enabled' : 'Disabled' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Anti-Cheating</span>
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-medium 
                                {{ $exam->mobileSettings->prevent_screenshot || $exam->mobileSettings->prevent_app_switching || $exam->mobileSettings->prevent_screen_recording ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $exam->mobileSettings->prevent_screenshot || $exam->mobileSettings->prevent_app_switching || $exam->mobileSettings->prevent_screen_recording ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('admin.exams.mobile-settings', $exam) }}" class="block w-full mt-4 px-4 py-2 bg-blue-500 text-white text-center rounded-lg hover:bg-blue-600 transition text-sm">
                        <i class="fas fa-cog mr-2"></i>Configure
                    </a>
                @else
                    <p class="text-sm text-gray-500">No mobile settings configured</p>
                @endif
            </div>

            <!-- Messages -->
            @if($exam->passing_message || $exam->failing_message)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-comments text-yellow-500 mr-2"></i>
                    Messages
                </h3>
                @if($exam->passing_message)
                <div class="mb-4">
                    <p class="text-xs font-semibold text-green-600 uppercase mb-2">✓ Pass Message</p>
                    <p class="text-sm text-gray-700">{{ $exam->passing_message }}</p>
                </div>
                @endif
                @if($exam->failing_message)
                <div>
                    <p class="text-xs font-semibold text-red-600 uppercase mb-2">✗ Fail Message</p>
                    <p class="text-sm text-gray-700">{{ $exam->failing_message }}</p>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@section('scripts')
<script>
function confirmDelete(url) {
    if (confirm('Are you sure you want to delete this exam? This action cannot be undone.')) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection
@endsection
