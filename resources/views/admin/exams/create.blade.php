@extends('layouts.admin')
@section('title', 'Create Exam')
@section('page-title', 'Create New Exam')
@section('page-subtitle', 'Add a new exam to the system')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.exams.store') }}" method="POST" class="p-6">
            @csrf

            <!-- Basic Information Section -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    Basic Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Exam Name -->
                    <div>
                        <label for="exam_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Exam Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="exam_name" name="exam_name" 
                            value="{{ old('exam_name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('exam_name') border-red-500 @enderror"
                            placeholder="Enter exam name" required>
                        @error('exam_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Exam Type -->
                    <div>
                        <label for="exam_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Exam Type <span class="text-red-500">*</span>
                        </label>
                        <select id="exam_type" name="exam_type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('exam_type') border-red-500 @enderror"
                            required>
                            <option value="">Select exam type</option>
                            <option value="test" {{ old('exam_type') === 'test' ? 'selected' : '' }}>Test</option>
                            <option value="quiz" {{ old('exam_type') === 'quiz' ? 'selected' : '' }}>Quiz</option>
                            <option value="assignment" {{ old('exam_type') === 'assignment' ? 'selected' : '' }}>Assignment</option>
                            <option value="final_exam" {{ old('exam_type') === 'final_exam' ? 'selected' : '' }}>Final Exam</option>
                        </select>
                        @error('exam_type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenjang -->
                    <div>
                        <label for="jenjang" class="block text-sm font-medium text-gray-700 mb-2">
                            Education Level <span class="text-red-500">*</span>
                        </label>
                        <select id="jenjang" name="jenjang"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenjang') border-red-500 @enderror"
                            required>
                            <option value="">Select level</option>
                            <option value="SD" {{ old('jenjang') === 'SD' ? 'selected' : '' }}>SD (Elementary)</option>
                            <option value="SMP" {{ old('jenjang') === 'SMP' ? 'selected' : '' }}>SMP (Junior High)</option>
                            <option value="SMA" {{ old('jenjang') === 'SMA' ? 'selected' : '' }}>SMA (Senior High)</option>
                            <option value="Madrasah" {{ old('jenjang') === 'Madrasah' ? 'selected' : '' }}>Madrasah</option>
                        </select>
                        @error('jenjang')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                            Duration (minutes) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="duration" name="duration" 
                            value="{{ old('duration') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('duration') border-red-500 @enderror"
                            placeholder="60" min="1" required>
                        @error('duration')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description" name="description" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                        placeholder="Enter exam description" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <hr class="my-8">

            <!-- Scoring Section -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-chart-line text-green-500 mr-2"></i>
                    Scoring
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Passing Grade -->
                    <div>
                        <label for="passing_grade" class="block text-sm font-medium text-gray-700 mb-2">
                            Passing Grade (%) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="passing_grade" name="passing_grade" 
                            value="{{ old('passing_grade') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('passing_grade') border-red-500 @enderror"
                            placeholder="70" min="0" max="100" step="0.01" required>
                        @error('passing_grade')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Show Answers -->
                    <div class="flex items-end">
                        <label class="flex items-center">
                            <input type="checkbox" name="show_answers_after" value="1" 
                                {{ old('show_answers_after') ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-500 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Show answers after completion</span>
                        </label>
                    </div>

                    <!-- Allow Review -->
                    <div class="flex items-end">
                        <label class="flex items-center">
                            <input type="checkbox" name="allow_review_before_submit" value="1"
                                {{ old('allow_review_before_submit') ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-500 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Allow review before submit</span>
                        </label>
                    </div>
                </div>

                <!-- Messages -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Passing Message -->
                    <div>
                        <label for="passing_message" class="block text-sm font-medium text-gray-700 mb-2">
                            Message on Pass
                        </label>
                        <textarea id="passing_message" name="passing_message"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Congratulations! You passed the exam."
                            rows="3">{{ old('passing_message') }}</textarea>
                    </div>

                    <!-- Failing Message -->
                    <div>
                        <label for="failing_message" class="block text-sm font-medium text-gray-700 mb-2">
                            Message on Fail
                        </label>
                        <textarea id="failing_message" name="failing_message"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Unfortunately, you did not pass. Please try again."
                            rows="3">{{ old('failing_message') }}</textarea>
                    </div>
                </div>
            </div>

            <hr class="my-8">

            <!-- Scheduling Section -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-calendar-alt text-purple-500 mr-2"></i>
                    Schedule
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Start Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="start_date" name="start_date" 
                            value="{{ old('start_date') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('start_date') border-red-500 @enderror"
                            required>
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                            End Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="end_date" name="end_date" 
                            value="{{ old('end_date') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('end_date') border-red-500 @enderror"
                            required>
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Time -->
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Start Time <span class="text-red-500">*</span>
                        </label>
                        <input type="time" id="start_time" name="start_time" 
                            value="{{ old('start_time') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('start_time') border-red-500 @enderror"
                            required>
                        @error('start_time')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Time -->
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                            End Time <span class="text-red-500">*</span>
                        </label>
                        <input type="time" id="end_time" name="end_time" 
                            value="{{ old('end_time') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('end_time') border-red-500 @enderror"
                            required>
                        @error('end_time')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="my-8">

            <!-- Publish Status -->
            <div class="mb-8">
                <div class="flex items-center">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1"
                            {{ old('is_published') ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-500 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <span class="ml-2 text-sm font-medium text-gray-700">Publish immediately</span>
                    </label>
                </div>
                <p class="mt-2 text-sm text-gray-500">Leave unchecked to save as draft</p>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200 font-medium">
                    <i class="fas fa-save mr-2"></i>Create Exam
                </button>
                <a href="{{ route('admin.exams.index') }}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition duration-200 font-medium">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
