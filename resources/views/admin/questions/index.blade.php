@extends('layouts.admin')
@section('title', $group->name . ' - Questions')
@section('page-title', 'Questions')
@section('page-subtitle', $group->name)

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Questions</h2>
                <p class="text-gray-600 mt-1">{{ $questions->total() }} questions</p>
            </div>
            <a href="{{ route('admin.questions.create', $group) }}" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-medium">
                <i class="fas fa-plus mr-2"></i>Add Question
            </a>
        </div>

        <!-- Breadcrumb -->
        <div class="text-sm text-gray-600 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.exams.index') }}" class="text-blue-500 hover:underline">Exams</a>
            <span class="mx-2">/</span>
            <a href="{{ route('admin.exams.show', $exam) }}" class="text-blue-500 hover:underline">{{ $exam->exam_name }}</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">{{ $group->name }}</span>
        </div>
    </div>

    <!-- Questions List -->
    @if($questions->count() > 0)
        <div class="space-y-4">
            @foreach($questions as $question)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="inline-block px-2 py-1 rounded text-xs font-medium
                                @if($question->difficulty_level === 'easy') bg-green-100 text-green-800
                                @elseif($question->difficulty_level === 'medium') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($question->difficulty_level) }}
                            </span>
                            <span class="inline-block px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                {{ str_replace('_', ' ', ucfirst($question->question_type)) }}
                            </span>
                            <span class="text-sm font-semibold text-gray-900">{{ $question->point }} pts</span>
                        </div>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">
                            {{ Str::limit($question->content, 150) }}
                        </h4>

                        @if($question->instructions)
                            <p class="text-sm text-gray-600 mb-2">
                                <i class="fas fa-sticky-note mr-1"></i>
                                {{ Str::limit($question->instructions, 100) }}
                            </p>
                        @endif
                    </div>

                    <div class="flex gap-2 ml-4">
                        <a href="{{ route('admin.questions.edit', $question) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                        <button onclick="confirmDelete('{{ route('admin.questions.destroy', $question) }}')" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm">
                            <i class="fas fa-trash mr-2"></i>Delete
                        </button>
                    </div>
                </div>

                <!-- Question Options (for multiple choice/true false) -->
                @if($question->options->count() > 0)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-xs font-semibold text-gray-700 uppercase mb-2">Answer Options:</p>
                        <div class="space-y-2">
                            @foreach($question->options as $option)
                                <div class="text-sm text-gray-600 flex items-center">
                                    <span class="inline-block w-5 h-5 rounded-full 
                                        @if($option->is_correct) bg-green-500 text-white
                                        @else bg-gray-200 text-gray-700 @endif 
                                        flex items-center justify-center text-xs font-bold mr-2">
                                        {{ chr(64 + $loop->iteration) }}
                                    </span>
                                    <span>{{ Str::limit($option->option_text, 60) }}</span>
                                    @if($option->is_correct)
                                        <span class="ml-2 text-xs font-semibold text-green-600">
                                            <i class="fas fa-check"></i> Correct
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Metadata -->
                <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center text-xs text-gray-500">
                    <span>Created by {{ $question->creator->name ?? 'N/A' }}</span>
                    <span>{{ $question->created_at->format('d M Y H:i') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $questions->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-inbox text-6xl opacity-50"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Questions Yet</h3>
            <p class="text-gray-600 mb-6">Create your first question in this group to get started.</p>
            <a href="{{ route('admin.questions.create', $group) }}" class="inline-block px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-medium">
                <i class="fas fa-plus mr-2"></i>Create First Question
            </a>
        </div>
    @endif

    <!-- Back Link -->
    <div class="mt-6">
        <a href="{{ route('admin.exams.show', $exam) }}" class="text-blue-500 hover:text-blue-600 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Back to Exam
        </a>
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
    if (confirm('Are you sure you want to delete this question?')) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection
@endsection
