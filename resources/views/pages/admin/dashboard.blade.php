@extends('layouts.main')

@section('title_admin', 'Dashboard')

@section('content_admin')
    <div class="content">
        <div class="row">
            <div class="col-sm-6">

                <!-- Available hours -->
                <div class="card text-center">
                    <div class="card-body">

                        <!-- Progress counter -->
                        <div class="svg-center" id="hours-available-progress">
                            <div class="position-relative"><svg width="76" height="76">
                                    <g transform="translate(38,38)">
                                        <path class="d3-progress-background"
                                            d="M0,38A38,38 0 1,1 0,-38A38,38 0 1,1 0,38M0,36A36,36 0 1,0 0,-36A36,36 0 1,0 0,36Z"
                                            style="fill: rgb(107, 206, 115); opacity: 0.2;"></path>
                                        <path class="d3-progress-foreground" filter="url(#blur)"
                                            d="M2.326828918379971e-15,-38A38,38 0 1,1 -34.38342799370878,16.179613079472677L-32.57377388877674,15.328054496342538A36,36 0 1,0 2.204364238465236e-15,-36Z"
                                            style="fill: rgb(0, 126, 10); stroke: rgb(0, 126, 10);"></path>
                                        <path class="d3-progress-front"
                                            d="M2.326828918379971e-15,-38A38,38 0 1,1 -34.38342799370878,16.179613079472677L-32.57377388877674,15.328054496342538A36,36 0 1,0 2.204364238465236e-15,-36Z"
                                            style="fill: rgb(0, 126, 10); fill-opacity: 1;"></path>
                                    </g>
                                </svg><i class="ph-check text-success counter-icon"></i></div>
                            <h4 class="pt-1 mt-2 mb-0">68%</h4>
                            <div>User Complete Quiz</div>
                            <div class="fs-sm text-muted">64% average</div>
                        </div>
                        <!-- /progress counter -->

                    </div>
                </div>
                <!-- /available hours -->

            </div>

            <div class="col-sm-6">

                <!-- Productivity goal -->
                <div class="card text-center">
                    <div class="card-body">

                        <!-- Progress counter -->
                        <div class="svg-center" id="goal-progress">
                            <div class="position-relative"><svg width="76" height="76">
                                    <g transform="translate(38,38)">
                                        <path class="d3-progress-background"
                                            d="M0,38A38,38 0 1,1 0,-38A38,38 0 1,1 0,38M0,36A36,36 0 1,0 0,-36A36,36 0 1,0 0,36Z"
                                            style="fill: rgb(92, 107, 192); opacity: 0.2;"></path>
                                        <path class="d3-progress-foreground" filter="url(#blur)"
                                            d="M2.326828918379971e-15,-38A38,38 0 1,1 -34.3834279937087,-16.179613079472855L-32.573773888776664,-15.328054496342704A36,36 0 1,0 2.204364238465236e-15,-36Z"
                                            style="fill: rgb(92, 107, 192); stroke: rgb(92, 107, 192);"></path>
                                        <path class="d3-progress-front"
                                            d="M2.326828918379971e-15,-38A38,38 0 1,1 -34.3834279937087,-16.179613079472855L-32.573773888776664,-15.328054496342704A36,36 0 1,0 2.204364238465236e-15,-36Z"
                                            style="fill: rgb(92, 107, 192); fill-opacity: 1;"></path>
                                    </g>
                                </svg><i class="ph-trophy text-indigo counter-icon"></i></div>
                            <h4 class="pt-1 mt-2 mb-0">82%</h4>
                            <div>Score</div>
                            <div class="fs-sm text-muted">87% average</div>
                        </div>
                        <!-- /progress counter -->

                    </div>
                </div>
                <!-- /productivity goal -->

            </div>
        </div>
    </div>
@endsection
