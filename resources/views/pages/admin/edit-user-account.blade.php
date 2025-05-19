@extends('layouts.main')

@section('page_name1', 'Akun Pengguna')
@section('page_name1_url', 'admin.user-account')
@section('page_name2', 'Edit Akun')
@section('content_admin')
    <div class="content">
        <div class="card">
            <form action="{{ route('admin.user-account.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    @method('PUT')
                    @include('components.form-user-account')
                </div>
                <div class="card-footer">
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="ph-floppy-disk me-1"></i>
                            Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script_admin')
    <script src="{{ asset('assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>

    <script src="{{ asset('assets/demo/pages/uploader_bootstrap.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
@endpush

@push('script_admin')
    <script>
        $(document).ready(function() {
            @if (session('error'))
                new Noty({
                    text: "{{ session('error') }}",
                    type: 'error'
                }).show();
            @endif

            $('#repeat-password').click(function() {
                $('#password').val(generateRandomPassword());
            });

            function generateRandomPassword() {
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
                let password = '';
                const length = 10; // Panjang password

                for (let i = 0; i < length; i++) {
                    password += chars.charAt(Math.floor(Math.random() * chars.length));
                }

                return password;
            }

            $('#phone').on('keypress', function(e) {
                var charCode = (e.which) ? e.which : e.keyCode;
                // Hanya izinkan karakter angka (0-9)
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            });
        });
    </script>
@endpush
