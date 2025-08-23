@extends('layouts.main')

@section('page_name2', 'Inventaris Ruangan')

@section('content_admin')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Inventaris Barang per Ruangan</h5>
                <div>
                    <button type="button" id="addRoomItem" class="btn btn-primary"><i class="ph-plus-circle me-1"></i>
                        Barang</button>
                    <button type="button" class="btn btn-success" id="btnExport" style="display: none;"><span
                            class="ph-microsoft-excel-logo me-1"></span>
                        Excel</button>
                </div>
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
                <div class="col-12 col-md-2 ">
                    <label class="form-label text-white d-none d-md-block"> :</label>
                    <div>
                        <button type="button" id="filterButton" class="btn btn-primary w-100 w-md-auto"> <span
                                class="ph-magnifying-glass me-1"></span>
                            Cari</button>
                    </div>
                </div>
            </div>
            <table id="itemRoomTable" class="table table-striped">
            </table>
        </div>
    </div>

    <div id="roomItemModal" class="modal fade" data-bs-backdrop="static" tabindex="-1">
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
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Ruangan :</label>
                                <select name="room" id="inputRoom" class="form-control select"
                                    data-placeholder="Pilih Ruangan...">
                                    <option></option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('division'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('division') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Barang :</label>
                                <select name="item" id="inputItem" class="form-control select"
                                    data-placeholder="Pilih Barang...">
                                    <option></option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('division'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('division') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Jumlah Baik :</label>
                                <input type="number" class="form-control input-qty" id="qtyGood" name="qty_good"
                                    min="0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Jumlah Rusak :</label>
                                <input type="number" class="form-control input-qty" id="qtyDemaged" name="qty_demaged"
                                    value="0" min="0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Jumlah Hilang :</label>
                                <input type="number" class="form-control input-qty" id="qtyMissing" name="qty_missing"
                                    value="0" min="0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Jumlah Total :</label>
                                <input type="number" class="form-control" id="qtyTotal" name="qty_total" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-light">
                            <i class="ph-x me-1"></i>
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ph-floppy-disk me-1"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script_admin')
    <script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('assets/demo/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/ui/moment/moment.min.js') }}"></script>

    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>

    <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
@endpush

