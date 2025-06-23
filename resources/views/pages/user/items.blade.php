@extends('layouts.user-main')
@section('title', content: 'Daftar Barang')
@section('content_user')
    <div class="card rounded-0">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h6 mb-0 title-room"> {{ $roomName }}</h1>
                <a href="#filter" class="collapsed btn btn-secondary" data-bs-toggle="collapse">
                    <i class="ph-faders-horizontal"></i>
                </a>
            </div>
        </div>
        <div class="collapse {{ $roomName ? '' : 'show' }}" id="filter">
            <form action="{{ route('user.item') }}" method="GET">
                <div class="row m-3">
                    <div class="col-12 col-md-3 mb-3">
                        <label class="form-label">Ruangan : </label>
                        <select class="form-control select" name="slug">
                            @foreach ($rooms as $room)
                                <option value="{{ $room->slug }}" {{ request('room') == $room->slug ? 'selected' : '' }}>
                                    {{ $room->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-3 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100"><i class="ph-magnifying-glass me-1"></i>
                            Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="list-group list-group-borderless">
        @foreach ($roomItems as $row)
            @php
                $totalQty = 0;

                // dd($row->conditions);
                foreach ($row->conditions as $key => $condition) {
                    if ($condition->condition == 'baik') {
                        $totalQty = $totalQty + $condition->qty;
                    }
                }

                foreach ($row->borrowings as $key => $borrow) {
                    $totalQty = $totalQty - $borrow->qty;
                }

                $textStatus = $totalQty > 0 ? 'Tersedia' : 'Tidak Tersedia';
                $iconStatus = $totalQty > 0 ? 'check' : 'x';
                $colorStatus = $totalQty > 0 ? 'success' : 'warning';
            @endphp
            <div class="shadow bg-white mb-1 create-form" data-name="{{ $row->item->name }}" data-id="{{ $row->id }}"
                data-qty="{{ $totalQty }}">
                <div class="list-group-item hstack gap-3">
                    <div class="status-indicator-container">
                        <i class="ph-package"></i>
                    </div>

                    <div class="flex-fill">
                        <div class="fw-semibold">{{ $row->item->name }}</div>
                        <span class="text-muted"> Jumlah tersedia :
                            <b>{{ $totalQty }}</b> {{ $row->item->unit }}
                        </span>
                    </div>

                    <div class="align-self-center ms-3">
                        <a href="#" class="badge rounded-pill p-1 bg-{{ $colorStatus }}" data-bs-popup="tooltip"
                            title="{{ $textStatus }}" data-bs-toggle="modal" data-bs-trigger="hover"
                            data-bs-target="#call">
                            <i class="ph-{{ $iconStatus }}-circle"></i> <span class="d-none d-md-inline-block"></span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection
@push('script_user')
    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickers/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/picker_date.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.create-form').on('click', function() {
                const name = $(this).data('name');
                const id = $(this).data('id');
                const qty = $(this).data('qty');

                if (qty <= 0) {
                    Swal.fire({
                        title: 'Perhatian!',
                        text: `Barang tidak tersedia`,
                        icon: 'info',
                        customClass: {
                            confirmButton: 'btn btn-primary',
                        },
                    });
                    return;
                }

                Swal.fire({
                    title: 'Perhatian!',
                    text: `Buat form peminjaman ${name}`,
                    icon: 'info',
                    confirmButtonText: 'Buat Form',
                    showCancelButton: true,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-light'
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = '{{ route('user.item.form', ':id') }}'.replace(':id',
                            id);
                    }
                })
            })
        });
    </script>
@endpush
