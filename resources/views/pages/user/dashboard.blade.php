@extends('layouts.user-main')
@section('title', 'Dashboard')
@section('content_user')
    <div class="row">
        <div class="col-lg-3">
            <!-- Members online -->
            <div class="card bg-primary rounded-0 text-white">
                <div class="card-body">
                    <div class="d-flex">
                        <h3 class="mb-0">{{ $stats->last30 }}</h3>
                    </div>

                    <div>
                        Total Pengajuan 30 Hari Terakhir
                    </div>
                </div>

                <div class="rounded-bottom overflow-hidden mx-3" id="members-online"></div>
            </div>
            <!-- /members online -->

        </div>

        <div class="col-lg-3">

            <!-- Current server load -->
            <div class="card bg-warning rounded-0 text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0">{{ $stats->today }}</h3>
                    </div>
                    <div>
                        Pengajuan Hari ini
                    </div>
                </div>

                <div class="rounded-bottom overflow-hidden" id="server-load"></div>
            </div>
            <!-- /current server load -->

        </div>

        <div class="col-lg-3">

            <!-- Today's revenue -->
            <div class="card bg-success rounded-0 text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0">{{ $stats->in_progress }}</h3>
                    </div>

                    <div>
                        Sedang Dipinjam
                    </div>
                </div>

                <div class="rounded-bottom overflow-hidden" id="today-revenue"></div>
            </div>
            <!-- /today's revenue -->

        </div>
        <div class="col-lg-3">

            <!-- Today's revenue -->
            <div class="card bg-pink rounded-0 text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0">{{ $stats->late }}</h3>
                    </div>

                    <div>
                        Melewati Tanggal Pengembalian
                    </div>
                </div>

                <div class="rounded-bottom overflow-hidden" id="today-revenue"></div>
            </div>
            <!-- /today's revenue -->

        </div>
    </div>
@endsection
