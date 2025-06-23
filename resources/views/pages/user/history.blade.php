@extends('layouts.user-main')
@section('title', content: 'Riwayat Peminjaman Barang')
@section('content_user')
    @php
        function statusBadge($status)
        {
            $statusMap = [
                'approved' => [
                    'text' => 'Approved',
                    'color' => 'success',
                    'icon' => 'check-circle',
                ],
                'in_progress' => [
                    'text' => 'Sedang Dipinjam',
                    'color' => 'info',
                    'icon' => 'package',
                ],
                'completed' => [
                    'text' => 'Selesai',
                    'color' => 'primary',
                    'icon' => 'arrow-counter-clockwise',
                ],
                'rejected' => [
                    'text' => 'Ditolak',
                    'color' => 'danger',
                    'icon' => 'x-circle',
                ],
                'cancel' => [
                    'text' => 'Batal',
                    'color' => 'light',
                    'icon' => 'prohibit',
                ],
                'pending' => [
                    'text' => 'Pending',
                    'color' => 'warning',
                    'icon' => 'clock',
                ],
            ];

            $data = $statusMap[$status] ?? $statusMap['pending'];

            return $data;
        }

        $startDateRaw = Carbon\Carbon::parse($startDateRaw)->format('m/d/Y');
        $endDateRaw = Carbon\Carbon::parse($endDateRaw)->format('m/d/Y');

    @endphp
    <div class="card rounded-0">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h6 mb-0"><i class="ph-list-dashes"></i> Riwayat Periode :
                    {{ $startDateRaw == $endDateRaw ? $startDateRaw : $startDateRaw . ' - ' . $endDateRaw }}</h1>
                <a href="#filter" class="collapsed btn btn-secondary" data-bs-toggle="collapse">
                    <i class="ph-faders-horizontal"></i>
                </a>
            </div>
        </div>
        <div class="collapse" id="filter">
            <form action="{{ route('user.history') }}">
                <div class="row m-3">
                    <div class="col-12 col-md-3 mb-3">
                        <label class="form-label">Status Pengajuan :</label>
                        <select class="form-control select" name="status">
                            <option value="ALL" {{ request('status') == 'ALL' ? 'selected' : '' }}>Semua</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang
                                Dipinjam</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak
                            </option>
                            <option value="cancel" {{ request('status') == 'cancel' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <label class="form-label">Periode Tanggal Pinjam :</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ph-calendar"></i></span>
                            <input type="text" class="form-control daterange-basic-filter" name="periode">
                        </div>
                    </div>
                    <div class="col-12 col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100"><i class="ph-magnifying-glass"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="list-group list-group-borderless mb-3">
        @forelse ($borrowings as $borrow)
            @php
                $startDate = Carbon\Carbon::parse($borrow->start_date);
                $endDate = Carbon\Carbon::parse($borrow->end_date);
                $dateNow = Carbon\Carbon::now();

                // Hitung selisih hari +1 untuk inklusif
                $dayDiff = $startDate->diffInDays($endDate) + 1;

                if ($startDate->isSameDay($endDate)) {
                    $dateDisplay = $startDate->translatedFormat('d/m/Y');
                } else {
                    $dateDisplay =
                        $startDate->translatedFormat('d/m/Y') . ' s/d ' . $endDate->translatedFormat('d/m/Y');
                }
                $status = statusBadge($borrow->status);
                $dueDate = $dateNow > $endDate && $borrow->status == 'in_progress';
                $textDanger = $dueDate ? 'text-danger' : null;
                $borderColor = $dueDate ? 'danger' : 'primary';
            @endphp
            <div class="shadow bg-white mb-1 ">
                <div class="list-group-item hstack gap-3">
                    <div class="status-indicator-container {{ $textDanger }}">
                        <i class="ph-package"></i>
                    </div>

                    <div class="flex-fill {{ $textDanger }}">
                        <div
                            class="badge bg-light border-start border-width-3 text-body rounded-start-0 border-{{ $borderColor }} mb-2">
                            {{ $borrow->borrow_number }}</div>
                        <div class="fw-semibold mb-1">{{ $borrow->room_item->item->name }}</div>
                        <span class="{{ $textDanger ?? 'text-muted' }} "> Tanggal :
                            {{ $dateDisplay }}
                        </span>
                    </div>

                    <div class="align-self-center ms-2">
                        @if ($dueDate)
                            <a href="#" class="badge rounded-pill p-1 bg-danger bg-opacity-20 text-danger"
                                data-bs-popup="tooltip" title="Melewati Batas Pengembalian" data-bs-toggle="modal"
                                data-bs-trigger="hover">
                                <i class="ph-warning-circle"></i>
                                <span class="d-none d-md-inline-block">Melewati Batas Pengembalian</span>
                            </a>
                        @endif
                        <a href="#"
                            class="badge rounded-pill p-1 bg-{{ $status['color'] }} {{ $status['color'] == 'light' ? 'text-body' : '' }}"
                            data-bs-popup="tooltip" title="{{ $status['text'] }}" data-bs-toggle="modal"
                            data-bs-trigger="hover">
                            <i class="ph-{{ $status['icon'] }}"></i>
                            <span class="d-none d-md-inline-block">{{ $status['text'] }}</span>
                        </a>
                        <a href="#borrow-{{ $borrow->id }}" class="text-body collapsed" data-bs-toggle="collapse">
                            <i class="ph-caret-down collapsible-indicator"></i>
                        </a>
                    </div>
                </div>

                <div class="collapse" id="borrow-{{ $borrow->id }}">
                    <div class="p-3">
                        <ul class="list list-unstyled mb-0">
                            <li><span class="fw-semibold text-muted">Kode barang : </span>
                                {{ $borrow->room_item->item->code }} </li>
                            <li><span class="fw-semibold text-muted">Kategori barang : </span>
                                {{ $borrow->room_item->item->category->name }} </li>
                            <li><span class="fw-semibold text-muted">Ruangan : </span> {{ $borrow->room_item->room->name }}
                            </li>
                            <li><span class="fw-semibold text-muted">Catatan : </span> {{ $borrow->notes }} </li>
                            @if ($borrow->actual_collection_date)
                                @php
                                    $coolectionDate = Carbon\Carbon::parse($borrow->actual_collection_date);
                                @endphp
                                <li><span class="fw-semibold text-muted">Tanggal Pengambilan : </span>
                                    {{ $coolectionDate->translatedFormat('d/m/Y') }} </li>
                            @endif
                            @if ($borrow->actual_return_date)
                                @php
                                    $returnDate = Carbon\Carbon::parse($borrow->actual_return_date);
                                @endphp
                                <li><span class="fw-semibold text-muted">Tanggal Pengembalian : </span>
                                    {{ $returnDate->translatedFormat('d/m/Y') }} </li>
                            @endif
                            @if ($borrow->admin_id)
                                <li class="pt-2"><span class="fw-semibold text-muted">Admin PIC : </span>
                                    {{ $borrow->admin->name }}
                                </li>
                                <li class="pb-2"><span class="fw-semibold text-muted">Catatan Admin : </span>
                                    {{ $borrow->admin_notes }}
                                </li>
                            @endif
                            @if (in_array($borrow->status, ['pending', 'approved']))
                                <li>
                                    <div class="d-flex justify-content-end gap-2 my-2">
                                        <form class="cancel-form-{{ $borrow->id }}"
                                            action="{{ route('user.history.cancel-form', $borrow->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                        </form>
                                        <button type="button" class="btn btn-danger btn btn-sm rounded-pill btn-cancel"
                                            data-id="{{ $borrow->id }}" data-no="{{ $borrow->borrow_number }}"><i
                                                class="ph-prohibit me-1"></i>
                                            Batalkan</button>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @empty
        @endforelse
    </div>
    <div class="d-flex justify-content-center">{{ $borrowings->links() }}</div>
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
            @if (session('success'))
                new Noty({
                    text: "{{ session('success') }}",
                    type: 'success'
                }).show();
            @endif
            @if (session('error'))
                new Noty({
                    text: "{{ session('error') }}",
                    type: 'error'
                }).show();
            @endif

            $('.daterange-basic-filter').daterangepicker({
                startDate: '{{ $startDateRaw }}',
                endDate: '{{ $endDateRaw }}',
                parentEl: '.content-inner'
            });

            $('.btn-cancel').click(function() {
                const id = $(this).data('id');
                const no = $(this).data('no');

                let html =
                    '<p class="text-center text-danger my-3 ">Silahkan isi catatan sebelum melanjutkan</p>';

                html += `<div> 
                        <label class="form-label text-start" >Catatan :</label>
                        <textarea 
                                id="swal-notes" 
                                class="form-control" 
                                placeholder="Masukkan alasan..." 
                                rows="3"
                                required
                                
                            ></textarea>
                            <div class="form-text text-danger" style="display: none;"  id="error-notes"> </div>
                        </div>`;
                Swal.fire({
                    title: `Batalkan pengajuan peminjaman nomor : ${no}`,
                    icon: 'info',
                    html: html,
                    showCancelButton: true,
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-light',
                    },
                    didOpen: () => {
                        // Fokus ke textarea saat modal dibuka
                        document.getElementById('swal-notes').focus()
                    },
                    preConfirm: () => {
                        const notes = $('#swal-notes').val().trim();
                        $('#error-notes').text('');

                        let isValid = true;

                        if (!notes) {
                            $('#error-notes').text('Catatan wajib diisi');
                            $('#error-notes').show();
                            isValid = false;
                        }

                        const wordCount = notes.split(/\s+/).length;
                        if (wordCount < 4) {
                            $('#error-notes').text('Catatan minimal harus terdiri dari 4 kata');
                            $('#error-notes').show();
                            isValid = false;
                        }

                        if (!isValid) {
                            return false;
                        }

                        return notes;

                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.cancel-form-' + id).append(
                            `<input type="hidden" name="notes" value="${result.value}">`);
                        $('.cancel-form-' + id).submit();
                    }
                });
            })

        });
    </script>
@endpush
