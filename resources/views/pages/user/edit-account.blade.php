@extends('layouts.user-main')
@section('title', 'Edit Akun')
@section('content_user')

    <div class="d-flex justify-content-center">
        <div class="content">
            <div class="card">
                <form action="{{ route('user.account.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Nama: <span class="text-danger">*</span></label>
                                <div class="col-12 col-md-9">
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', isset($user->name) ? $user->name : '') }}"
                                        class="form-control" placeholder="Masukan nama lengkap">
                                    @if ($errors->has('name'))
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                            {{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Username: <span
                                        class="text-danger">*</span></label>
                                <div class="col-12 col-md-9">
                                    <input type="text" name="username"
                                        value="{{ old('username', isset($user->username) ? $user->username : '') }}"
                                        class="form-control" placeholder="Masukan username">
                                    @if ($errors->has('username'))
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                            {{ $errors->first('username') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">No Telepon: <span
                                        class="text-danger">*</span></label>
                                <div class="col-12 col-md-9">
                                    <input type="text" name="phone" id="phone"
                                        value="{{ old('phone', isset($user->phone_number) ? $user->phone_number : '') }}"
                                        class="form-control" placeholder="Masukan no handpone">
                                    @if ($errors->has('phone'))
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                            {{ $errors->first('phone') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Email: <span class="text-danger">*</span></label>
                                <div class="col-12 col-md-9">
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', isset($user->email) ? $user->email : '') }}"
                                        class="form-control" placeholder="Masukan alamat email">
                                    @if ($errors->has('email'))
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                            {{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Divisi: <span class="text-danger">*</span></label>
                                <div class="col-12 col-md-9">
                                    <select name="division" id="division" class="form-control select"
                                        data-placeholder="Pilih Divisi...">
                                        <option></option>
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}"
                                                @if ($division->id == old('division', isset($user->division_id) ? $user->division_id : '')) selected @endif>
                                                {{ $division->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('division'))
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                            {{ $errors->first('division') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Jabatan: <span
                                        class="text-danger">*</span></label>
                                <div class="col-12 col-md-9">
                                    <select name="position" id="position" class="form-control select"
                                        data-placeholder="Pilih Jabatan...">
                                        <option></option>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}"
                                                @if ($position->id == old('position', isset($user->position_id) ? $user->position_id : '')) selected @endif>
                                                {{ $position->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('position'))
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                            {{ $errors->first('position') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Password: @if (!isset($user))
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>
                                <div class="col-12 col-md-9">
                                    <div class="input-group">
                                        <input type="text" name="password" id="password" value="{{ old('password') }}"
                                            class="form-control">
                                        <button class="btn btn-light" type="button" id="repeat-password"><i
                                                class="ph-repeat"></i>
                                        </button>
                                    </div>
                                    @if ($errors->has('password'))
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                            {{ $errors->first('password') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

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
    </div>
@endsection


@push('script_user')
    <script src="{{ asset('assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>

    <script src="{{ asset('assets/demo/pages/uploader_bootstrap.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
@endpush

@push('script_user')
    <script>
        $(document).ready(function() {
            @if (session('error'))
                new Noty({
                    text: "{{ session('error') }}",
                    type: 'error'
                }).show();
            @endif

            @if (session('success'))
                new Noty({
                    text: "{{ session('success') }}",
                    type: 'success'
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
