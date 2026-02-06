@extends('layouts.admin')
@section('title', 'Edit Question')
@section('page-title', 'Edit Question')
@section('page-subtitle', Str::limit($question->content, 50))

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.questions.update', $question) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <!-- Question Type Display -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-list-ul text-blue-500 mr-2"></i>
                    Question Type
                </h3>

                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Type:</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ str_replace('_', ' ', ucfirst($question->question_type)) }}
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Question type cannot be changed after creation
                    </p>
                </div>
            </div>

            <hr class="my-8">

            <!-- Question Content -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-edit text-purple-500 mr-2"></i>
                    Question Content
                </h3>

                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Question Text <span class="text-red-500">*</span>
                    </label>
                    <textarea id="content" name="content" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror"
                        placeholder="Enter the question text here"
                        rows="6" required>{{ old('content', $question->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Difficulty Level -->
                    <div>
                        <label for="difficulty_level" class="block text-sm font-medium text-gray-700 mb-2">
                            Difficulty <span class="text-red-500">*</span>
                        </label>
                        <select id="difficulty_level" name="difficulty_level"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('difficulty_level') border-red-500 @enderror"
                            required>
                            <option value="easy" {{ old('difficulty_level', $question->difficulty_level) === 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ old('difficulty_level', $question->difficulty_level) === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="hard" {{ old('difficulty_level', $question->difficulty_level) === 'hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                        @error('difficulty_level')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Points -->
                    <div>
                        <label for="point" class="block text-sm font-medium text-gray-700 mb-2">
                            Points <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="point" name="point" 
                            value="{{ old('point', $question->point) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('point') border-red-500 @enderror"
                            placeholder="10" min="0" max="1000" step="0.5" required>
                        @error('point')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="my-8">

            <!-- Additional Options -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-cog text-green-500 mr-2"></i>
                    Additional Options
                </h3>

                <div class="mb-6">
                    <label for="instructions" class="block text-sm font-medium text-gray-700 mb-2">
                        Instructions
                    </label>
                    <textarea id="instructions" name="instructions" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Special instructions for this question (optional)"
                        rows="3">{{ old('instructions', $question->instructions) }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="explanation" class="block text-sm font-medium text-gray-700 mb-2">
                        Explanation
                    </label>
                    <textarea id="explanation" name="explanation" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Explanation shown after student completes the question"
                        rows="3">{{ old('explanation', $question->explanation) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Image URL -->
                    <div>
                        <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">
                            Image URL
                        </label>
                        <input type="url" id="image_url" name="image_url" 
                            value="{{ old('image_url', $question->image_url) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="https://example.com/image.jpg">
                    </div>

                    <!-- Randomize -->
                    <div class="flex items-end">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_randomized" value="1"
                                {{ old('is_randomized', $question->is_randomized) ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-500 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">Randomize options</span>
                        </label>
                    </div>
                </div>
            </div>

            <hr class="my-8">

            <!-- Existing Options (if any) -->
            @if($question->options->count() > 0)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-list-check text-yellow-500 mr-2"></i>
                        Answer Options
                    </h3>

                    <div class="space-y-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        @foreach($question->options as $option)
                            <div class="flex items-center justify-between p-3 bg-white rounded border border-gray-200">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ Str::limit($option->option_text, 100) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        @if($option->is_correct)
                                            <span class="text-green-600">✓ Correct Answer</span>
                                        @else
                                            <span>Incorrect</span>
                                        @endif
                                    </p>
                                </div>
                                <a href="{{ route('admin.question-options.edit', $option) }}" class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition">
                                    Edit
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('admin.question-options.create', ['question' => $question]) }}" class="mt-4 text-blue-500 hover:text-blue-600 font-medium">
                        <i class="fas fa-plus mr-2"></i>Add Another Option
                    </a>
                </div>

                <hr class="my-8">
            @endif

            <!-- Form Actions -->
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200 font-medium">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
                <a href="{{ route('admin.questions.index', $question->questionGroup) }}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition duration-200 font-medium">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
