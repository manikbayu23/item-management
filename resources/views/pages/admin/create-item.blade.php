@extends('layouts.main')

@section('page_name1', 'Daftar Barang')
@section('page_name1_url', 'admin.item')
@section('page_name2', 'Tambah Barang')

@section('content_admin')
    <div class="content">
        <div class="card">
            <form id="form" action="{{ route('admin.item.store') }}" method="POST" enctype="multipart/form-data">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="row">
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
                                <div class="form-text text-danger text-error" id="category_error" style="display: none;">
                                    <i class="ph-x-circle me-1"></i>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3 row">
                            <label class="form-label col-12 col-md-3">Kode Barang:<span class="text-danger">*</span>
                            </label>
                            <div class="col-12 col-md-4">
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
                            <div class="col-12 col-md-6">
                                <input type="text" name="name" id="name" class="form-control">
                                <div class="form-text text-danger text-error" id="name_error" style="display: none;">
                                    <i class="ph-x-circle me-1"></i>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3 row">
                            <label class="form-label col-12 col-md-3">Merk: <span class="text-danger">*</span>
                            </label>
                            <div class="col-12 col-md-4">
                                <input type="text" name="brand" id="brand" class="form-control">
                                <div class="form-text text-danger text-error" id="brand_error" style="display: none;">
                                    <i class="ph-x-circle me-1"></i>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3 row">
                            <label class="form-label col-12 col-md-3">Satuan: <span class="text-danger">*</span>
                            </label>
                            <div class="col-12 col-lg-3">
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
                                <div class="form-text text-danger text-error" id="unit_error" style="display: none;">
                                    <i class="ph-x-circle me-1"></i>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3 row">
                            <label class="form-label col-12 col-md-3">Keterangan: <span class="text-danger">*</span>
                            </label>
                            <div class="col-12 col-lg-9">
                                <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                                <div class="form-text text-danger text-error" id="notes_error" style="display: none;">
                                    <i class="ph-x-circle me-1"></i>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn btn-primary" type="submit"><i class="ph-floppy-disk"></i>
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
