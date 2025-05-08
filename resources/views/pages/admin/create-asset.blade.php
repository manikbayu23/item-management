@extends('layouts.main')

@section('title_admin', 'Tambah Asset')

@section('content_admin')
    <div class="content">
        <div class="card">
            <form id="form" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-3 mb-3">
                            <label class="form-label">Foto aset: <span class="text-danger">*</span> </label>
                            <input type="file" name="profile_picture" class="file-input" id="profile_picture"
                                accept="image/*">
                            @if ($errors->has('profile_picture'))
                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                    {{ $errors->first('profile_picture') }}</div>
                            @endif
                        </div>
                        <div class="col-12 col-md-9 mb-3 row">
                            <div class="col-12 mb-3 row">
                                <label class="col-form-label col-3">Provinsi: </label>
                                <div class="col-8">
                                    <input type="text" class="form-control-plaintext fw-semibold" readonly
                                        value="{{ $location->province }}">
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="col-form-label col-3">Kabupaten: </label>
                                <div class="col-8">
                                    <input type="text" class="form-control-plaintext fw-semibold" readonly
                                        value="{{ $location->regency }}">
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="col-form-label col-3">Kecamatan: </label>
                                <div class="col-8">
                                    <input type="text" class="form-control-plaintext fw-semibold" readonly
                                        value="{{ $location->district }}">
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="col-form-label col-3">Desa: </label>
                                <div class="col-8">
                                    <input type="text" class="form-control-plaintext fw-semibold" readonly
                                        value="{{ $location->area }}">
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-3">Tahun Pengadaan: <span class="text-danger">*</span> </label>
                                <div class="col-2">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ph-calendar"></i>
                                        </span>
                                        <input type="text" id="procurement" name="procurement"
                                            class="form-control datepicker-basic"
                                            value="{{ old('procurement', now()->year) }}" placeholder="2025"
                                            @readonly(true)>
                                    </div>
                                    @if ($errors->has('procurement'))
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                            {{ $errors->first('procurement') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-3">Sub Kelompok: <span class="text-danger">*</span> </label>
                                <div class="col-6">
                                    <select name="idSubCategory" id="idSubCategory" class="form-control select "
                                        data-placeholder="Pilih Sub Kelompok...">
                                        <option></option>
                                        @foreach ($subCategories as $subCategory)
                                            <option value="{{ $subCategory->id }}"
                                                @if ($subCategory->id == old('idSubCategory')) selected @endif>
                                                [{{ rtrim($subCategory->code, '.') }}]
                                                {{ $subCategory->description }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('idSubCategory'))
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                            {{ $errors->first('idSubCategory') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="col-form-label col-lg-3">Bidang: <span class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <select class="form-control select" name="department_id" id="department_id"
                                        data-minimum-results-for-search="Infinity" data-placeholder="Pilih Bidang">
                                        @foreach ($departments as $key => $department)
                                            <option></option>
                                            <option value="{{ $department->id }}"
                                                @if (old('department_id') == $department->id) selected @endif>
                                                {{ $department->code }}
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('department_id'))
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                            {{ $errors->first('department_id') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-3">Kode Aset:<span class="text-danger">*</span> </label>
                                <div class="col-5">
                                    <input type="text" name="asset_code" id="asset_code" value="{{ old(key: 'code') }}"
                                        class="form-control" placeholder="" @readonly(true)>
                                    @if ($errors->has('code'))
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                            {{ $errors->first('code') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-3">Jenis Barang: <span class="text-danger">*</span> </label>
                                <div class="col-9">
                                    <input type="text" name="type" id="type" value="{{ old(key: 'type') }}"
                                        class="form-control" placeholder="">
                                    @if ($errors->has('type'))
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                            {{ $errors->first('type') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-3">Identitas Barang: <span class="text-danger">*</span>
                                </label>
                                <div class="col-9">
                                    <textarea name="asset_identity" id="asset_identity" class="form-control" rows="3">{{ old('asset_identity') }}</textarea>
                                    @if ($errors->has('asset_identity'))
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                            {{ $errors->first('asset_identity') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-3">Tanggal Perolehan: <span
                                        class="text-danger">*</span></label>
                                <div class="col-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ph-calendar"></i>
                                        </span>
                                        <input type="text" class="form-control datepicker-basic-loan"
                                            name="acquisition" placeholder="Pilih Tanggal Peminjaman"
                                            value="{{ old('acquisition', now()->format('D/M/Y')) }}">
                                    </div>
                                    @if ($errors->has('acquisition'))
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                            {{ $errors->first('acquisition') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-3">Jumlah: <span class="text-danger">*</span> </label>
                                <div class="col-9 row">
                                    <div class="col-4">
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
                                        @if ($errors->has('qty'))
                                            <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                                {{ $errors->first('qty') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-6 row">
                                        <label class="col-form-label col-lg-3 text-end">Satuan</label>
                                        <div class="col-lg-9">
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
                                            @if ($errors->has('unit'))
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                                    {{ $errors->first('unit') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3 row">
                                <label class="form-label col-3">Keterangan: <span class="text-danger">*</span> </label>
                                <div class="col-9">
                                    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                            {{ $errors->first('description') }}</div>
                                    @endif
                                </div>
                            </div>
                            {{-- <div class="col-12 mb-3">
                                <label class="form-label">Gambar Produk:</label>
                                <div class="upload-area">
                                    <!-- Preview gambar yang sudah diupload -->
                                    <div id="image-preview" class="row">
                                        <!-- Gambar akan muncul di sini -->
                                    </div>

                                    <!-- Area upload -->
                                    <div class="upload-box">
                                        <input type="file" name="product_images[]" id="product-images" multiple
                                            accept="image/*" style="display: none;">
                                        <label for="product-images" class="upload-label">
                                            <div class="upload-content">
                                                <i class="ph-cloud-arrow-up fs-1 text-muted"></i>
                                                <p class="mb-0">Seret dan lepas gambar di sini atau klik untuk memilih</p>
                                                <small class="text-muted">Format: JPG, JPEG, PNG (Maksimal 5MB per
                                                    gambar)</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div> --}}
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

@push('style_admin')
    {{-- <style>
        .upload-area {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .upload-box {
            text-align: center;
            padding: 30px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-box:hover {
            background-color: #f0f0f0;
        }

        .upload-label {
            display: block;
            cursor: pointer;
        }

        .upload-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        #image-preview {
            margin-bottom: 15px;
        }

        .preview-image {
            position: relative;
            width: 130px;
            height: 120px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .preview-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-image .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 20px;
            height: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
        }
    </style> --}}
@endpush

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
            @if (session('error'))
                new Noty({
                    text: "{{ session('error') }}",
                    type: 'error'
                }).show();
            @endif

            let form = {
                asset_code: $('#asset_code')
            }

            $('#idSubCategory').on('change', function() {
                const id = $(this).val();

                if (!id) return;
                // if (id == form.oldGroup.val()) {
                //     form.code.val(form.oldCode.val());
                //     return;
                // }
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.asset.last-code') }}?idSubCategory=" + id,
                    dataType: 'json',
                    success: function(response) {
                        form.asset_code.val(response.code);
                    },
                    error: function(error) {
                        new Noty({
                            text: "Terjadi kesalahan sistem",
                            type: 'error'
                        }).show();
                    }
                })
            });

            $('#form').on('submit', function(e) {
                e.preventDefault();
                console.log($(this).serialize());

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
