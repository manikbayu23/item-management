@extends('layouts.main')

@section('page_name2', 'Peminjaman Barang')

@section('content_admin')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mb-0">Daftar Peminjaman Barang</h5>
                {{-- <div>
                    <button type="button" id="addRoomItem" class="btn btn-primary"><i class="ph-plus-circle me-1"></i>
                        Barang</button>
                </div> --}}
            </div>
            <div class="row mx-2 my-2">
                <div class="col-12 col-md-3 mb-3">
                    <label class="form-label">Ruangan :</label>
                    <select id="filterRoom" class="form-control select" data-placeholder="Pilih Ruangan...">
                        @if (Auth::user()->role == 'admin')
                            <option value="ALL" selected>SEMUA RUANGAN</option>
                        @endif
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Barang :</label>
                    <select id="filterItem" class="form-control select" data-placeholder="Pilih Barang...">
                        <option value="ALL" selected>SEMUA BARANG</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">[{{ $item->code }}] - {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-2 mb-3">
                    <label class="form-label">Status :</label>
                    <select id="filterStatus" class="form-control select" data-placeholder="Pilih Status...">
                        <option value="ALL" selected>SEMUA STATUS</option>
                        <option value="pending">PENDING</option>
                        <option value="approved">APPROVED</option>
                        <option value="in_progress">SEDANG DIPINJAM</option>
                        <option value="completed">SELESAI</option>
                        <option value="rejected">DITOLAK</option>
                        <option value="cancel">BATAL</option>
                    </select>
                </div>
                <div class="col-12 col-md-2 ">
                    <label class="form-label text-white d-none d-md-block"> :</label>
                    <div>
                        <button type="button" id="filterButton" class="btn btn-primary w-100 w-md-auto"> <span
                                class="ph-magnifying-glass me-1"></span>
                            Cari</button>
                    </div>
                </div>
            </div>
            <table id="borrowItemsTable" class="table table-striped display nowrap" style="width:100%">
            </table>
        </div>
    </div>

    <div id="borrowDetailModal" class="modal fade" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ph-package me-2"></i><span></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formRoomItem" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="idRoomItem">
                        <fieldset class="mb-3">
                            <legend class="fs-base fw-bold border-bottom pb-2 mb-1"> Data
                                Peminjaman
                            </legend>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Tanggal Peminjaman:</label>
                                    <div class="form-control-plaintext text-muted fw-medium" id="borrow-date"></div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Kode Barang:</label>
                                    <div class="form-control-plaintext text-muted fw-medium" id="borrow-item-code"></div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Nama Barang:</label>
                                    <div class="form-control-plaintext text-muted fw-medium" id="borrow-item-name"></div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Kategori Barang:</label>
                                    <div class="form-control-plaintext text-muted fw-medium" id="borrow-item-category">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Ruangan:</label>
                                    <div class="form-control-plaintext text-muted fw-medium" id="borrow-room-name"></div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Peminjam:</label>
                                    <div class="form-control-plaintext text-muted fw-medium" id="borrow-user-name"></div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Status:</label>
                                    <div class="form-control-plaintext text-muted fw-medium" id="borrow-status"></div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Catatan:</label>
                                    <div class="form-control-plaintext text-muted fw-medium" id="borrow-user-notes"></div>
                                </div>
                                <div class="col-12 col-md-6" id="collection-date-col">
                                    <label class="form-label fw-bold">Tanggal Pengambilan:</label>
                                    <div class="form-control-plaintext text-muted fw-medium" id="borrow-collection-date">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6" id="return-date-col">
                                    <label class="form-label fw-bold">Tanggal Pengembalian:</label>
                                    <div class="form-control-plaintext text-muted fw-medium" id="borrow-return-date">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6" id="admin-name-col">
                                    <label class="form-label fw-bold">Admin:</label>
                                    <div class="form-control-plaintext text-muted fw-medium" id="borrow-admin-name"></div>
                                </div>
                                <div class="col-12 col-md-6" id="admin-notes-col">
                                    <label class="form-label fw-bold">Catatan Admin:</label>
                                    <div class="form-control-plaintext text-muted fw-medium" id="borrow-admin-notes">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="fs-base fw-bold border-bottom pb-1 mb-1">
                                <a href="#log-container" class="collapsed btn btn-link" data-bs-toggle="collapse">
                                    Lihat Aktivitas
                                    Peminjaman <i class="ph-caret-down collapsible-indicator ms-2"></i>
                                </a>
                            </legend>

                            <div class="container collapse" id="log-container">
                                <div class="table-responsive">
                                    <table id="borrowing-log-table" class="table table-bordered" style="width: 100%; ">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 5%;">No</th>
                                                <th style="width: 20%;">Nama</th>
                                                <th style="width: 15%;">Posisi</th>
                                                <th style="width: 15%;">Status</th>
                                                <th style="width: 30%;">Notes</th>
                                                <th style="width: 15%;">Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div>
                            <button type="button" data-bs-dismiss="modal" class="btn btn-light">
                                {{-- <i class="ph-x me-1"></i> --}}
                                Tutup
                            </button>
                        </div>
                        <div id="actions-button">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('style_admin')
    <style>

    </style>
