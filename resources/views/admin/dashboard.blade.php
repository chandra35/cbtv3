@extends('layouts.admin')

@section('page-title', 'Dasbor')

@section('content')
<!-- Statistics Cards Row -->
<div class="row">
    <!-- Total Exams -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalExams }}</h3>
                <p>Total Ujian</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <a href="{{ route('admin.exams.index') }}" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Active Exams -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $activeExams }}</h3>
                <p>Ujian Aktif</p>
            </div>
            <div class="icon">
                <i class="fas fa-play-circle"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Total Questions -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalQuestions }}</h3>
                <p>Total Pertanyaan</p>
            </div>
            <div class="icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Total Participants -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalParticipants }}</h3>
                <p>Total Peserta</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- Main Row -->
<div class="row">
    <!-- Exams by Type -->
    <div class="col-lg-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title m-0">Ujian berdasarkan Tipe</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @if (!empty($examsByType))
                        @foreach ($examsByType as $type => $count)
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span>{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
                                <span class="badge badge-primary">{{ $count }}</span>
                            </a>
                        @endforeach
                    @else
                        <p class="text-muted text-center py-3">Tidak ada data</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Exam Status -->
    <div class="col-lg-4">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h5 class="card-title m-0">Status Ujian</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach ($statusLabels as $status => $info)
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>{{ $info['label'] }}</span>
                            <span class="badge" style="background-color: {{ $info['color'] }}">{{ $examsByStatus[$status] ?? 0 }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-lg-4">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h5 class="card-title m-0">Terpublikasi vs Draft</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>Ujian Terpublikasi</span>
                        <span class="badge badge-success">{{ $publishedExams }}</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>Ujian Draft</span>
                        <span class="badge badge-secondary">{{ $totalExams - $publishedExams }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Row -->
<div class="row">
    <!-- Top Exams -->
    <div class="col-lg-6">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h5 class="card-title m-0">Ujian Teratas</h5>
            </div>
            <div class="card-body p-0">
                @if ($topExams->count() > 0)
                    <table class="table table-sm table-striped">
                        <thead class="bg-light">
                            <tr>
                                <th>Nama Ujian</th>
                                <th style="width: 15%">Peserta</th>
                                <th style="width: 15%">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topExams as $exam)
                                <tr>
                                    <td>{{ Str::limit($exam->exam_name, 30) }}</td>
                                    <td><span class="badge badge-info">{{ $exam->participants_count ?? 0 }}</span></td>
                                    <td><small>{{ $exam->exam_type }}</small></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted text-center py-3">Tidak ada data</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Exams -->
    <div class="col-lg-6">
        <div class="card card-secondary card-outline">
            <div class="card-header">
                <h5 class="card-title m-0">Dibuat Baru-baru Ini</h5>
            </div>
            <div class="card-body p-0">
                @if ($recentExams->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach ($recentExams as $exam)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ Str::limit($exam->exam_name, 30) }}</strong>
                                    <small class="text-muted">{{ $exam->created_at->diffForHumans() }}</small>
                                </div>
                                <small class="text-muted">oleh {{ $exam->creator?->name }}</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted text-center py-3">Tidak ada data</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Activity -->
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title m-0">Aktivitas Terbaru</h5>
            </div>
            <div class="card-body p-0">
                @if ($recentActivities->count() > 0)
                    <ul class="list-unstyled">
                        @foreach ($recentActivities as $activity)
                            <li class="list-item p-2 border-bottom">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $activity->action)) }}</span>
                                        </h6>
                                        <small class="text-muted">
                                            @if ($activity->exam)
                                                <i class="fas fa-file-alt"></i> {{ $activity->exam->exam_name }}
                                            @endif
                                            @if ($activity->user)
                                                • <i class="fas fa-user"></i> {{ $activity->user->name }}
                                            @endif
                                        </small>
                                    </div>
                                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted text-center py-3">Tidak ada aktivitas terbaru</p>
                @endif
            </div>
        </div>
@endsection
