@extends('layouts.user-main')
@section('content_user')
    <div class="row">
        <div class="col-lg-3">
            <!-- Members online -->
            <div class="card bg-primary rounded-0 text-white">
                <div class="card-body">
                    <div class="d-flex">
                        <h3 class="mb-0">3,450</h3>
                    </div>

                    <div>
                        Pengajuan
                        <div class="fs-sm opacity-75">489 avg</div>
                    </div>
                </div>

                <div class="rounded-bottom overflow-hidden mx-3" id="members-online"></div>
            </div>
            <!-- /members online -->

        </div>

        <div class="col-lg-3">

            <!-- Current server load -->
            <div class="card bg-success rounded-0 text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0">49.4%</h3>
                    </div>
                    <div>
                        Disetujui
                        <div class="fs-sm opacity-75">34.6% avg</div>
                    </div>
                </div>

                <div class="rounded-bottom overflow-hidden" id="server-load"></div>
            </div>
            <!-- /current server load -->

        </div>

        <div class="col-lg-3">

            <!-- Today's revenue -->
            <div class="card bg-warning rounded-0 text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0">$18,390</h3>
                    </div>

                    <div>
                        Sedang Dipinjam
                        <div class="fs-sm opacity-75">$37,578 avg</div>
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
                        <h3 class="mb-0">$18,390</h3>
                    </div>

                    <div>
                        Melewati Tanggal Pengembalian
                        <div class="fs-sm opacity-75">$37,578 avg</div>
                    </div>
                </div>

                <div class="rounded-bottom overflow-hidden" id="today-revenue"></div>
            </div>
            <!-- /today's revenue -->

        </div>
    </div>
@endsection
@push('script_user')
    <!-- Core JS files -->
    <script src="{{ asset('assets/demo/demo_configurator.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('assets/js/vendor/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script>

    <script src="{{ asset('assets/demo/pages/dashboard.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/streamgraph.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/sparklines.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/lines.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/areas.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/donuts.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/bars.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/progress.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/heatmaps.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/pies.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/bullets.js') }}"></script>
@endpush
