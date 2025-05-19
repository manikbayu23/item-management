@extends('layouts.main')

@section('page_name1', 'Daftar Barang')
@section('page_name1_url', 'admin.item')
@section('page_name2', 'Tambah Barang')

@section('content_admin')
    <div class="content">
        <div class="card">
            <form id="form" action="{{ route('admin.item.store') }}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        {{-- <div class="col-12 col-md-3 mb-3">
                            <label class="form-label">Foto aset: <span class="text-danger">*</span> </label>
                            <input type="file" name="file_name" class="file-input" id="file_name" accept="image/*">
                            <div class="form-text text-danger text-error" id="file_name_error" style="display: none;">
                                <i class="ph-x-circle me-1"></i>
                                <span></span>
                            </div>
                        </div> --}}
                        <div class="col-12 col-md-9 mb-3 row">
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Tahun Barang: <span class="text-danger">*</span>
                                </label>
                                <div class="col-12 col-md-2">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ph-calendar"></i>
                                        </span>
                                        <input type="text" id="procurement" name="procurement"
                                            class="form-control datepicker-basic" value="{{ now()->year }}"
                                            placeholder="2025" @readonly(true)>
                                    </div>
                                    <div class="form-text text-danger text-error" id="procurement_error"
                                        style="display: none;">
                                        <i class="ph-x-circle me-1"></i>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Kategori: <span class="text-danger">*</span>
                                </label>
                                <div class="col-12 col-md-6">
                                    <select name="category" id="category" class="form-control select"
                                        data-placeholder="Pilih Kategori...">
                                        <option></option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-text text-danger text-error" id="category_error"
                                        style="display: none;">
                                        <i class="ph-x-circle me-1"></i>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3 row">
                                    <label class="form-label col-12 col-md-2">Nama: <span
                                            class="text-danger">*</span></label>
                                    <div class="col-12 col-md-6">
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
                                    <label class="form-label col-12 col-md-2">Username: <span
                                            class="text-danger">*</span></label>
                                    <div class="col-12 col-md-5">
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
                                    <label class="form-label col-12 col-md-2">No Telepon: <span
                                            class="text-danger">*</span></label>
                                    <div class="col-12 col-md-5">
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
                                    <label class="form-label col-12 col-md-2">Email: <span
                                            class="text-danger">*</span></label>
                                    <div class="col-12 col-md-5">
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
                                    <label class="form-label col-12 col-md-2">Divisi: <span
                                            class="text-danger">*</span></label>
                                    <div class="col-12 col-md-5">
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
                                    <label class="form-label col-12 col-md-2">Jabatan: <span
                                            class="text-danger">*</span></label>
                                    <div class="col-12 col-md-5">
                                        <select name="position" id="position" class="form-control select"
                                            data-placeholder="Pilih Jabatan...">
                                            <option></option>
                                            @foreach ($positions as $position)
                                                <option value="{{ $position->id }}"
                                                    @if ($position->id == old('position', isset($user->position) ? $user->position : '')) selected @endif>
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
                                    <label class="form-label col-12 col-md-2">Role: <span
                                            class="text-danger">*</span></label>
                                    <div class="col-12 col-md-4">
                                        <select name="role" id="role" class="form-control select"
                                            data-placeholder="Pilih Role...">
                                            <option></option>
                                            <option value="superadmin" @if ('admin' == old('role', isset($user->role) ? $user->role : '')) selected @endif>
                                                Superadmin
                                            </option>
                                            <option value="admin" @if ('admin' == old('role', isset($user->role) ? $user->role : '')) selected @endif>Admin
                                            </option>
                                            <option value="user" @if ('user' == old('role', isset($user->role) ? $user->role : '')) selected @endif>User
                                            </option>
                                        </select>
                                        @if ($errors->has('role'))
                                            <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                                {{ $errors->first('role') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 mb-3 row">
                                    <label class="form-label col-12 col-md-2">Password: <span
                                            class="text-danger">*</span></label>
                                    <div class="col-12 col-md-6">
                                        <div class="input-group">
                                            <input type="text" name="password" id="password"
                                                value="{{ old('password') }}" class="form-control">
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

                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Kode Barang:<span class="text-danger">*</span>
                                </label>
                                <div class="col-12 col-md-5">
                                    <input type="text" name="code" id="code" class="form-control">

                                    <div class="form-text text-danger text-error" id="code_error" style="display: none;">
                                        <i class="ph-x-circle me-1"></i>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Nama Barang: <span class="text-danger">*</span>
                                </label>
                                <div class="col-12 col-md-9">
                                    <input type="text" name="name" id="name" class="form-control">
                                    <div class="form-text text-danger text-error" id="name_error" style="display: none;">
                                        <i class="ph-x-circle me-1"></i>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Jenis Barang: <span class="text-danger">*</span>
                                </label>
                                <div class="col-12 col-md-9">
                                    <input type="text" name="type" id="type" class="form-control">
                                    <div class="form-text text-danger text-error" id="type_error" style="display: none;">
                                        <i class="ph-x-circle me-1"></i>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Jumlah: <span class="text-danger">*</span>
                                </label>
                                <div class="col-12 col-md-9 row">
                                    <div class="col-12 col-md-4">
                                        <div class="input-group">
                                            <button type="button" class="btn btn-light btn-icon"
                                                onclick="this.parentNode.querySelector('#qty').stepDown()">
                                                <i class="ph-minus ph-sm"></i>
                                            </button>
                                            <input class="form-control form-control-number text-center" id="qty"
                                                type="number" name="qty" value="1">
                                            <button type="button" class="btn btn-light btn-icon"
                                                onclick="this.parentNode.querySelector('#qty').stepUp()">
                                                <i class="ph-plus ph-sm"></i>
                                            </button>
                                        </div>
                                        <div class="form-text text-danger text-error" id="qty_error"
                                            style="display: none;">
                                            <i class="ph-x-circle me-1"></i>
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 row">
                                        <label class="col-form-label col-12 col-lg-3 text-end">Satuan</label>
                                        <div class="col-12 col-lg-9">
                                            <select class="form-control select" name="unit" id="unit"
                                                data-minimum-results-for-search="Infinity">
                                                @foreach ($units as $key => $unit)
                                                    <optgroup label="Satuan {{ $key }}">
                                                        @foreach ($unit as $name)
                                                            <option value="{{ $name }}">{{ $name }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                            <div class="form-text text-danger text-error" id="unit_error"
                                                style="display: none;">
                                                <i class="ph-x-circle me-1"></i>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Keterangan: <span class="text-danger">*</span>
                                </label>
                                <div class="col-12 col-lg-9">
                                    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                    <div class="form-text text-danger text-error" id="description_error"
                                        style="display: none;">
                                        <i class="ph-x-circle me-1"></i>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn btn-primary" type="submit"><i class="ph-floppy-disk"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script_admin')
    <script src="{{ asset('assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/uploaders/fileinput/fileinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/uploaders/fileinput/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickers/datepicker.min.js') }}"></script>

    <script src="{{ asset('assets/demo/pages/picker_date.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/uploader_bootstrap.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
@endpush

@push('script_admin')
    <script>
        $(document).ready(function() {
            $('#form').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            if (true) {
                                window.location.href =
                                    '{{ route('admin.item') }}';
                            }
                        });
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        if (xhr.status == 422) {
                            $('.text-error').hide().find('span').text('');

                            Object.entries(response.errors).forEach(([field, messages]) => {
                                $(`#${field}_error`).show().find('span').text(messages[
                                    0]);
                            });

                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan pada jaringan, silahkan coba lagi.',
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-primary',
                                },
                            })
                        }
                    },
                    complete: function() {
                        // Restore button state
                        // submitButton.prop('disabled', false).html(originalContent);
                    }
                });
            })
        });
    </script>
@endpush
