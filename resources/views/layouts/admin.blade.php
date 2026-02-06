<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin CBT v3') - Sistem CBT</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --primary-color: #5e72e4;
            --secondary-color: #6c757d;
            --success-color: #2dce89;
            --danger-color: #f5365c;
            --warning-color: #fb6340;
            --info-color: #11cdef;
            --light-bg: #f7fafc;
            --border-color: #e9ecef;
            --main-font-size: 13px;
            --small-font-size: 12px;
        }

        * {
            font-size: var(--main-font-size);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light-bg);
            color: #2c3e50;
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, #4c63d2 100%);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 0.75rem 1.5rem;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: white !important;
        }

        .navbar .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
        }

        .navbar .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        /* Sidebar Styling */
        .sidebar {
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            min-height: 100vh;
            padding-top: 1rem;
            position: fixed;
            width: 250px;
            left: 0;
            top: 0;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15);
        }

        .sidebar-logo {
            padding: 1rem;
            text-align: center;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }

        .sidebar-logo .brand-text {
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            display: block;
        }

        .sidebar-logo .brand-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            padding: 0.65rem 1.25rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: var(--primary-color);
        }

        .sidebar .nav-link.active {
            color: white;
            background-color: var(--primary-color);
            border-left-color: white;
        }

        .sidebar .nav-item.menu-open > .nav-link {
            color: white;
            background-color: rgba(94, 114, 228, 0.2);
        }

        .sidebar .nav-item .nav-icon {
            width: 1.5rem;
            margin-right: 0.75rem;
            text-align: center;
        }

        .sidebar .nav-header {
            color: rgba(255, 255, 255, 0.5);
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            padding: 1rem 1.25rem 0.5rem;
            letter-spacing: 0.5px;
        }

        .sidebar .nav-treeview {
            background-color: rgba(0, 0, 0, 0.2);
        }

        .sidebar .nav-treeview .nav-link {
            padding-left: 2.5rem;
            font-size: 12px;
        }

        /* Content Area */
        .main-content {
            margin-left: 250px;
            padding: 1.5rem;
            min-height: 100vh;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-title {
            color: #2c3e50;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 0.25rem;
        }

        .page-subtitle {
            color: #7f8c8d;
            font-size: 12px;
            font-weight: 500;
        }

        /* Card Styling */
        .card {
            border: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            border-radius: 6px;
            background-color: white;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background-color: var(--light-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
            border-radius: 6px 6px 0 0;
            font-weight: 600;
            color: #2c3e50;
        }

        .card-header .card-title {
            margin: 0;
            font-size: 14px;
        }

        .card-body {
            padding: 1.25rem;
        }

        .card-footer {
            background-color: var(--light-bg);
            border-top: 1px solid var(--border-color);
            padding: 1rem;
        }

        /* Form Styling */
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            font-size: 13px;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border-color: var(--border-color);
            border-radius: 4px;
            font-size: 13px;
            padding: 0.5rem 0.75rem;
            height: auto;
            line-height: 1.5;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(94, 114, 228, 0.1);
        }

        .form-control.is-invalid, .form-select.is-invalid {
            border-color: var(--danger-color);
        }

        .invalid-feedback {
            font-size: 12px;
            color: var(--danger-color);
        }

        .form-group {
            margin-bottom: 1rem;
        }

        /* Button Styling */
        .btn {
            font-weight: 600;
            padding: 0.5rem 1rem;
            font-size: 13px;
            border-radius: 4px;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #4c63d2;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(94, 114, 228, 0.3);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            color: white;
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-warning {
            background-color: var(--warning-color);
            color: white;
        }

        .btn-info {
            background-color: var(--info-color);
            color: white;
        }

        .btn-sm {
            padding: 0.35rem 0.65rem;
            font-size: 12px;
        }

        .btn-xs {
            padding: 0.25rem 0.5rem;
            font-size: 11px;
        }

        /* Table Styling */
        .table {
            font-size: 12px;
            margin-bottom: 0;
        }

        .table thead th {
            background-color: var(--light-bg);
            border-color: var(--border-color);
            font-weight: 600;
            color: #2c3e50;
            padding: 0.75rem;
            border-bottom: 2px solid var(--border-color);
        }

        .table td {
            padding: 0.75rem;
            border-color: var(--border-color);
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: var(--light-bg);
        }

        /* Badge Styling */
        .badge {
            padding: 0.4rem 0.6rem;
            font-weight: 600;
            font-size: 11px;
            border-radius: 3px;
        }

        .badge-primary {
            background-color: var(--primary-color);
        }

        .badge-success {
            background-color: var(--success-color);
        }

        .badge-danger {
            background-color: var(--danger-color);
        }

        .badge-warning {
            background-color: var(--warning-color);
        }

        .badge-info {
            background-color: var(--info-color);
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 4px;
            padding: 0.75rem 1rem;
            font-size: 13px;
        }

        .alert-danger {
            background-color: rgba(245, 54, 92, 0.1);
            color: var(--danger-color);
            border-left: 4px solid var(--danger-color);
        }

        .alert-success {
            background-color: rgba(45, 206, 137, 0.1);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }

        .alert-warning {
            background-color: rgba(251, 99, 64, 0.1);
            color: var(--warning-color);
            border-left: 4px solid var(--warning-color);
        }

        .alert-info {
            background-color: rgba(17, 205, 239, 0.1);
            color: var(--info-color);
            border-left: 4px solid var(--info-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                box-shadow: none;
                border-bottom: 1px solid var(--border-color);
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }
        }

        /* Smooth scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--light-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: #bdc3c7;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #95a5a6;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="container-fluid p-0">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid px-3">
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-laptop me-2"></i>CBT v3
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <span class="nav-link">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </span>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-light">
                                    <i class="fas fa-sign-out-alt me-1"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="d-flex">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="sidebar-logo">
                    <div class="brand-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <span class="brand-text">Admin Panel</span>
                </div>

                <nav class="nav flex-column">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line nav-icon"></i>
                        <span>Dasbor</span>
                    </a>

                    <!-- Management Header -->
                    <div class="nav-header">Manajemen</div>

                    <!-- Exams -->
                    <div class="nav-item {{ request()->routeIs('admin.exams.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.exams.*') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#examsMenu">
                            <i class="fas fa-file-alt nav-icon"></i>
                            <span>Ujian</span>
                            <i class="fas fa-chevron-right ms-auto" style="font-size: 10px;"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.exams.*') ? 'show' : '' }}" id="examsMenu">
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.exams.index') }}" class="nav-link {{ request()->routeIs('admin.exams.index') ? 'active' : '' }}">
                                        <i class="fas fa-circle nav-icon"></i>
                                        <span>Semua Ujian</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.exams.create') }}" class="nav-link">
                                        <i class="fas fa-circle nav-icon"></i>
                                        <span>Buat Ujian</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Questions -->
                    <div class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#questionsMenu">
                            <i class="fas fa-question-circle nav-icon"></i>
                            <span>Pertanyaan</span>
                            <i class="fas fa-chevron-right ms-auto" style="font-size: 10px;"></i>
                        </a>
                        <div class="collapse" id="questionsMenu">
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fas fa-circle nav-icon"></i>
                                        <span>Grup Pertanyaan</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fas fa-circle nav-icon"></i>
                                        <span>Semua Pertanyaan</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Settings Header -->
                    <div class="nav-header mt-3">Pengaturan</div>

                    <a href="#" class="nav-link">
                        <i class="fas fa-mobile-alt nav-icon"></i>
                        <span>Mobile Settings</span>
                    </a>

                    <a href="#" class="nav-link">
                        <i class="fas fa-users-cog nav-icon"></i>
                        <span>Pengguna</span>
                    </a>

                    <!-- Reports Header -->
                    <div class="nav-header mt-3">Laporan</div>

                    <a href="#" class="nav-link">
                        <i class="fas fa-chart-bar nav-icon"></i>
                        <span>Analitik</span>
                    </a>

                    <a href="#" class="nav-link">
                        <i class="fas fa-book nav-icon"></i>
                        <span>Log Aktivitas</span>
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="main-content flex-grow-1">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-exclamation-circle me-2"></i>Terjadi Kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Page Header -->
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-title">@yield('page-title', 'Dasbor')</h1>
                            <p class="page-subtitle">@yield('page-subtitle')</p>
                        </div>
                    </div>
                </div>

                <!-- Page Content -->
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (untuk kompatibilitas) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Toastr configuration
        toastr.options = {
            positionClass: 'toast-top-right',
            timeOut: 4000,
            progressBar: true,
            preventDuplicates: true,
        };

        // Global confirm delete function
        function confirmDelete(url, message = 'Apakah Anda yakin ingin menghapus?') {
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f5365c',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.innerHTML = '@csrf <input type="hidden" name="_method" value="DELETE">';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
            return false;
        }

        function showSuccess(message) {
            toastr.success(message);
        }

        function showError(message) {
            toastr.error(message);
        }

        function showInfo(message) {
            toastr.info(message);
        }

        function showWarning(message) {
            toastr.warning(message);
        }
    </script>

    @stack('scripts')
</body>
</html>
