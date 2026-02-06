@extends('layouts.admin')

@section('title', 'Ujian')
@section('page-title', 'Manajemen Ujian')
@section('page-subtitle', 'Kelola semua ujian dan pengaturannya')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Daftar Ujian</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.exams.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Ujian Baru
                    </a>
                </div>
            </div>

            <div class="card-body">
                <!-- Filters -->
                <form method="GET" action="{{ route('admin.exams.index') }}" class="form-inline mb-3">
                    <div class="form-group mr-2">
                        <input type="text" name="search" placeholder="Cari ujian..." value="{{ request('search') }}" class="form-control form-control-sm">
                    </div>
                    <div class="form-group mr-2">
                        <select name="type" class="form-control form-control-sm">
                            <option value="">Semua Tipe</option>
                            <option value="test" {{ request('type') === 'test' ? 'selected' : '' }}>Tes</option>
                            <option value="quiz" {{ request('type') === 'quiz' ? 'selected' : '' }}>Kuis</option>
                            <option value="assignment" {{ request('type') === 'assignment' ? 'selected' : '' }}>Tugas</option>
                            <option value="final_exam" {{ request('type') === 'final_exam' ? 'selected' : '' }}>Ujian Akhir</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-default btn-sm">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </form>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 25%">Nama Ujian</th>
                                <th style="width: 10%">Tipe</th>
                                <th style="width: 10%">Jenjang</th>
                                <th style="width: 8%">Durasi</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 15%">Dibuat Oleh</th>
                                <th style="width: 12%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($exams as $exam)
                                <tr>
                                    <td>
                                        <strong>{{ $exam->exam_name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($exam->description ?? '-', 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ ucfirst($exam->exam_type) }}</span>
                                    </td>
                                    <td>{{ $exam->jenjang ?? '-' }}</td>
                                    <td>{{ $exam->duration }} menit</td>
                                    <td>
                                        @if ($exam->is_published)
                                            <span class="badge badge-success">Terpublikasi</span>
                                        @else
                                            <span class="badge badge-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td><small>{{ $exam->creator?->name ?? '-' }}</small></td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.exams.show', $exam->id) }}" class="btn btn-info btn-xs" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.exams.edit', $exam->id) }}" class="btn btn-warning btn-xs" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-xs" onclick="return confirmDelete('{{ route('admin.exams.destroy', $exam->id) }}', 'Hapus ujian ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox mr-2"></i> Tidak ada ujian ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($exams->count())
                    <div class="mt-3">
                        {{ $exams->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
