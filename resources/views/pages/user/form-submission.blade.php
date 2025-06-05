@extends('layouts.user-main')
@section('title', 'Form Peminjaman Barang')
@section('content_user')
    <div class="d-flex justify-content-center">
        <div class="card col-12 col-md-10 col-lg-6 rounded-0">
            <form action="{{ route('user.item.store', $roomItem->id) }}" method="POST">
                @csrf
                <div class="card-body">
                    <fieldset>
                        <legend class="fs-base fw-bold border-bottom pb-2 mb-3"><i class="ph-package"></i> Data Peminjaman
                        </legend>
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Ruangan :</label>
                                <input type="text" class="form-control-plaintext fw-semibold"
                                    value="{{ $roomItem->room->name }}">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Nama Barang :</label>
                                <input type="text" class="form-control-plaintext fw-semibold"
                                    value="{{ $roomItem->item->name }}">
                            </div>
                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label">Jumlah <span class="text-danger">*</span> :</label>
                                <div class="input-group">
                                    <input type="number" name="qty" class="form-control" value="{{ old('qty') }}"
                                        placeholder="Contoh : 1" min="0">
                                    <span class="input-group-text">{{ $roomItem->item->unit }}</span>
                                </div>
                                @if ($errors->has('qty'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('qty') }}</div>
                                @endif
                            </div>
                            <div class="col-6 col-md-6 mb-3">
                                <label class="form-label">Tanggal Pinjam <span class="text-danger">*</span> :</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ph-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control datepicker-basic-loan" name="start_date"
                                        placeholder="Pilih Tanggal Peminjaman"
                                        value="{{ old('start_date', now()->format('D/M/Y')) }}">
                                </div>
                                @if ($errors->has('start_date'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('start_date') }}</div>
                                @endif
                            </div>

                            <div class="col-6 col-md-6 mb-3">
                                <label class="form-label">Tanggal Kembali <span class="text-danger">*</span> :</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ph-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control datepicker-basic-return" name="end_date"
                                        placeholder="Pilih Tanggal Pengembalian"
                                        value="{{ old('end_date', now()->addDay()->format('D/M/Y')) }}">
                                </div>
                                @if ($errors->has('end_date'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('end_date') }}</div>
                                @endif
                            </div>
                            <div class="col-12  mb-3">
                                <label class="form-label">Keterangan <span class="text-danger">*</span> :</label>
                                <textarea name="notes" class="form-control" rows="5">{{ old('notes') }}</textarea>
                                @if ($errors->has('notes'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('notes') }}</div>
                                @endif
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-primary"><i class="ph-paper-plane-tilt"></i> Submit</button>
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
    <script src="{{ asset('assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            @if (session('error'))
                Swal.fire({
                    title: 'Perhatian!',
                    text: "{{ session('error') }}",
                    icon: 'info',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                    },
                });
            @endif

        });
    </script>
@endpush
