@extends('layouts.admin')
@section('title', $exam->exam_name . ' - Question Groups')
@section('page-title', 'Question Groups')
@section('page-subtitle', $exam->exam_name)

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Question Groups</h2>
                <p class="text-gray-600 mt-1">{{ $groups->total() }} groups total</p>
            </div>
            <a href="{{ route('admin.question-groups.create', $exam) }}" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-medium">
                <i class="fas fa-plus mr-2"></i>Add Question Group
            </a>
        </div>
    </div>

    <!-- Groups List -->
    @if($groups->count() > 0)
        <div class="space-y-4">
            @foreach($groups as $group)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                Group {{ $group->order_index }}
                            </span>
                            <h3 class="text-xl font-semibold text-gray-900">{{ $group->name }}</h3>
                        </div>
                        @if($group->description)
                            <p class="text-gray-600 mt-2">{{ $group->description }}</p>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.question-groups.edit', $group) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                        <button onclick="confirmDelete('{{ route('admin.question-groups.destroy', $group) }}')" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm">
                            <i class="fas fa-trash mr-2"></i>Delete
                        </button>
                    </div>
                </div>

                <!-- Group Statistics -->
                <div class="grid grid-cols-4 gap-4 mt-4 pt-4 border-t border-gray-200">
                    <div>
                        <p class="text-sm text-gray-600">Questions</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $group->questions->count() }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Points</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $group->questions->sum('point') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Randomize</p>
                        <p class="text-sm">
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-medium {{ $group->randomize_questions ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $group->randomize_questions ? 'Yes' : 'No' }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Created By</p>
                        <p class="text-sm font-medium text-gray-900">{{ $group->creator->name ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Question Preview -->
                @if($group->questions->count() > 0)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-sm font-semibold text-gray-700 mb-3">Latest Questions:</p>
                        <div class="space-y-2">
                            @foreach($group->questions->take(3) as $question)
                                <div class="text-sm text-gray-600 flex items-start">
                                    <span class="inline-block w-6 h-6 rounded-full bg-gray-100 text-center text-xs font-medium text-gray-700 mr-2">
                                        {{ $loop->iteration }}
                                    </span>
                                    <span>{{ Str::limit($question->question_text, 80) }}</span>
                                </div>
                            @endforeach
                            @if($group->questions->count() > 3)
                                <p class="text-sm text-gray-500 italic">+ {{ $group->questions->count() - 3 }} more questions</p>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Group Actions -->
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.questions.index', ['group' => $group]) }}" class="text-blue-500 hover:text-blue-600 font-medium text-sm">
                        <i class="fas fa-list mr-2"></i>View All Questions
                    </a>
                    <span class="text-gray-300 mx-2">•</span>
                    <a href="{{ route('admin.questions.create', ['group' => $group]) }}" class="text-green-500 hover:text-green-600 font-medium text-sm">
                        <i class="fas fa-plus mr-2"></i>Add Question
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $groups->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-inbox text-6xl opacity-50"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Question Groups Yet</h3>
            <p class="text-gray-600 mb-6">Create your first question group to start adding questions to this exam.</p>
            <a href="{{ route('admin.question-groups.create', $exam) }}" class="inline-block px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-medium">
                <i class="fas fa-plus mr-2"></i>Create First Group
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
    if (confirm('Are you sure you want to delete this question group? All questions in this group will also be deleted.')) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection
@endsection
