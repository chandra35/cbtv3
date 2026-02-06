@extends('layouts.admin')
@section('title', 'Create Question Group')
@section('page-title', 'Create Question Group')
@section('page-subtitle', $exam->exam_name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.question-groups.store', $exam) }}" method="POST" class="p-6">
            @csrf

            <!-- Basic Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    Basic Information
                </h3>

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Group Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" 
                        value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                        placeholder="e.g., Multiple Choice, Essay, Fill in the Blank" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description" name="description" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                        placeholder="Optional: Describe this question group"
                        rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <hr class="my-8">

            <!-- Group Settings -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-sliders-h text-purple-500 mr-2"></i>
                    Group Settings
                </h3>

                <div class="space-y-4">
                    <!-- Randomize Questions -->
                    <div class="flex items-center">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="randomize_questions" value="1"
                                {{ old('randomize_questions') ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-500 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="ml-3">
                                <span class="text-sm font-medium text-gray-700">Randomize Question Order</span>
                                <p class="text-xs text-gray-500">Questions will appear in random order to each student</p>
                            </span>
                        </label>
                    </div>

                    <!-- Randomize Options -->
                    <div class="flex items-center">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="randomize_options" value="1"
                                {{ old('randomize_options') ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-500 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="ml-3">
                                <span class="text-sm font-medium text-gray-700">Randomize Answer Options</span>
                                <p class="text-xs text-gray-500">Answer options will appear in random order for multiple choice questions</p>
                            </span>
                        </label>
                    </div>

                    <!-- Questions Per Page -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <label for="show_questions_per_page" class="block text-sm font-medium text-gray-700 mb-2">
                            Questions Per Page
                        </label>
                        <input type="number" id="show_questions_per_page" name="show_questions_per_page" 
                            value="{{ old('show_questions_per_page') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('show_questions_per_page') border-red-500 @enderror"
                            placeholder="Leave empty to show all" min="1" max="50">
                        <p class="mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Specify how many questions to display per page during the exam
                        </p>
                        @error('show_questions_per_page')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="my-8">

            <!-- Form Actions -->
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-200 font-medium">
                    <i class="fas fa-save mr-2"></i>Create Group
                </button>
                <a href="{{ route('admin.exams.show', $exam) }}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition duration-200 font-medium">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
