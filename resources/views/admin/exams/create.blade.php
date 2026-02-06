@extends('layouts.admin')
@section('title', 'Buat Ujian')
@section('page-title', 'Buat Ujian Baru')
@section('page-subtitle', 'Tambahkan ujian baru ke sistem')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <form action="{{ route('admin.exams.store') }}" method="POST">
                @csrf

                <!-- Basic Information Section -->
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>Informasi Dasar
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Exam Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exam_name">Nama Ujian <span class="text-danger">*</span></label>
                                <input type="text" id="exam_name" name="exam_name" 
                                    value="{{ old('exam_name') }}"
                                    class="form-control @error('exam_name') is-invalid @enderror"
                                    placeholder="Masukkan nama ujian" required>
                                @error('exam_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Exam Type -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exam_type">Tipe Ujian <span class="text-danger">*</span></label>
                                <select id="exam_type" name="exam_type"
                                    class="form-control @error('exam_type') is-invalid @enderror"
                                    required>
                                    <option value="">Pilih tipe ujian</option>
                                    <option value="test" {{ old('exam_type') === 'test' ? 'selected' : '' }}>Tes</option>
                                    <option value="quiz" {{ old('exam_type') === 'quiz' ? 'selected' : '' }}>Kuis</option>
                                    <option value="assignment" {{ old('exam_type') === 'assignment' ? 'selected' : '' }}>Tugas</option>
                                    <option value="final_exam" {{ old('exam_type') === 'final_exam' ? 'selected' : '' }}>Ujian Akhir</option>
                                </select>
                                @error('exam_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Jenjang -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenjang">Jenjang Pendidikan <span class="text-danger">*</span></label>
                                <select id="jenjang" name="jenjang"
                                    class="form-control @error('jenjang') is-invalid @enderror"
                                    required>
                                    <option value="">Pilih jenjang</option>
                                    <option value="SD" {{ old('jenjang') === 'SD' ? 'selected' : '' }}>SD (Sekolah Dasar)</option>
                                    <option value="SMP" {{ old('jenjang') === 'SMP' ? 'selected' : '' }}>SMP (Sekolah Menengah Pertama)</option>
                                    <option value="SMA" {{ old('jenjang') === 'SMA' ? 'selected' : '' }}>SMA (Sekolah Menengah Atas)</option>
                                    <option value="Madrasah" {{ old('jenjang') === 'Madrasah' ? 'selected' : '' }}>Madrasah</option>
                                </select>
                                @error('jenjang')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Duration -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="duration">Durasi (menit) <span class="text-danger">*</span></label>
                                <input type="number" id="duration" name="duration" 
                                    value="{{ old('duration') }}"
                                    class="form-control @error('duration') is-invalid @enderror"
                                    placeholder="60" min="1" required>
                                @error('duration')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea id="description" name="description" 
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Masukkan deskripsi ujian" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scoring Section -->
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-2"></i>Penilaian
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Passing Grade -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="passing_grade">Nilai Lulus (%) <span class="text-danger">*</span></label>
                                <input type="number" id="passing_grade" name="passing_grade" 
                                    value="{{ old('passing_grade') }}"
                                    class="form-control @error('passing_grade') is-invalid @enderror"
                                    placeholder="70" min="0" max="100" step="0.01" required>
                                @error('passing_grade')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Show Answers -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox mt-4">
                                    <input type="checkbox" class="custom-control-input" id="show_answers" 
                                        name="show_answers_after" value="1" 
                                        {{ old('show_answers_after') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="show_answers">
                                        Tampilkan jawaban setelah selesai
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Allow Review -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox mt-4">
                                    <input type="checkbox" class="custom-control-input" id="allow_review" 
                                        name="allow_review_before_submit" value="1"
                                        {{ old('allow_review_before_submit') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="allow_review">
                                        Izinkan review sebelum kirim
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="row">
                        <!-- Passing Message -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="passing_message">Pesan Lulus</label>
                                <textarea id="passing_message" name="passing_message"
                                    class="form-control @error('passing_message') is-invalid @enderror"
                                    placeholder="Selamat! Anda lulus dalam ujian ini."
                                    rows="3">{{ old('passing_message') }}</textarea>
                                @error('passing_message')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Failing Message -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="failing_message">Pesan Tidak Lulus</label>
                                <textarea id="failing_message" name="failing_message"
                                    class="form-control @error('failing_message') is-invalid @enderror"
                                    placeholder="Maaf, Anda belum lulus. Silakan coba lagi."
                                    rows="3">{{ old('failing_message') }}</textarea>
                                @error('failing_message')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scheduling Section -->
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-2"></i>Jadwal
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Start Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" id="start_date" name="start_date" 
                                    value="{{ old('start_date') }}"
                                    class="form-control @error('start_date') is-invalid @enderror"
                                    required>
                                @error('start_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- End Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" id="end_date" name="end_date" 
                                    value="{{ old('end_date') }}"
                                    class="form-control @error('end_date') is-invalid @enderror"
                                    required>
                                @error('end_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Start Time -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_time">Waktu Mulai <span class="text-danger">*</span></label>
                                <input type="time" id="start_time" name="start_time" 
                                    value="{{ old('start_time') }}"
                                    class="form-control @error('start_time') is-invalid @enderror"
                                    required>
                                @error('start_time')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- End Time -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_time">Waktu Selesai <span class="text-danger">*</span></label>
                                <input type="time" id="end_time" name="end_time" 
                                    value="{{ old('end_time') }}"
                                    class="form-control @error('end_time') is-invalid @enderror"
                                    required>
                                @error('end_time')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Publish Status -->
                <div class="card-body border-top">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_published" 
                            name="is_published" value="1"
                            {{ old('is_published') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_published">
                            Publikasikan langsung
                        </label>
                    </div>
                    <small class="form-text text-muted d-block mt-2">Biarkan tidak dicentang untuk menyimpan sebagai draft</small>
                </div>

                <!-- Form Actions -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Buat Ujian
                    </button>
                    <a href="{{ route('admin.exams.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
