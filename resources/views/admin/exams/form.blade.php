@extends('layouts.admin')

@section('title', isset($exam) ? 'Edit Exam' : 'Create Exam')
@section('page-title', isset($exam) ? 'Edit Exam' : 'Create New Exam')
@section('page-subtitle', isset($exam) ? 'Update exam details' : 'Create a new exam')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ isset($exam) ? route('admin.exams.update', $exam) : route('admin.exams.store') }}" class="space-y-6">
        @csrf
        @if (isset($exam))
            @method('PUT')
        @endif

        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Exam Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Exam Name *</label>
                    <input type="text" name="exam_name" value="{{ old('exam_name', $exam->exam_name ?? '') }}" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('exam_name') ? 'border-red-500' : '' }}">
                    @error('exam_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Exam Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Exam Type *</label>
                    <select name="exam_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Type</option>
                        <option value="test" {{ old('exam_type', $exam->exam_type ?? '') === 'test' ? 'selected' : '' }}>Test</option>
                        <option value="quiz" {{ old('exam_type', $exam->exam_type ?? '') === 'quiz' ? 'selected' : '' }}>Quiz</option>
                        <option value="assignment" {{ old('exam_type', $exam->exam_type ?? '') === 'assignment' ? 'selected' : '' }}>Assignment</option>
                        <option value="final_exam" {{ old('exam_type', $exam->exam_type ?? '') === 'final_exam' ? 'selected' : '' }}>Final Exam</option>
                    </select>
                    @error('exam_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Jenjang -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenjang *</label>
                    <select name="jenjang" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Jenjang</option>
                        <option value="SD" {{ old('jenjang', $exam->jenjang ?? '') === 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ old('jenjang', $exam->jenjang ?? '') === 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ old('jenjang', $exam->jenjang ?? '') === 'SMA' ? 'selected' : '' }}>SMA</option>
                        <option value="Madrasah" {{ old('jenjang', $exam->jenjang ?? '') === 'Madrasah' ? 'selected' : '' }}>Madrasah</option>
                    </select>
                    @error('jenjang') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Duration -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Duration (minutes) *</label>
                    <input type="number" name="duration" value="{{ old('duration', $exam->duration ?? '') }}" required min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('duration') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $exam->description ?? '') }}</textarea>
            </div>
        </div>

        <!-- Scoring -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Scoring</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Passing Grade -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Passing Grade (%) *</label>
                    <input type="number" name="passing_grade" value="{{ old('passing_grade', $exam->passing_grade ?? '70') }}" required min="0" max="100"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('passing_grade') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Show Answers After -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <input type="checkbox" name="show_answers_after" value="1" {{ old('show_answers_after', $exam->show_answers_after ?? false) ? 'checked' : '' }}>
                        Show Answers After Submission
                    </label>
                </div>
            </div>

            <!-- Messages -->
            <div class="mt-4 grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Passing Message</label>
                    <textarea name="passing_message" rows="2" placeholder="Message shown when student passes" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('passing_message', $exam->passing_message ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Failing Message</label>
                    <textarea name="failing_message" rows="2" placeholder="Message shown when student fails" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('failing_message', $exam->failing_message ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Scheduling -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Scheduling</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Start Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date *</label>
                    <input type="date" name="start_date" value="{{ old('start_date', isset($exam) ? $exam->start_date->format('Y-m-d') : '') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- End Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date *</label>
                    <input type="date" name="end_date" value="{{ old('end_date', isset($exam) ? $exam->end_date->format('Y-m-d') : '') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Start Time -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Time *</label>
                    <input type="time" name="start_time" value="{{ old('start_time', isset($exam) ? $exam->start_time : '08:00') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('start_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- End Time -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Time *</label>
                    <input type="time" name="end_time" value="{{ old('end_time', isset($exam) ? $exam->end_time : '17:00') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('end_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all">
                <i class="fas fa-save mr-2"></i> {{ isset($exam) ? 'Update Exam' : 'Create Exam' }}
            </button>
            <a href="{{ route('admin.exams.index') }}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition-all">
                <i class="fas fa-times mr-2"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
