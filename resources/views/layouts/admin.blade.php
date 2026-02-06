<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin CBT v3') - Sistem CBT</title>

    <!-- AdminLTE 3 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body {
            font-size: 13px;
        }

        .main-header.navbar {
            background: linear-gradient(90deg, #007bff, #0056b3);
        }

        .sidebar {
            background-color: #2c3e50;
        }

        .sidebar .nav-link.active {
            background-color: #007bff;
        }

        .content-wrapper {
            background-color: #f5f5f5;
        }

        .card {
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        .form-control, .form-select {
            font-size: 13px;
        }

        .btn {
            font-weight: 600;
        }

        .btn-sm {
            font-size: 12px;
        }
    </style>

    @stack('styles')
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="navbar-text">
                        <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                    </span>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-dark" style="border: none; cursor: pointer;">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <i class="fas fa-laptop brand-image elevation-3" style="opacity: 1; margin-right: 10px;"></i>
                <span class="brand-text font-weight-light">CBT v3</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dasbor</p>
                            </a>
                        </li>

                        <!-- Management -->
                        <li class="nav-header">MANAJEMEN</li>

                        <li class="nav-item {{ request()->routeIs('admin.exams.*') ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('admin.exams.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Ujian <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.exams.index') }}" class="nav-link {{ request()->routeIs('admin.exams.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Semua Ujian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.exams.create') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Buat Ujian</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-question-circle"></i>
                                <p>Pertanyaan <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Grup Pertanyaan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Semua Pertanyaan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Settings -->
                        <li class="nav-header">PENGATURAN</li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-mobile-alt"></i>
                                <p>Mobile Settings</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Pengguna</p>
                            </a>
                        </li>

                        <!-- Reports -->
                        <li class="nav-header">LAPORAN</li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Analitik</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Log Aktivitas</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page-title', 'Dasbor')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">@yield('page-title', 'Dasbor')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="content">
                <div class="container-fluid">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Terjadi Kesalahan!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <strong>CBT v3</strong> - Sistem Computer-Based Testing
            <div class="float-right d-none d-sm-inline-block">
                <b>Versi</b> 3.0
            </div>
        </footer>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/adminlte.min.js"></script>
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

        // Confirm delete function
        function confirmDelete(url, message = 'Apakah Anda yakin ingin menghapus?') {
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
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
