@extends('layouts.admin')

@section('title', 'Exam Results')
@section('page-title', 'Exam Results')
@section('page-subtitle', 'Exam: ' . $exam->exam_name)

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Participants</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $participants->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Completed</p>
                    <p class="text-3xl font-bold text-green-600">{{ $participants->where('status', 'completed')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Average Score</p>
                    <p class="text-3xl font-bold text-purple-600">{{ number_format($participants->avg('percentage') ?? 0, 1) }}%</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-bar text-purple-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Pass Rate</p>
                    <p class="text-3xl font-bold text-orange-600">{{ number_format($participants->where('percentage', '>=', $exam->passing_grade)->count() / max($participants->count(), 1) * 100, 1) }}%</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-percent text-orange-600 text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Detailed Results</h3>
        </div>

        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Student Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Score</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Percentage</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Result</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Time Taken</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Submitted</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($participants as $participant)
                    <tr class="hover:bg-gray-50 transition-all">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $participant->user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $participant->user->email }}</td>
                        <td class="px-6 py-4">
                            @if ($participant->status === 'completed')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Completed
                                </span>
                            @elseif ($participant->status === 'in_progress')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-spinner mr-1"></i> In Progress
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-minus-circle mr-1"></i> {{ ucfirst($participant->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-lg font-bold text-gray-900">{{ $participant->score ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-32 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $participant->percentage ?? 0 }}%"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ number_format($participant->percentage ?? 0, 1) }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if ($participant->percentage >= $exam->passing_grade)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-thumbs-up mr-1"></i> Passed
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-thumbs-down mr-1"></i> Failed
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            @if ($participant->submitted_at && $participant->started_at)
                                {{ $participant->submitted_at->diffInMinutes($participant->started_at) }} min
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $participant->submitted_at ? $participant->submitted_at->format('d M Y H:i') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2 block opacity-50"></i>
                            <p>No participants yet</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Export Button -->
    <div class="flex gap-4">
        <button onclick="exportToCSV()" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all">
            <i class="fas fa-download mr-2"></i> Export to CSV
        </button>
        <a href="{{ route('admin.exams.index') }}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition-all">
            Back to Exams
        </a>
    </div>
</div>

@section('scripts')
<script>
function exportToCSV() {
    const table = document.querySelector('table');
    let csv = '';
    
    // Headers
    const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
    csv += headers.join(',') + '\n';
    
    // Rows
    table.querySelectorAll('tbody tr').forEach(tr => {
        const row = Array.from(tr.querySelectorAll('td')).map(td => {
            let text = td.textContent.trim();
            if (text.includes(',')) text = `"${text}"`;
            return text;
        });
        csv += row.join(',') + '\n';
    });
    
    // Download
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'exam-results-{{ $exam->id }}.csv';
    a.click();
}
</script>
@endsection

@endsection
