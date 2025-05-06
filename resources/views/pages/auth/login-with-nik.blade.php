@extends('layouts.auth')

@section('title_auth', 'Login')

@section('content_auth')
    <!-- Content area -->
    <div class="content d-flex justify-content-center align-items-center">

        <!-- Login form -->
        <form class="login-form" method="POST" action="{{ route('do-login') }}">
            @csrf
            @if ($errors->has('failed'))
                <div class="alert alert-warning alert-icon-start alert-dismissible fade show">
                    <span class="alert-icon bg-warning text-white">
                        <i class="ph-warning-circle"></i>
                    </span>
                    <span class="fw-semibold">Warning!</span> {{ $errors->first('failed') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (Session::has('message_reset'))
                <div class="alert alert-success alert-icon-start alert-dismissible fade show">
                    <span class="alert-icon bg-success text-white">
                        <i class="ph-check-circle"></i>
                    </span>
                    <span class="fw-semibold">Well done!</span> {{ Session::get('message_reset') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="card mb-0">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="d-inline-flex text-primary align-items-center justify-content-center mb-4 mt-2">
                            <i class="ph-user-circle ph-3x"></i>
                        </div>
                        <h5 class="mb-0">Masuk ke akun</h5>
                        <span class="d-block text-muted">Masukan kredensial</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <div class="form-control-feedback form-control-feedback-start">
                            <input type="text" name="nik" value="{{ old('nik', '12131323') }}" class="form-control"
                                placeholder="123123123xxxx" required>
                            <div class="form-control-feedback-icon">
                                <i class="ph-identification-card text-muted"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                    </div>

                    <div class="text-center text-muted content-divider mb-3">
                        <span class="px-2">or sign in with</span>
                    </div>

                    <div class="text-center mb-3">
                        <a href="{{ route('login') }}"
                            class="btn btn-flat-secondary btn-labeled btn-labeled-start rounded-pill">
                            <span class="btn-labeled-icon bg-secondary text-white rounded-pill">
                                <i class="ph-user-circle"></i>
                            </span>
                            Akun Silagas
                        </a>
                    </div>
                </div>
            </div>
        </form>
        <!-- /login form -->

    </div>
    <!-- /content area -->
@endsection
