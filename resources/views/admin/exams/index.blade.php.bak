@extends('layouts.admin')

@section('title', 'Exams')
@section('page-title', 'Exam Management')
@section('page-subtitle', 'Manage all exams and their settings')

@section('content')
<div>
    <!-- Header with Create Button -->
    <div class="flex justify-between items-center mb-6">
        <div></div>
        <a href="{{ route('admin.exams.create') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all flex items-center">
            <i class="fas fa-plus mr-2"></i> New Exam
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('admin.exams.index') }}" class="flex gap-4">
            <input type="text" name="search" placeholder="Search exam..." value="{{ request('search') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 flex-1">
            <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Types</option>
                <option value="test" {{ request('type') === 'test' ? 'selected' : '' }}>Test</option>
                <option value="quiz" {{ request('type') === 'quiz' ? 'selected' : '' }}>Quiz</option>
                <option value="assignment" {{ request('type') === 'assignment' ? 'selected' : '' }}>Assignment</option>
                <option value="final_exam" {{ request('type') === 'final_exam' ? 'selected' : '' }}>Final Exam</option>
            </select>
            <button type="submit" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-all">
                <i class="fas fa-search"></i> Search
            </button>
        </form>
    </div>

    <!-- Exams Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Exam Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jenjang</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Duration</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Created By</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($exams as $exam)
                    <tr class="hover:bg-gray-50 transition-all">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $exam->exam_name }}</p>
                                <p class="text-sm text-gray-500">{{ $exam->description ? substr($exam->description, 0, 50) . '...' : '-' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $exam->exam_type === 'test' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $exam->exam_type === 'quiz' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $exam->exam_type === 'assignment' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $exam->exam_type === 'final_exam' ? 'bg-red-100 text-red-800' : '' }}
                            ">
                                {{ ucfirst($exam->exam_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $exam->jenjang }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $exam->duration }} min</td>
                        <td class="px-6 py-4">
                            @if ($exam->is_published)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Published
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-times-circle mr-1"></i> Draft
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $exam->creator->name }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.exams.show', $exam) }}" class="p-2 hover:bg-blue-100 text-blue-600 rounded transition-all" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.exams.edit', $exam) }}" class="p-2 hover:bg-green-100 text-green-600 rounded transition-all" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.exams.results', $exam) }}" class="p-2 hover:bg-purple-100 text-purple-600 rounded transition-all" title="Results">
                                    <i class="fas fa-chart-bar"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.exams.destroy', $exam) }}" style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 hover:bg-red-100 text-red-600 rounded transition-all" title="Delete" onclick="return confirmDelete('Delete this exam?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2 block opacity-50"></i>
                            <p>No exams found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $exams->links() }}
    </div>
</div>
@endsection
