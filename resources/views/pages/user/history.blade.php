@extends('layouts.user-main')
@section('title', content: 'Riwayat Peminjaman Barang')
@section('content_user')
    {{-- <div class="row">
        <div class="col-12 col-md-6">
            <div class="card loan-card border-success">
                <div
                    class="card-header bg-success rounded-0 bg-opacity-10 d-flex justify-content-between align-items-center">
                    <span class="text-muted small">
                        <i class="ph-calendar me-1"></i> 15 Mei 2024
                    </span>
                    <span class="status-badge approved">
                        <i class="ph-check-circle me-1"></i> Disetujui
                    </span>
                </div>

                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">Laptop Dell XPS 15</h5>
                            <p class="text-muted small mb-2">Kode : 12121</p>

                            <div class="d-flex align-items-center">
                                <div>
                                    <i class="ph-clock "></i>
                                </div>
                                <div>
                                    <small class="text-muted">Periode</small>
                                    <p class="mb-0">20 Mei - 25 Mei 2024 (5 hari)</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white d-flex justify-content-end align-items-center">
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="ph-eye me-1"></i> Detail
                    </button>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="card rounded-0">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h5 mb-0"><i class="ph-list-dashes"></i> Semua Pengajuan</h1>
                <a href="#filter" class="collapsed btn btn-secondary" data-bs-toggle="collapse">
                    <i class="ph-faders-horizontal"></i>
                </a>
            </div>
        </div>
        <div class="collapse" id="filter">
            <form action="">
                <div class="row m-3">
                    <div class="col-12 col-md-3 mb-3">
                        <label class="form-label">Status Pengajuan </label>
                        <select class="form-control select">
                            <option value="" selected>Semua</option>
                            <option value="0">Pending</option>
                            <option value="1">Disetujui</option>
                            <option value="2">Dalam Pemakaian</option>
                            <option value="3">Ditolak</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <label class="form-label">Periode Tanggal Pinjam </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ph-calendar"></i></span>
                            <input type="text" class="form-control daterange-basic"
                                value="{{ old('periode', now()->subDays(7)->format('D/M/Y') . '-' . now()->format('D/M/Y')) }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 mb-3 d-flex align-items-end">
                        <div>
                            <button type="submit" class="btn btn-primary"><i class="ph-magnifying-glass"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="list-group list-group-borderless">
        <div class="shadow bg-white mb-1">
            <div class="list-group-item hstack gap-3">
                <div class="status-indicator-container">
                    <i class="ph-package"></i>
                </div>

                <div class="flex-fill">
                    <div class="fw-semibold">Laptop Dell XPS 15</div>
                    <span class="text-muted"> Periode :
                        20 Mei - 25 Mei 2024
                    </span>
                </div>

                <div class="align-self-center ms-3">
                    <a href="#" class="badge rounded-pill p-1 bg-success" data-bs-popup="tooltip" title="Disetujui"
                        data-bs-toggle="modal" data-bs-trigger="hover" data-bs-target="#call">
                        <i class="ph-check-circle"></i> <span class="d-none d-md-inline-block">Disetujui</span>
                    </a>
                    <a href="#james-handle" class="text-body collapsed" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator"></i>
                    </a>
                </div>
            </div>

            <div class="collapse" id="james-handle">
                <div class="p-3">
                    <ul class="list list-unstyled mb-0">
                        <li><i class="ph-map-pin me-2"></i> Amsterdam</li>
                        <li><i class="ph-briefcase me-2"></i> Senior Designer</li>
                        <li><i class="ph-phone me-2"></i> +1(800)431 8996</li>
                        <li><i class="ph-at me-2"></i> <a href="#">james@alexander.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="shadow bg-white">
            <div class="list-group-item hstack gap-3">
                <div class="status-indicator-container">
                    <i class="ph-package"></i>
                </div>

                <div class="flex-fill">
                    <div class="fw-semibold">Laptop Dell XPS 15</div>
                    <span class="text-muted"> Periode :
                        20 Mei - 25 Mei 2024
                    </span>
                </div>

                <div class="align-self-center ms-3">
                    <a href="#" class="badge rounded-pill p-1 bg-success" data-bs-popup="tooltip" title="Disetujui"
                        data-bs-toggle="modal" data-bs-trigger="hover" data-bs-target="#call">
                        <i class="ph-check-circle"></i> <span class="d-none d-md-inline-block">Disetujui</span>
                    </a>
                    <a href="#james-handle" class="text-body collapsed" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator"></i>
                    </a>
                </div>
            </div>

            <div class="collapse" id="james-handle">
                <div class="p-3">
                    <ul class="list list-unstyled mb-0">
                        <li><i class="ph-map-pin me-2"></i> Amsterdam</li>
                        <li><i class="ph-briefcase me-2"></i> Senior Designer</li>
                        <li><i class="ph-phone me-2"></i> +1(800)431 8996</li>
                        <li><i class="ph-at me-2"></i> <a href="#">james@alexander.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script_user')
    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickers/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/picker_date.js') }}"></script>
@endpush
