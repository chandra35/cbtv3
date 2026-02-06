@extends('adminlte::page')

@section('title', 'CBT v3 - Admin')

@section('content_header')
    <h1>@yield('page-title', 'Dasbor')</h1>
@stop

@section('content')
    @yield('content')
@stop

@section('footer')
    <div class="float-right">
        CBT v3 - Sistem Computer-Based Testing
    </div>
@stop

@section('css')
    <style>
        body {
            font-size: 13px;
        }
    </style>
    @stack('styles')
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Toastr configuration
        toastr.options = {
            positionClass: 'toast-top-right',
            timeOut: 4000,
            progressBar: true,
            preventDuplicates: true,
        };

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
@stop
