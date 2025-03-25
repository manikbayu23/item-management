@extends('layouts.main')

@section('title_admin', 'Edit Akun Pengguna')

@section('content_admin')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.user-accounts.update', $user->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-3 col-sm-12 mb-3">
                            <label class="form-label">Foto Profil :</label>
                            <input type="file" name="profile_picture" class="file-input-edit" id="profile_picture"
                                accept="image/*"
                                data-initial-preview="{{ optional($user->account)->profile_picture ? json_encode([url('/admin/user-accounts/profile-picture/' . $user->account->profile_picture)]) : '[]' }}"
                                data-initial-preview-config="{{ optional($user->account)->profile_picture ? json_encode([['caption' => basename($user->account->profile_picture), 'key' => 1]]) : '[]' }}"
                                data-initial-caption="{{ optional($user->account)->profile_picture ? basename($user->account->profile_picture) : '' }}">
                            @if ($errors->has('profile_picture'))
                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                    {{ $errors->first('profile_picture') }}</div>
                            @endif

                        </div>
                        <div class="col-md-9 col-sm-12 mb-3 row">
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label class="form-label">Nama :</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                    class="form-control" placeholder="Example : I Wayan Kadis">
                                @if ($errors->has('name'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="col-md-3 col-sm-12 mb-3">
                                <label class="form-label">Divisi :</label>
                                <select name="division" id="division" class="form-control select">
                                    <option value="" disabled>-- Pilih Divisi --</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}"
                                            @if ($division->id == old('division', optional($user->account)->division_id)) selected @endif>
                                            {{ $division->code }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('division'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('division') }}</div>
                                @endif
                            </div>

                            <div class="col-md-3 col-sm-12 mb-3">
                                <label class="form-label">Role :</label>
                                <select name="role" id="role" class="form-control select">
                                    <option value="" disabled>-- Pilih Role --</option>
                                    <option value="admin" @if ('admin' == old('role', optional($user->account)->role)) selected @endif>Admin</option>
                                    <option value="user" @if ('user' == old('role', optional($user->account)->role)) selected @endif>User</option>
                                </select>
                                @if ($errors->has('role'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('role') }}</div>
                                @endif
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <label class="form-label">No Telepon :</label>
                                <input type="text" name="phone" id="phone"
                                    value="{{ old('phone', optional($user->account)->phone) }}" class="form-control"
                                    placeholder="Example : 081338756574">
                                @if ($errors->has('phone'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('phone') }}</div>
                                @endif
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <label class="form-label">Email :</label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $user->email) }}" class="form-control"
                                    placeholder="Example : jongede@gmail.com">
                                @if ($errors->has('email'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('email') }}</div>
                                @endif
                            </div>

                            <div class="col-md-4 col-sm-12 mb-3">
                                <label class="form-label">
                                    @if ($user->account)
                                        New Password
                                    @else
                                        Password
                                    @endif :
                                </label>
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

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Alamat :</label>
                                <textarea name="address" id="address" class="form-control" cols="30" rows="5">{{ old('address', optional($user->account)->address) }}</textarea>
                                @if ($errors->has('address'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('address') }}</div>
                                @endif
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-secondary"><i class="ph-floppy-disk me-1"></i>
                                    Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script_admin')
    <script src="{{ asset('assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
    <!-- Theme JS files -->
    <script src="{{ asset('assets/js/vendor/uploaders/fileinput/fileinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/uploaders/fileinput/plugins/sortable.min.js') }}"></script>

    <script src="{{ asset('assets/demo/pages/uploader_bootstrap.js') }}"></script>
@endpush

@push('script_admin')
    <script>
        $(document).ready(function() {
            @if (optional($user->account) == null)
                $('#password').val(generateRandomPassword());
            @endif

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
