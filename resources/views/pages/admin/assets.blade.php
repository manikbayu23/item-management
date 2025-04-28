@extends('layouts.main')

@section('title_admin', 'Daftar Asset')

@section('content_admin')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-end gap-2">
                <button type="button" id="printAssets" class="btn btn-success"><i class="ph-printer"></i></button>
                <button type="button" id="addDepartment" class="btn btn-primary"><i class="ph-plus-circle"></i></button>
            </div>

            <table class="table table-striped datatable-pagination datatable-select-checkbox">
                <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center">No</th>
                        <th class="text-center">Kode</th>
                        <th>Nama</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $row)
                        <tr>
                            <td>
                                <div class="form-check text-end">
                                    <input type="checkbox" class="form-check-input check-asset"
                                        id="check-asset-{{ $index }}" data-name="Traktor" data-code="12123">
                                </div>
                            </td>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->code }}</td>
                            <td>{{ $row->name }}</td>
                            <td class="text-center">
                                <span class="badge bg-success text-success bg-opacity-20"> <i class="ph-check-circle"></i>
                                    Aktif</span>
                                <span class="badge bg-danger text-danger bg-opacity-20"> <i class="ph-x-circle"></i>
                                    Nonaktif</span>
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <button type="button" class="edit-scope dropdown-item">
                                                <i class="ph-pencil-line me-2"></i>
                                                Edit
                                            </button>
                                            <button type="button" class="dropdown-item printAsset"
                                                data-index="{{ $index }}" data-name="Traktor" data-code="12123">
                                                <i class="ph-printer me-2"></i>
                                                Print
                                            </button>
                                            <button type="button" class="delete-scope dropdown-item">
                                                <i class="ph-check-circle me-2"></i>
                                                Nonaktifkan
                                            </button>
                                            <button type="button" class="delete-scope dropdown-item">
                                                <i class="ph-x-circle me-2"></i>
                                                Aktifkan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
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

            @if (session('success'))
                new Noty({
                    text: "{{ session('success') }}",
                    type: 'success'
                }).show();
            @endif

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
                    this.assets = this.assets.filter(asset => asset.code !== code || asset.name !== name);
                    console.log(this.assets);
                }
            }

            const asset = new Asset;

            $('#printAssets').prop('disabled', true);

            $('.check-asset').on('change', function() {
                const name = $(this).data('name');
                const code = $(this).data('code');
                if ($(this).is(':checked')) {
                    asset.addAsset(code, name);
                } else {
                    asset.removeAsset(code, name);
                }

                $('#printAssets').prop('disabled', asset.assets.length <= 0);
            });

            $('.printAsset').on('click', function() {
                const index = $(this).data('index');
                $('.check-asset').prop('checked', false);
                $('#printAssets').prop('disabled', true);
                if (asset.assets = []) {
                    const name = $(this).data('name');
                    const code = $(this).data('code');
                    asset.addAsset(code, name);
                    printAsset(1);
                }
                // $('#check-asset-' + index).prop('checked', true);
            })

            $('#printAssets').on('click', function() {
                printAsset(2);
            });

            const printAsset = (type) => {
                $.ajax({
                    url: '{{ route('admin.assets.print') }}', // URL untuk mengakses controller
                    type: 'POST',
                    data: {
                        assets: asset.assets, // Kirim data assets
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
                            asset.assets = [];
                        }
                        window.open(url); // buka tab baru untuk cetak
                    },
                    error: function(xhr, status, error) {
                        console.error('Gagal cetak PDF:', error);
                    }
                });
            }
        })
    </script>
@endpush
