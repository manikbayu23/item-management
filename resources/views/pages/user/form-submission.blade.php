@extends('layouts.user-main')
@section('title', 'Form Peminjaman Aset')
@section('content_user')
    <div class="d-flex justify-content-center">
        <div class="card col-12 col-md-10 col-lg-8">
            <form action="">
                <div class="card-body">
                    <fieldset>
                        <legend class="fs-base fw-bold border-bottom pb-2 mb-3">Data Diri</legend>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Nama <span class="text-danger">*</span></label></label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">NIK <span class="text-danger">*</span></label></label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="fs-base fw-bold border-bottom pb-2 mb-3">Data Peminjaman</legend>
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <label class="form-label">Detail Asset <span class="text-danger">*</span></label></label>
                                <select data-placeholder="Pilih Asset..." class="form-control select">
                                    <option></option>
                                    @foreach ($assets as $asset)
                                        <option value="{{ $asset->code }}">[{{ $asset->code }}] {{ $asset->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label ">Tanggal Pinjam <span class="text-danger">*</span></label></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ph-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control datepicker-basic-loan" name="start_date"
                                        placeholder="Pilih Tanggal Peminjaman"
                                        value="{{ old('start_date', now()->format('D/M/Y')) }}">
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Tanggal Kembali <span class="text-danger">*</span></label></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ph-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control datepicker-basic-return" name="end_date"
                                        placeholder="Pilih Tanggal Pengembalian"
                                        value="{{ old('start_date', now()->addDay()->format('D/M/Y')) }}">
                                </div>
                            </div>
                            <div class="col-12  mb-3">
                                <label class="form-label">Keterangan <span class="text-danger">*</span></label></label>
                                <textarea name="note" id="" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('script_user')
    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickers/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/picker_date.js') }}"></script>
@endpush
