<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin CBT v3') - Sistem CBT</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --main-font-size: 13px;
            --small-font-size: 12px;
            --large-font-size: 14px;
        }

        * {
            font-size: var(--main-font-size);
        }

        h1 { font-size: 1.8rem !important; }
        h2 { font-size: 1.6rem !important; }
        h3 { font-size: 1.4rem !important; }
        h4 { font-size: 1.2rem !important; }
        h5 { font-size: 1.1rem !important; }
        h6 { font-size: 1rem !important; }

        .main-sidebar {
            font-size: 13px;
        }

        .sidebar-brand {
            padding: 0.8rem 0.5rem;
        }

        .nav-treeview > .nav-item > .nav-link {
            padding: 0.5rem 1rem;
        }

        .content-header {
            padding: 0.5rem 0.5rem;
        }

        .content-wrapper {
            padding: 0.5rem;
        }

        .card {
            margin-bottom: 0.8rem;
        }

        .card-header {
            padding: 0.5rem 0.75rem;
            font-size: 13px;
        }

        .card-body {
            padding: 0.75rem;
        }

        .btn {
            font-size: 12px;
            padding: 0.35rem 0.65rem;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
        }

        .table {
            font-size: 12px;
            margin-bottom: 0.5rem;
        }

        .table th {
            padding: 0.4rem;
        }

        .table td {
            padding: 0.4rem;
        }

        .input-group-sm > .form-control,
        .input-group-sm > .form-select {
            font-size: 12px;
        }

        .form-control, .form-select {
            font-size: 13px;
            padding: 0.4rem 0.6rem;
            height: calc(1.5em + 0.8rem + 2px);
        }

        .navbar-nav .nav-link {
            padding: 0.5rem;
        }

        .user-panel {
            padding: 0.8rem;
        }

        .user-panel > .info {
            padding: 0.5rem 0;
        }
    </style>

    @stack('styles')
</head>
<body class="layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <div class="navbar-custom-menu ml-auto">
                <ul class="nav navbar-nav">
                    <!-- Notifications Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-bell"></i>
                            <span class="badge badge-danger navbar-badge">3</span>
                        </a>
                    </li>

                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-user mr-2"></i> Profil
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item" style="border: none; background: none; cursor: pointer;">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <i class="fas fa-laptop brand-image img-circle elevation-3" style="color: #ffc107;"></i>
                <span class="brand-text font-weight-light">CBT v3</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <i class="fas fa-user-circle img-circle elevation-2" style="font-size: 2.5rem; color: #ffc107;"></i>
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                        <small class="text-muted">Admin</small>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dasbor</p>
                            </a>
                        </li>

                        <!-- Exam Management -->
                        <li class="nav-header">Manajemen</li>

                        <li class="nav-item {{ request()->routeIs('admin.exams.*') ? 'menu-open' : '' }}">
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
                        <li class="nav-header">Pengaturan</li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-mobile-alt"></i>
                                <p>Pengaturan Mobile</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>Pengguna</p>
                            </a>
                        </li>

                        <!-- Reports -->
                        <li class="nav-header">Laporan</li>

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
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page-title', 'Dasbor')</h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <small class="text-muted">@yield('page-subtitle')</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <!-- Alerts -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="alert-heading">Kesalahan!</h4>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                toastr.success("{{ session('success') }}", "Success");
                            });
                        </script>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                <b>Version</b> 1.0.0
            </div>
            <strong>CBT v3</strong> - Computer-Based Testing System. All rights reserved.
        </footer>
    </div>

    <!-- Modal Confirm -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="confirmMessage">
                    Are you sure?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger btn-sm" id="confirmBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        // Toastr config
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 4000,
            extendedTimeOut: 1000,
        };

        // Confirm delete function
        function confirmDelete(url, message = "Are you sure you want to delete this item?") {
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.innerHTML = `
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
            return false;
        }

        // Success message
        function showSuccess(message = "Action completed successfully!") {
            toastr.success(message, "Success");
        }

        // Error message
        function showError(message = "An error occurred!") {
            toastr.error(message, "Error");
        }

        // Info message
        function showInfo(message = "Information") {
            toastr.info(message, "Info");
        }
    </script>

    @stack('scripts')
</body>
</html>