@endpush
@push('script_admin')
    <script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('assets/demo/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/ui/moment/moment.min.js') }}"></script>

    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>

    <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/components_tooltips.js') }}"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
@endpush

@push('script_admin')
    <script>
        $(document).ready(function() {

            let table = $('#borrowItemsTable').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: '{{ route('admin.borrow-item.data') }}',
                    data: function(d) {
                        d.room = $('#filterRoom').val();
                        d.item = $('#filterItem').val();
                        d.status = $('#filterStatus').val();
                    },
                    dataSrc: 'data'
                },
                rowCallback: function(row, data, index) {
                    const dateNow = new Date();
                    const endDate = new Date(data.end_date);
                    if (data.status == 'in_progress') {
                        if (endDate.setHours(0, 0, 0, 0) < dateNow.setHours(0, 0, 0, 0)) {
                            $(row).find('td')
                                .addClass('text-danger'); // Reset warna cell
                            $(row).attr('title', 'Barang sudah melewati tanggal pengembalian');
                        } else if (endDate.setHours(0, 0, 0, 0) == dateNow.setHours(0, 0, 0, 0)) {
                            $(row).find('td')
                                .addClass('text-warning'); // Reset warna cell
                            $(row).attr('data-bs-popup', 'tooltip');
                            $(row).attr('title', 'Barang memasuki masa tenggang tanggal pengembalian');
                        }
                    }
                    $(row).find('[data-bs-toggle="tooltip"]').tooltip();

                },
                columns: [{
                        title: 'No',
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        title: 'No Peminjaman',
                        data: 'borrow_number',
                        name: 'borrow_number',
                        orderable: true,
                        searchable: true,
                        className: 'text-center',
                        width: '15%'
                    },
                    {
                        title: 'Tanggal Peminjaman',
                        data: null,
                        className: 'text-center',
                        orderable: true,
                        searchable: true,
                        width: '15%',
                        render: function(data, type, row) {
                            const startDate = new Date(row.start_date);
                            const endDate = new Date(row.end_date);

                            // Hitung selisih milisecond, lalu konversi ke hari
                            const timeDiff = endDate - startDate;
                            const dayDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)) +
                                1; // +1 untuk inklusif

                            let dateDisplay;
                            if (startDate.toDateString() === endDate.toDateString()) {
                                dateDisplay = `${startDate
                                    .toLocaleDateString('id-ID')} (1 Hari)`; // Format tanggal sesuai locale
                            } else {
                                dateDisplay =
                                    `${startDate.toLocaleDateString('id-ID')} s/d ${endDate.toLocaleDateString('id-ID')} (${dayDiff} hari)`;
                            }
                            return `<span>${dateDisplay}</span>`;
                        }
                    },
                    {
                        title: 'Nama Barang',
                        data: 'room_item.item.name',
                        name: 'item.name',
                        orderable: true,
                        searchable: true,
                        width: '15%'
                    },
                    {
                        title: 'Ruangan',
                        data: 'room_item.room.name',
                        name: 'room.name',
                        orderable: true,
                        searchable: true,
                        width: '10%'
                    },
                    {
                        title: 'Jumlah',
                        data: 'qty',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return `<span class="fw-semibold">${data}</span>`
                        }
                    },
                    {
                        title: 'Status',
                        data: 'status',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return statusBadge(data);
                        }
                    },
                    {
                        title: 'Peminjam',
                        data: 'user.name',
                        name: 'user.name',
                    },
                    {
                        title: 'Aksi',
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: (data, type, row, meta) => {

                            let html = `<div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">`;

                            html += `<button type="button" class="borrow-option dropdown-item" data-option="detail" data-id="${data}" 
                                        data-no="${data}" data-item="${data.item}" data-all='${JSON.stringify(row)}'>
                                        <i class="ph-eye me-2"></i>
                                        Detail
                                    </button>`;

                            const dateNow = new Date();
                            const endDate = new Date(row.end_date);
                            if (row.status == 'in_progress') {
                                if (endDate.setHours(0, 0, 0, 0) < dateNow.setHours(0, 0, 0, 0)) {
                                    html += `<button type="button" class="borrow-option dropdown-item" data-option="reminder" data-id="${data}" data-no="${row.borrow_number}">
                                        <i class="ph-bell-ringing me-2"></i>
                                        Pengingat Pengembalian
                                    </button>`;
                                }
                            }
                            html += `
                                        </div>
                                    </div>`;

                            return html;
                        }
                    }
                ],
                paging: true,
                pageLength: 25, // default jumlah baris per halaman
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                language: {
                    processing: "Sedang memproses...",
                    lengthMenu: "Tampilkan _MENU_ baris",
                    zeroRecords: "Tidak ditemukan data yang cocok",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    search: "Cari:",
                    paginate: {
                        first: "First",
                        last: "End",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });

            $('#filterButton').on('click', function() {
                table.ajax.reload(null, false);
            });

            $('#borrowItemsTable').on('click', '.borrow-option', function() {
                const option = $(this).data('option');
                const id = $(this).data('id');
                if (option == 'detail') {
                    const data = $(this).data('all');
                    borrowDetail(data);
                } else {
                    const no = $(this).data('no');
                    borrowingReminder(id, no);
                }
            });

            const borrowingReminder = (id, no) => {
                Swal.fire({
                    title: 'Perhatian!',
                    icon: 'info',
                    text: `Kirim notifikasi pengingat pengembalian peminjaman barang nomor : ${no}`,
                    showCancelButton: true,
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-light',
                    },
                    preConfirm: () => {
                        Swal.showLoading();
                        const url = '{{ route('admin.borrow-item.reminder', ':id') }}'
                            .replace(
                                ':id', id);
                        return $.ajax({
                            url: url, // ganti sesuai API kamu
                            method: 'PUT',
                            data: {
                                no: no,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            dataType: 'json'
                        }).then(response => {
                            // optional: validasi respon jika perlu
                            if (!response.success) {
                                Swal.fire({
                                    title: 'Gagal',
                                    icon: 'error',
                                    text: response.message,
                                    customClass: {
                                        confirmButton: 'btn btn-primary',
                                    },
                                });
                                return false;
                            }

                            return response; // dikirim ke then(result)

                        }).catch(error => {
                            const response = error.responseJSON;
                            Swal.fire({
                                title: 'Gagal',
                                icon: 'error',
                                text: response.message,
                                customClass: {
                                    confirmButton: 'btn btn-primary',
                                },
                            });
                            return false;
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Berhasil',
                            icon: 'success',
                            text: result.value.message,
                            customClass: {
                                confirmButton: 'btn btn-primary',
                            },
                        })
                    }
                });
            }


            const borrowDetail = (data) => {
                $('#borrowDetailModal .modal-title span').html(
                    `Pengajuan Peminjaman No : <b> ${data.borrow_number} </b>`);

                const startDate = new Date(data.start_date);
                const endDate = new Date(data.end_date);

                // Hitung selisih milisecond, lalu konversi ke hari
                const timeDiff = endDate - startDate;
                const dayDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)) +
                    1; // +1 untuk inklusif

                let dateDisplay;
                if (startDate.toDateString() === endDate.toDateString()) {
                    dateDisplay = `${startDate
                                    .toLocaleDateString('id-ID')} (1 Hari)`; // Format tanggal sesuai locale
                } else {
                    dateDisplay =
                        `${startDate.toLocaleDateString('id-ID')} s/d ${endDate.toLocaleDateString('id-ID')} (${dayDiff} hari)`;
                }
                $('#borrow-date').html(dateDisplay);
                $('#borrow-item-code').html(data.room_item.item.code);
                $('#borrow-item-name').html(data.room_item.item.name);
                $('#borrow-item-category').html(data.room_item.item.category.name);
                $('#borrow-room-name').html(data.room_item.room.name);
                $('#borrow-user-name').html(data.user.name);

                if (data.borrowing_logs.length > 0) {
                    $('#borrowing-log-table tbody').html(borrowingLogsTable(data.borrowing_logs));
                }

                const status = data.status;
                $('#borrow-status').html(statusBadge(status));
                $('#borrow-user-notes').html(data.notes);

                $('#collection-date-col').hide();
                if (data.actual_collection_date) {
                    $('#borrow-collection-date').html(formatedIDDate(data.actual_collection_date));
                    $('#collection-date-col').show();
                }

                $('#return-date-col').hide();
                if (data.actual_return_date) {
                    $('#borrow-return-date').html(formatedIDDate(data.actual_return_date));
                    $('#return-date-col').show();
                }

                $('#admin-notes-col').hide();
                $('#admin-name-col').hide();
                if (data.admin_id) {
                    $('#admin-notes-col').show();
                    $('#admin-name-col').show();
                    $('#borrow-admin-name').html(data.admin.name);
                    $('#borrow-admin-notes').html(data.admin_notes);
                }

                let actionsButton;
                if (status == 'pending') {
                    actionsButton = `<button type="button" class="btn btn-danger action-detail-button" data-id="${data.id}" data-no="${data.borrow_number}"  data-action="rejected">
                                        <i class="ph-x-circle me-2"></i>
                                        Tolak
                                    </button>
                                    <button type="button" class="btn btn-success action-detail-button" data-id="${data.id}" data-no="${data.borrow_number}" data-action="approved">
                                        <i class="ph-check-circle me-2"></i>
                                        Approved
                                    </button>
                                   `;
                } else if (status == 'approved') {
                    actionsButton = `<button type="button" class="btn btn-warning action-detail-button" data-id="${data.id}" data-no="${data.borrow_number}" data-action="cancel">
                                        <i class="ph-prohibit me-2"></i>
                                        Batalkan
                                    </button>
                                    <button type="button" class="btn btn-info action-detail-button" data-id="${data.id}" data-no="${data.borrow_number}" data-start="${data.start_date}" data-end="${data.end_date}" data-action="in_progress">
                                        <i class="ph-package me-2"></i>
                                        Barang Diambil
                                    </button>`;
                } else if (status == 'in_progress') {
                    actionsButton = `<button type="button" class="btn btn-primary action-detail-button" data-id="${data.id}" data-no="${data.borrow_number}" data-start="${data.start_date}" data-end="${data.end_date}" data-action="completed">
                                        <i class="ph-arrow-counter-clockwise me-2"></i>
                                        Selesaikan
                                    </button>`;
                }
                $('#actions-button').empty();
                $('#actions-button').append(actionsButton);
                $('#borrowDetailModal').modal('show');
            }

            const borrowingLogsTable = (data) => {
                let table;
                data.forEach((row, index) => {
                    const role = row.admin_id ? 'Admin' : 'Peminjam';
                    const name = row.admin_id ? row.admin.name : row.user.name;
                    const date = new Date(row.created_at);

                    const options = {
                        weekday: 'short', // e.g., "Sunday"
                        year: 'numeric',
                        month: 'numeric', // bisa juga 'short' atau '2-digit'
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false // pakai 24 jam
                    };

                    const formattedDate = date.toLocaleString('id-ID', options);
                    table += ` <tr>
                                <td>${index +1}</td>
                                <td>${name}</td>
                                <td>${role}</td>
                                <td>${statusBadge(row.status)}</td>
                                <td>${row.notes}</td>
                                <td>${formattedDate}</td>
                            </tr>`;
                });

                return table;
            }

            const statusBadge = (status) => {
                const statusMap = {
                    approved: {
                        text: 'Approved',
                        color: 'success',
                        icon: 'check-circle',
                    },
                    in_progress: {
                        text: 'Sedang Dipinjam',
                        color: 'info',
                        icon: 'package',
                    },
                    completed: {
                        text: 'Selesai',
                        color: 'primary',
                        icon: 'arrow-counter-clockwise',
                    },
                    rejected: {
                        text: 'Ditolak',
                        color: 'danger',
                        icon: 'x-circle',
                    },
                    cancel: {
                        text: 'Batal',
                        color: 'light text-body',
                        icon: 'prohibit',
                    },
                    pending: {
                        text: 'Pending',
                        color: 'warning',
                        icon: 'clock',
                    }
                };

                const {
                    text,
                    color,
                    icon
                } = statusMap[status] || statusMap['pending'];
                return `<span class="badge bg-${color} bg-opacity-75 rounded-4"><i class="ph-${icon}"></i> ${text}</span>`;
            };

            const formatedIDDate = (date, options = {}) => {
                const formatDate = new Date(date);
                return formatDate.toLocaleString('id-ID', options);
            }


            $('#actions-button').on('click', '.action-detail-button', function() {
                const id = $(this).data('id');
                const action = $(this).data('action');
                const no = $(this).data('no');

                let title;
                if (action == 'reject') {
                    title = 'tolak';
                } else if (action == 'in_progress') {
                    title = 'konfirmasi ambil barang';
                } else if (action == 'completed') {
                    title = 'selesaikan';
                } else {
                    title = action;
                }

                const titleText = title.charAt(0).toUpperCase() + title.slice(1);
                $('#borrowDetailModal').modal('hide');

                let html =
                    '<p class="text-center text-danger my-3 ">Silahkan isi catatan sebelum melanjutkan</p>';
                if (action == 'completed' || action == 'in_progress') {
                    const actionText = action == 'completed' ? 'pengembalian' : 'pengambilan';
                    html =
                        `<p class="text-center text-danger mb-3">Silahkan isi tanggal ${actionText} dan catatan sebelum melanjutkan!</p>`;

                    const startDateRaw = $(this).data('start'); // contoh: 2025-06-04
                    const endDateRaw = $(this).data('end'); // contoh: 2025-06-10


                    const now = new Date();
                    const year = now.getFullYear();
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const day = String(now.getDate()).padStart(2, '0');
                    const hour = String(now.getHours()).padStart(2, '0');
                    const minute = String(now.getMinutes()).padStart(2, '0');
                    const defaultNow = `${year}-${month}-${day}T${hour}:${minute}`;

                    const startDate = `${startDateRaw}T00:00`;
                    const endDate = `${endDateRaw}T${hour}:${minute}`;

                    html += `<div class="mb-2">
                            <label class="form-label ">Tanggal ${actionText} :</label>
                            <input type="datetime-local" class="form-control"  id="swal-datetime" value="${defaultNow}" min="${startDate}" max="${action == 'in_progress' ? endDate : defaultNow}">
                            <div class="form-text text-danger" style="display: none;" id="error-datetime"></div>
                            </div> `;
                }

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
                    title: `${titleText} pengajuan peminjaman nomor : ${no}`,
                    icon: 'info',
                    html: html,
                    showCancelButton: true,
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
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

                        let datetime;
                        if (action == 'completed' || action == 'in_progress') {
                            datetime = $('#swal-datetime').val().trim();
                            $('#error-datetime').text('');
                        };

                        let isValid = true;

                        if (!notes) {
                            $('#error-notes').text('Catatan wajib diisi');
                            $('#error-notes').show();
                            isValid = false;
                        }
                        if (action == 'completed' || action == 'in_progress') {
                            if (!datetime) {
                                $('#error-datetime').text('Tanggal wajib diisi');
                                $('#error-datetime').show();
                                isValid = false;
                            }
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
                        Swal.showLoading();
                        const url = '{{ route('admin.borrow-item.update', ':id') }}'
                            .replace(
                                ':id', id);
                        return $.ajax({
                            url: url, // ganti sesuai API kamu
                            method: 'PUT',
                            data: {
                                status: action,
                                notes: notes,
                                datetime: datetime
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            dataType: 'json'
                        }).then(response => {
                            // optional: validasi respon jika perlu
                            if (!response.success) {
                                Swal.fire({
                                    title: 'Gagal',
                                    icon: 'error',
                                    text: response.message,
                                    customClass: {
                                        confirmButton: 'btn btn-primary',
                                    },
                                });
                                return false;
                            }

                            return response; // dikirim ke then(result)

                        }).catch(error => {
                            const response = error.responseJSON;
                            Swal.fire({
                                title: 'Gagal',
                                icon: 'error',
                                text: response.message,
                                customClass: {
                                    confirmButton: 'btn btn-primary',
                                },
                            });
                            return false;
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Berhasil',
                            icon: 'success',
                            text: result.value.message,
                            customClass: {
                                confirmButton: 'btn btn-primary',
                            },
                        })
                        table.ajax.reload(null, false);
                    } else {
                        $('#borrowDetailModal').modal('show');
                    }
                });
            })
        })
    </script>
@endpush
