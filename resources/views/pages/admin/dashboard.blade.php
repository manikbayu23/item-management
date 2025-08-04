@extends('layouts.main')

@section('page_name2', 'Dashboard')
@section('content_admin')
    <div class="content">
        <div class="mb-3">
            <div class="p-3 rounded-4 shadow-sm bg-white text-center">
                <h1 class="display-8 fw-semibold mb-0">Selamat Datang, <span
                        class="text-primary">{{ Auth::user()->name }}</span>
                </h1>
            </div>
        </div>
        <div class="d-flex flex-column-reverse flex-lg-row gap-2">
            <div class="col-12 col-lg-9">
                <!-- Main charts -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h5 class="mb-0">Peminjaman Barang Periode {{ Carbon\Carbon::now()->format('m/Y') }}</h5>
                            </div>

                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="d-flex align-items-center justify-content-center mb-2">
                                            <a href="#"
                                                class="bg-success bg-opacity-10 text-success lh-1 rounded-pill p-2 me-3">
                                                <i class="ph-notepad"></i>
                                            </a>
                                            <div>
                                                <div class="fw-semibold">Total Pengajuan</div>
                                                <span class="text-muted" id="borrowingsTotal"></span>
                                            </div>
                                        </div>
                                        <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="d-flex align-items-center justify-content-center mb-2">
                                            <a href="#"
                                                class="bg-info bg-opacity-10 text-info lh-1 rounded-pill p-2 me-3">
                                                <i class="ph-package"></i>
                                            </a>
                                            <div>
                                                <div class="fw-semibold">Dalam Peminjaman</div>
                                                <span class="text-muted" id="inProgress"></span>
                                            </div>
                                        </div>
                                        <div class="w-75 mx-auto mb-3" id="new-sessions"></div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="d-flex align-items-center justify-content-center mb-2">
                                            <a href="#"
                                                class="bg-indigo bg-opacity-10 text-indigo lh-1 rounded-pill p-2 me-3">
                                                <i class="ph-arrow-counter-clockwise"></i>
                                            </a>
                                            <div>
                                                <div class="fw-semibold">Selesai / Dikembalikan</div>
                                                <span class="text-muted" id="completed"></span>
                                            </div>
                                        </div>
                                        <div class="w-75 mx-auto mb-3" id="total-online"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="chart position-relative" id="traffic-sources"></div>
                        </div>
                        <!-- /traffic sources -->

                    </div>
                    <div class="col-6">

                        <!-- Members online -->
                        <div class="card bg-teal text-white">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h3 class="mb-0" id="onlineUser"></h3>
                                    <div class="ms-auto">
                                        <a class="text-white" data-card-action="reload" onclick="getOnlineUsers()">
                                            <i class="ph-arrows-clockwise"></i>
                                        </a>
                                    </div>
                                </div>

                                <div>
                                    User online
                                </div>
                            </div>

                            <div class="rounded-bottom overflow-hidden mx-3" id="members-online"></div>
                        </div>
                        <!-- /members online -->

                    </div>
                    <div class="col-6">
                        <!-- Today's revenue -->
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <h3 class="mb-0" id="totalUser"></h3>
                                    <div class="ms-auto">
                                        <a class="text-white" data-card-action="reload" onclick="getOnlineUsers()">
                                            <i class="ph-arrows-clockwise"></i>
                                        </a>
                                    </div>
                                </div>

                                <div>
                                    Total User
                                </div>
                            </div>

                            <div class="rounded-bottom overflow-hidden" id="today-revenue"></div>
                        </div>
                        <!-- /today's revenue -->

                    </div>
                </div>
                <!-- /main charts -->

                <!-- Dashboard content -->
                <div class="row">
                    <div class="col-xl-12">

                        <!-- Support tickets -->
                        <div class="card">
                            <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                                <h5 class="py-sm-2 my-sm-1">Pengajuan Hari Ini</h5>

                            </div>

                            <div class="card-body d-lg-flex align-items-lg-center justify-content-lg-between flex-lg-wrap">
                                <div class="d-flex align-items-center mb-3 mb-lg-0">
                                    <div id="submissionTodayChart"></div>
                                    <div class="ms-3">
                                        <div class="d-flex align-items-center">
                                            <h5 class="mb-0" id="submissionToday">0</h5>
                                            <span class="text-success ms-2" id="submissionCompare">
                                                <i class="ph-arrow-up fs-base lh-base align-top"></i>
                                                (+0%)
                                            </span>
                                        </div>
                                        <span class="d-inline-block bg-success rounded-pill p-1 me-1"></span>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center mb-3 mb-lg-0">
                                    <a href="#" class="bg-warning bg-opacity-10 text-warning lh-1 rounded-pill p-2">
                                        <i class="ph-clock"></i>
                                    </a>
                                    <div class="ms-3">
                                        <h5 class="mb-0" id="submissionPendingToday">0</h5>
                                        <span class="text-muted">Pengajuan Pending</span>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center mb-3 mb-lg-0">
                                    <a href="#" class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                        <i class="ph-arrow-counter-clockwise"></i>
                                    </a>
                                    <div class="ms-3">
                                        <h5 class="mb-0" id="submissionTotal">0</h5>
                                        <span class="text-muted">Dikembalikan Hari ini</span>
                                    </div>
                                </div>



                            </div>


                        </div>
                        <!-- /support tickets -->
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card bg-info text-white"
                    style="background-image: url({{ asset('assets/img/background.png') }}); background-size: contain;">
                    <div class="card-body text-center">
                        <div class="card-img-actions d-inline-block mb-3">
                            <img class="img-fluid rounded-circle" src="{{ asset('assets/img/user2.png') }}"
                                width="170" height="170" alt="">
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
    </div>
