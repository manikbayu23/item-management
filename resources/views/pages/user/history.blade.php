@extends('layouts.user-main')
@section('title', content: 'Riwayat Peminjaman Aset')
@section('content_user')
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card loan-card border-success">
                <div class="card-header bg-success bg-opacity-10 d-flex justify-content-between align-items-center">
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
    </div>
@endsection
