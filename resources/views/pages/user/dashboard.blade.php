@extends('layouts.user-main')
@section('title', 'Dashboard')
@section('content_user')
    <div class="mb-3">
        <div class="p-3 rounded-4 shadow-sm bg-white text-center">
            <h1 class="display-8 fw-semibold mb-0">Selamat Datang, <span class="text-primary">{{ Auth::user()->name }}</span>
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-9 row">
            <div class="col-12 col-lg-3">
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
            <div class="col-12 col-lg-3">

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
            <div class="col-12 col-lg-3">

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
            <div class="col-12 col-lg-3">

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


        <div class="col-12 col-md-3">
            <div class="card bg-info text-white"
                style="background-image: url({{ asset('assets/img/background.png') }}); background-size: contain;">
                <div class="card-body text-center">
                    <div class="card-img-actions d-inline-block mb-3">
                        <img class="img-fluid rounded-circle" src="{{ asset('assets/img/user2.png') }}" width="170"
                            height="170" alt="">
                    </div>

                    <h6 class="mb-1">{{ Auth::user()->name }}</h6>
                    <div class="mb-1">
                        <span class="badge bg-warning">{{ Auth::user()->role }}</span>
                    </div>
                    <div class="mb-1">
                        <span>Divisi : {{ Auth::user()->division->name }}</span>
                    </div>
                    <div class="mb-1">
                        <span>Jabatan : {{ Auth::user()->position->name }}</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
