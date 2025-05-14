@extends('layouts.main')

@section('title_admin', 'Tambah Asset')

@section('content_admin')
    <div class="content">
        <div class="card">
            <form id="form" action="{{ route('admin.asset.store') }}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-3 mb-3">
                            <label class="form-label">Foto aset: <span class="text-danger">*</span> </label>
                            <input type="file" name="file_name" class="file-input" id="file_name" accept="image/*">
                            <div class="form-text text-danger text-error" id="file_name_error" style="display: none;">
                                <i class="ph-x-circle me-1"></i>
                                <span></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-9 mb-3 row">
                            <div class="col-12 mb-3 row">
                                <label class="col-form-label col-12 col-md-3">Provinsi: </label>
                                <div class="col-12 col-md-8">
                                    <input type="text" class="form-control-plaintext fw-semibold" readonly
                                        value="{{ $location->province }}">
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="col-form-label col-12 col-md-3">Kabupaten: </label>
                                <div class="col-12 col-md-8">
                                    <input type="text" class="form-control-plaintext fw-semibold" readonly
                                        value="{{ $location->regency }}">
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="col-form-label col-12 col-md-3">Kecamatan: </label>
                                <div class="col-12 col-md-8">
                                    <input type="text" class="form-control-plaintext fw-semibold" readonly
                                        value="{{ $location->district }}">
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="col-form-label col-12 col-md-3">Desa: </label>
                                <div class="col-12 col-md-8">
                                    <input type="text" class="form-control-plaintext fw-semibold" readonly
                                        value="{{ $location->area }}">
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Tahun Pengadaan: <span
                                        class="text-danger">*</span> </label>
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
                                <label class="form-label col-12 col-md-3">Golongan: <span class="text-danger">*</span>
                                </label>
                                <div class="col-12 col-md-6">
                                    <select name="group" id="group" class="form-control select"
                                        data-placeholder="Pilih Golongan...">
                                        <option></option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->id }}">
                                                [{{ rtrim($group->code, '.') }}]
                                                {{ $group->description }}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-text text-danger text-error" id="group_error" style="display: none;">
                                        <i class="ph-x-circle me-1"></i>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Bidang: <span class="text-danger">*</span>
                                </label>
                                <div class="col-12 col-md-6">
                                    <select name="scope" id="scope" class="form-control select"
                                        data-placeholder="Pilih Bidang...">
                                        <option></option>
                                    </select>
                                    <div class="form-text text-danger text-error" id="scope_error" style="display: none;">
                                        <i class="ph-x-circle me-1"></i>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Kelompok: <span class="text-danger">*</span>
                                </label>
                                <div class="col-12 col-md-6">
                                    <select name="category" id="category" class="form-control select "
                                        data-placeholder="Pilih Kelompok...">
                                        <option></option>
                                    </select>
                                    <div class="form-text text-danger text-error" id="category_error"
                                        style="display: none;">
                                        <i class="ph-x-circle me-1"></i>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Sub Kelompok: <span class="text-danger">*</span>
                                </label>
                                <div class="col-12 col-md-6">
                                    <select name="sub_category" id="sub_category" class="form-control select "
                                        data-placeholder="Pilih Sub Kelompok...">
                                        <option></option>
                                    </select>
                                    <div class="form-text text-danger text-error" id="sub_category_error"
                                        style="display: none;">
                                        <i class="ph-x-circle me-1"></i>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Kode Aset:<span class="text-danger">*</span>
                                </label>
                                <div class="col-12 col-md-5">
                                    <input type="text" name="asset_code" id="asset_code" class="form-control"
                                        @readonly(true)>

                                    <div class="form-text text-danger text-error" id="asset_code_error"
                                        style="display: none;">
                                        <i class="ph-x-circle me-1"></i>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="col-form-label col-12 col-lg-3">Departemen: <span
                                        class="text-danger">*</span></label>
                                <div class="col-12 col-lg-5">
                                    <select class="form-control select" name="department_id" id="department_id"
                                        data-minimum-results-for-search="Infinity" data-placeholder="Pilih Departemen">
                                        @foreach ($departments as $key => $department)
                                            <option></option>
                                            <option value="{{ $department->id }}"x>
                                                [{{ $department->code }}]
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text text-danger text-error" id="department_id_error"
                                        style="display: none;">
                                        <i class="ph-x-circle me-1"></i>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Nama Asset: <span class="text-danger">*</span>
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
                                <label class="form-label col-12 col-md-3">Identitas Barang: <span
                                        class="text-danger">*</span>
                                </label>
                                <div class="col-12 col-md-9">
                                    <textarea name="asset_identity" id="asset_identity" class="form-control" rows="3"></textarea>
                                    <div class="form-text text-danger text-error" id="asset_identity_error"
                                        style="display: none;">
                                        <i class="ph-x-circle me-1"></i>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-12 col-md-3">Tanggal Perolehan: <span
                                        class="text-danger">*</span></label>
                                <div class="col-12 col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ph-calendar"></i>
                                        </span>
                                        <input type="text" class="form-control datepicker-basic-loan"
                                            name="acquisition" placeholder="Pilih Tanggal Peminjaman"
                                            value="{{ now()->format('D/M/Y') }}">
                                    </div>
                                    <div class="form-text text-danger text-error" id="acquisition_error"
                                        style="display: none;">
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

            $('#scope').prop('disabled', true);
            $('#category').prop('disabled', true);
            $('#sub_category').prop('disabled', true);

            $('#group').on('change', function() {
                const id = $(this).val();

                if (!id) return;

                $('#scope').prop('disabled', true).empty();
                $('#category').prop('disabled', true).empty();
                $('#sub_category').prop('disabled', true).empty();
                $('#asset_code').val('');

                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.asset.get-scopes') }}?idGroup=" + id,
                    dataType: 'json',
                    success: function(response) {
                        let option = '<option></option>';
                        response.data.forEach((scope, index) => {
                            const {
                                id,
                                code,
                                description
                            } = scope;
                            option +=
                                `<option value="${id}">[${code.replace(/\.+$/, '')}] ${description}</option>`;
                        });

                        $('#scope').append(option);
                        $('#scope').prop('disabled', false);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan pada jaringan, silahkan coba lagi.',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary',
                            },
                        })
                    }
                })
            })

            $('#scope').on('change', function() {
                const id = $(this).val();

                if (!id) return;

                $('#category').prop('disabled', true).empty();
                $('#sub_category').prop('disabled', true).empty();
                $('#asset_code').val('');

                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.asset.get-categories') }}?idScope=" + id,
                    dataType: 'json',
                    success: function(response) {
                        let option = '<option></option>';
                        response.data.forEach((category, index) => {
                            const {
                                id,
                                code,
                                description
                            } = category;
                            option +=
                                `<option value="${id}">[${code.replace(/\.+$/, '')}] ${description}</option>`;
                        });

                        $('#category').append(option);
                        $('#category').prop('disabled', false);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan pada jaringan, silahkan coba lagi.',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary',
                            },
                        })
                    }
                })
            })

            $('#category').on('change', function() {
                const id = $(this).val();

                if (!id) return;

                $('#sub_category').prop('disabled', true).empty();
                $('#asset_code').val('');

                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.asset.get-sub-categories') }}?idCategory=" + id,
                    dataType: 'json',
                    success: function(response) {
                        let option = '<option></option>';
                        response.data.forEach((sub_category, index) => {
                            const {
                                id,
                                code,
                                description
                            } = sub_category;
                            option +=
                                `<option value="${id}">[${code.replace(/\.+$/, '')}] ${description}</option>`;
                        });

                        $('#sub_category').append(option);
                        $('#sub_category').prop('disabled', false);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan pada jaringan, silahkan coba lagi.',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary',
                            },
                        })
                    }
                })
            })

            $('#sub_category').on('change', function() {
                const id = $(this).val();

                if (!id) return;

                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.asset.last-code') }}?idSubCategory=" + id,
                    dataType: 'json',
                    success: function(response) {
                        $('#asset_code').val(response.code);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan pada jaringan, silahkan coba lagi.',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary',
                            },
                        })
                    }
                })
            });

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
                                    '{{ route('admin.asset.index') }}';
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

            // $(document).ready(function() {
            //     // Handle ketika file dipilih
            //     $('#product-images').on('change', function(e) {
            //         const files = e.target.files;
            //         const previewContainer = $('#image-preview');

            //         $.each(files, function(index, file) {
            //             // Validasi ukuran file (maksimal 5MB)
            //             if (file.size > 5 * 1024 * 1024) {
            //                 alert('File ' + file.name + ' melebihi ukuran maksimal 5MB');
            //                 return true; // continue dalam $.each
            //             }

            //             // Validasi tipe file
            //             if (!file.type.match('image.*')) {
            //                 alert('File ' + file.name + ' bukan gambar yang valid');
            //                 return true; // continue dalam $.each
            //             }

            //             const reader = new FileReader();

            //             reader.onload = function(e) {
            //                 const previewImage = $('<div>').addClass(
            //                     'preview-image col-auto');

            //                 previewImage.html(`
        //             <img src="${e.target.result}" alt="Preview">
        //             <div class="delete-btn">×</div>
        //         `);

            //                 previewContainer.append(previewImage);

            //                 // Tambahkan event untuk tombol delete
            //                 previewImage.find('.delete-btn').on('click', function() {
            //                     previewImage.remove();
            //                     // Hapus file dari input files (memerlukan cara khusus)
            //                     removeFileFromInput(index);
            //                 });
            //             };

            //             reader.readAsDataURL(file);
            //         });

            //         // Reset input file untuk mengizinkan upload file yang sama lagi
            //         $(this).val('');
            //     });

            //     // Fungsi untuk drag and drop
            //     const uploadArea = $('.upload-box');

            //     uploadArea.on('dragover', function(e) {
            //         e.preventDefault();
            //         $(this).css('background-color', '#f0f0f0');
            //     });

            //     uploadArea.on('dragleave', function() {
            //         $(this).css('background-color', '');
            //     });

            //     uploadArea.on('drop', function(e) {
            //         e.preventDefault();
            //         $(this).css('background-color', '');

            //         const files = e.originalEvent.dataTransfer.files;
            //         $('#product-images')[0].files = files;

            //         // Trigger change event
            //         $('#product-images').trigger('change');
            //     });

            //     // Fungsi untuk menghapus file dari input (hanya visual, karena FileList tidak bisa dimodifikasi langsung)
            //     function removeFileFromInput(index) {
            //         // Karena FileList tidak bisa dimodifikasi langsung, kita perlu membuat solusi alternatif
            //         // Solusi yang lebih baik adalah menyimpan file yang valid di array terpisah
            //         console.log('File index ' + index +
            //             ' dihapus (implementasi lengkap memerlukan penanganan lebih lanjut)');
            //     }
            // });
        });
    </script>
@endpush