@push('script_admin')
    <script>
        $(document).ready(function() {

            $('.input-qty').on('input', function() {
                const total = parseInt($('#qtyGood').val()) + parseInt($('#qtyDemaged').val()) + parseInt($(
                    '#qtyMissing').val());
                $('#qtyTotal').val(total);
            });


            let table = $('#itemRoomTable').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: '{{ route('admin.room-inventory.data') }}',
                    data: function(d) {
                        d.room = $('#filterRoom').val();
                        d.item = $('#filterItem').val();
                    },
                    dataSrc: 'data'
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
                        title: 'Ruangan',
                        data: 'room.name',
                        name: 'room.name',
                        orderable: true,
                        searchable: true,
                        width: '10%'
                    },
                    {
                        title: 'Kode Barang',
                        data: 'item.code',
                        className: 'text-center',
                        orderable: true,
                        searchable: true,
                        render: function(data) {
                            return `<span class="badge bg-dark bg-opacity-20 text-reset">${data}</span>`;
                        }
                    }, {
                        title: 'Nama Barang',
                        data: 'item.name',
                        name: 'item.name',
                        orderable: true,
                        searchable: true,
                        width: '15%'
                    }, {
                        title: 'Kategori',
                        data: 'item.category.name',
                        name: 'item.category.name',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                    },
                    {
                        title: 'Unit',
                        data: 'item.unit',
                        name: 'item.unit',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                    },
                    {
                        title: 'Jumlah Total',
                        data: 'qty',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return `<span class="fw-semibold">${data}</span>`
                        }
                    },
                    {
                        title: 'Kondisi',
                        data: 'status',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            const totalBaik = row.conditions
                                .filter(c => c.condition === 'baik')
                                .reduce((sum, item) => sum + item.qty, 0);
                            const totalRusak = row.conditions
                                .filter(c => c.condition === 'rusak')
                                .reduce((sum, item) => sum + item.qty, 0);
                            const totalHilang = row.conditions
                                .filter(c => c.condition === 'hilang')
                                .reduce((sum, item) => sum + item.qty, 0);

                            let html = `<div class="d-flex flex-column gap-1">
                            <span class="badge bg-success bg-opacity-75 rounded-4">Baik <b>${totalBaik}</b></span>
                            <span class="badge bg-warning bg-opacity-75 rounded-4">Rusak <b>${totalRusak}</b></span>
                            <span class="badge bg-danger bg-opacity-75 rounded-4">Hilang <b>${totalHilang}</b></span>
                            </div>`;
                            return html
                        }
                    },
                    {
                        title: 'Dipinjam',
                        data: 'borrowings',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            const totalPinjam = data
                                .reduce((sum, item) => sum + item.qty, 0)
                            return `<span class="fw-semibold">${totalPinjam}</span>`
                        }
                    },
                    {
                        title: 'Jumlah Tersedia',
                        data: 'status',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            const totalBaik = row.conditions
                                .filter(c => c.condition === 'baik')
                                .reduce((sum, item) => sum + item.qty, 0);

                            const totalPinjam = row.borrowings
                                .reduce((sum, item) => sum + item.qty, 0);
                            const tersedia = totalBaik - totalPinjam;

                            let html = `<div class="">
                            <span class="fw-semibold"> ${tersedia}</span>
                            </div>`;
                            return html
                        }
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
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <button type="button" class="edit-room-item dropdown-item" data-id="${data}" 
                                                data-room="${data.room}" data-item="${data.item}" data-all='${JSON.stringify(row)}'>
                                                <i class="ph-pencil-line me-2"></i>
                                                Edit
                                            </button>`;

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

            table.on('xhr', function() {
                const json = table.ajax.json(); // data JSON dari server
                if (json.data && json.data.length > 0) {
                    $('#btnExport').show();
                } else {
                    $('#btnExport').hide();
                }
            });

            $('#filterButton').on('click', function() {
                table.ajax.reload(null, false);
            });

            $('#addRoomItem').on('click', function() {
                $('#roomItemModal .modal-title span').text('Tambah Barang per Ruangan');
                $('#idRoomItem').val(null);
                $('#inputRoom').val('').trigger('change').prop('disabled', false);
                $('#inputItem').val('').trigger('change').prop('disabled', false);
                $('#qtyGood').val(0);
                $('#qtyDemaged').val(0);
                $('#qtyMissing').val(0);
                $('#qtyTotal').val(0);
                $('#roomItemModal').modal('show');
            });

            $('#itemRoomTable').on('click', '.edit-room-item', function() {
                const data = $(this).data('all');

                const totalBaik = data.conditions
                    .filter(c => c.condition === 'baik')
                    .reduce((sum, item) => sum + item.qty, 0);
                const totalRusak = data.conditions
                    .filter(c => c.condition === 'rusak')
                    .reduce((sum, item) => sum + item.qty, 0);
                const totalHilang = data.conditions
                    .filter(c => c.condition === 'hilang')
                    .reduce((sum, item) => sum + item.qty, 0);

                $('#roomItemModal .modal-title span').text('Edit Barang per Ruangan: ');
                $('#idRoomItem').val(data.id);
                $('#inputRoom').val(data.room.id).trigger('change').prop('disabled', true);
                $('#inputItem').val(data.item.id).trigger('change').prop('disabled', true);
                $('#qtyGood').val(totalBaik);
                $('#qtyDemaged').val(totalRusak);
                $('#qtyMissing').val(totalHilang);
                $('#qtyTotal').val((totalBaik + totalHilang + totalHilang));
                $('#roomItemModal').modal('show');
            });

            $('#btnExport').click(function() {
                const room = $('#filterRoom').val();
                const item = $('#filterItem').val();
                window.location.href =
                    `{{ route('admin.room-inventory.export') }}?room=${room}&item=${item}`;
            })

            $('#formRoomItem').on('submit', function(e) {
                e.preventDefault();

                let method = 'POST';
                let url = '{{ route('admin.room-inventory.store') }}';
                const id = $('#idRoomItem').val()
                if (id) {
                    method = 'PUT';
                    url = '{{ route('admin.room-inventory.update', ':id') }}'.replace(':id', id);
                }

                $.ajax({
                    method: method,
                    url: url,
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary',
                            },
                        })
                        table.ajax.reload(null, false);
                        $('#roomItemModal').modal('hide');
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        if (xhr.status == 409) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message,
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-primary',
                                },
                            })
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi masalah jaringan, mohon diulangi.',
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-primary',
                                },
                            })
                        }
                    }
                })
            });
        })
    </script>
@endpush