@endsection

@push('script_admin')
    <script>
        $(document).ready(function() {
            getSubmissionToday();
            getSubmission();
            getOnlineUsers();
        });
        const getSubmissionToday = () => {
            $.ajax({
                method: 'GET',
                url: "{{ route('admin.dashboard.borrowings-today') }}",
                success: function(response) {
                    $('#submissionToday').text(response.stats.today ?? 0);
                    $('#submissionTotal').text(response.stats.completed ?? 0);
                    $('#submissionPendingToday').text(response.stats.pending_today ?? 0);

                    // Hitung persentase perbandingan hari ini dengan kemarin
                    const today = response.stats.today ?? 0;
                    const yesterday = response.stats.yesterday ?? 1; // hindari pembagian 0

                    let percent = (((today - yesterday) / yesterday) * 100).toFixed(1);
                    let isUp = percent >= 0;

                    $('#submissionCompare')
                        .html(`
                    <i class="ph-arrow-${isUp ? 'up' : 'down'} fs-base lh-base align-top"></i>
                    (${percent}%)
                `)
                        .removeClass('text-success text-danger')
                        .addClass(isUp ? 'text-success' : 'text-danger');
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        };

        const getSubmission = () => {
            $.ajax({
                method: 'GET',
                url: "{{ route('admin.dashboard.borrowings') }}",
                success: function(response) {
                    $('#borrowingsTotal').text((response.total || 0) + ' Pengajuan');
                    $('#inProgress').text((response.data['in_progress'] || 0) + ' Pengajuan');
                    $('#completed').text((response.data['completed'] || 0) + ' Pengajuan');
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            })
        }
        const getOnlineUsers = () => {
            $.ajax({
                method: 'GET',
                url: "{{ route('admin.dashboard.online-users') }}",
                success: function(response) {
                    $('#onlineUser').text((response.total || 0));
                    $('#totalUser').text((response.total_user || 0));

                },
                error: function(xhr) {
                    console.log(xhr);
                }
            })
        }
    </script>
@endpush
