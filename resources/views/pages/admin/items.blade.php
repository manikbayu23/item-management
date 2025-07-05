@extends('layouts.main')

@section('page_name2', 'Daftar Barang')

@section('content_admin')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Barang</h5>
                <div>
                    <a href="{{ route('admin.item.create') }}" class="btn btn-primary"><i class="ph-plus-circle me-1"></i>
                        Barang</a>
                </div>
            </div>

            <table id="itemTable" class="table table-striped datatable-select-checkbox">
            </table>
        </div>
    </div>


@endsection

@push('script_admin')
    <script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('assets/demo/pages/datatables_basic.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/vendor/tables/datatables/extensions/select.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/ui/moment/moment.min.js') }}"></script>

    {{-- <script src="{{ asset('assets/demo/pages/datatables_extension_select.js') }}"></script> --}}
@endpush

@push('script_admin')
    <script>
        $(document).ready(function() {

            let table = $('#itemTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.item.data') }}',
                    data: function(d) {
                        d.name = $('#filterName').val();
                        d.status = $('#filterStatus').val();
                    },
                    dataSrc: 'data',
                    // beforeSend: function() {
                    //     Swal.fire({
                    //         title: 'Memuat data...',
                    //         text: 'Silakan tunggu',
                    //         allowOutsideClick: false,
                    //         didOpen: () => {
                    //             Swal.showLoading();
                    //         }
                    //     });
                    // },
                    // complete: function() {
                    //     Swal.close();
                    // },
                },
                columns: [
                    // {
                    //     title: '#',
                    //     data: null,
                    //     orderable: false,
                    //     searchable: false,
                    //     width: '10px',
                    //     render: function(data, type, row, meta) {
                    //         return `<div class="form-check">
                //                     <input type="checkbox" class="form-check-input check-asset "
                //                         id="check-asset-${meta.row}" data-name="${row.name}" data-code="${row.asset_code}">
                //                 </div>`;
                    //     }
                    // },
                    {
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
                        title: 'Kode Barang',
                        data: 'code',
                        render: function(data) {
                            return `<span class="badge bg-dark bg-opacity-20 text-reset">${data}</span>`;
                        }
                    }, {
                        title: 'Nama Barang',
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true,
                        width: '20%'
                    }, {
                        title: 'Kategori',
                        data: 'category.name',
                        name: 'category.name',
                        className: 'text-center',
                    }, {
                        title: 'Status',
                        data: 'status',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            let text = 'Aktif';
                            let color = 'bg-success';
                            let icon = 'ph-check-circle';
                            if (data != 'active') {
                                text = 'NonAktif';
                                color = 'bg-danger';
                                icon = 'ph-x-circle';
                            }
                            return `<span class="badge ${color} rounded-4"><i class="${icon}"></i> ${text}</span>`
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
                                            <button type="button" class="edit-item dropdown-item" data-id="${data}">
                                                <i class="ph-pencil-line me-2"></i>
                                                Edit
                                            </button>`;

                            if (row.status == 'notactive') {
                                html += `
                                                <button type="button" class="option-status dropdown-item"
                                                    data-id="${data}" data-name="${row.name}"
                                                    data-status="1">
                                                    <i class="ph-check-circle me-2"></i>
                                                    Aktifkan
                                                </button>
                                                `;
                            } else {
                                html += `
                                                <button type="button" class="option-status dropdown-item"
                                                    data-id="${data}" data-name="${row.name}"
                                                    data-status="0">
                                                    <i class="ph-x-circle me-2"></i>
                                                    Nonaktifkan
                                                </button>`;
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

            $('#itemTable').on('click', '.edit-item', function() {
                const id = $(this).data('id')
                window.location.href = '{{ route('admin.item.edit', ':id') }}'.replace(':id', id);
            })


            class Asset {
                assets = [];

                addAsset = (code, name) => {
                    this.assets = [...this.assets, {
                        code: code,
                        name: name
                    }];
                    console.log(this.assets);
                }

                removeAsset = (code, name) => {
                    this.assets = this.assets.filter(asset => item.code !== code || item.name !== name);
                    console.log(this.assets);
                }
            }

            const asset = new Asset;

            $('#printAssets').prop('disabled', true);

            $('#itemTable').on('change', '.check-asset', function() {
                const name = $(this).data('name');
                const code = $(this).data('code');
                if ($(this).is(':checked')) {
                    item.addAsset(code, name);
                } else {
                    item.removeAsset(code, name);
                }

                $('#printAssets').prop('disabled', item.assets.length <= 0);
            });

            $('#itemTable').on('click', '.printAsset', function() {
                const index = $(this).data('index');
                $('.check-asset').prop('checked', false);
                $('#printAssets').prop('disabled', true);
                if (item.assets = []) {
                    const name = $(this).data('name');
                    const code = $(this).data('code');
                    item.addAsset(code, name);
                    printAsset(1);
                }
                // $('#check-asset-' + index).prop('checked', true);
            })

            $('#printAssets').on('click', function() {
                printAsset(2);
            });

            const printAsset = (type) => {
                Swal.fire({
                    title: 'Loading...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $.ajax({
                    url: '{{ route('admin.item.print') }}', // URL untuk mengakses controller
                    type: 'POST',
                    data: {
                        assets: item.assets, // Kirim data assets
                        _token: $('meta[name="csrf-token"]').attr(
                            'content') // CSRF Token untuk keamanan
                    },
                    xhrFields: {
                        responseType: 'blob' // penting agar respon dianggap sebagai file
                    },
                    success: function(response) {
                        const blob = new Blob([response], {
                            type: 'application/pdf'
                        });
                        const url = window.URL.createObjectURL(blob);
                        if (type == 1) {
                            item.assets = [];
                        }
                        window.open(url); // buka tab baru untuk cetak
                    },
                    error: function(xhr, status, error) {
                        console.error('Gagal cetak PDF:', error);
                    },
                    complete: function() {
                        Swal.close();
                    }
                });
            }

            $('#itemTable').on('click', '.option-status', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const status = $(this).data('status');

                let text = 'menonaktifkan';
                if (status) {
                    text = 'mengaktifkan';
                }

                Swal.fire({
                    title: 'Perhatian!',
                    text: `Yakin ingin ${text} ${name}?`,
                    icon: 'info',
                    showCancelButton: true,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-light'
                    },
                }).then((result) => {
                    if (result.isConfirmed) {

                        const url = '{{ route('admin.item.update-status', ['id' => ':id']) }}'
                            .replace(':id', id);

                        $.ajax({
                            url: url, // URL untuk mengakses controller
                            method: 'PUT',
                            data: {
                                status: status, // Kirim data assets
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            success: function(response) {
                                new Noty({
                                    text: response.message,
                                    type: 'success'
                                }).show();

                                table.ajax.reload()
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    }
                });
            })
        })
    </script>
@endpush
