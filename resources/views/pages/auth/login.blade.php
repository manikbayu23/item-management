@extends('layouts.auth')

@section('title_auth', 'Login')

@section('content_auth')
    <!-- Content area -->
    <div class="content d-flex justify-content-center align-items-center">

        <!-- Login form -->
        <form class="login-form" method="POST" action="{{ route('login.post') }}">
            @csrf
            @if ($errors->has('identifier'))
                <div class="alert alert-warning alert-icon-start alert-dismissible fade show">
                    <span class="alert-icon bg-warning text-white">
                        <i class="ph-warning-circle"></i>
                    </span>
                    <span class="fw-semibold">Warning!</span> {{ $errors->first('identifier') }}
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
                        <h5 class="mb-0">Login to your account</h5>
                        <span class="d-block text-muted">Enter your credentials below</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username/Email</label>
                        <div class="form-control-feedback form-control-feedback-start">
                            <input type="text" name="identifier" value="{{ old('identifier') }}" class="form-control"
                                placeholder="john@doe.com" required>
                            <div class="form-control-feedback-icon">
                                <i class="ph-user-circle text-muted"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="form-control-feedback form-control-feedback-start">
                            <input type="password" name="password" value="{{ old('password') }}" class="form-control"
                                placeholder="•••••••••••" required>
                            <div class="form-control-feedback-icon">
                                <i class="ph-lock text-muted"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                    </div>

                    <div class="text-center">
                        {{-- <a href="{{ route('forgot_password') }}">Forgot password?</a> --}}
                    </div>
                </div>
            </div>
        </form>
        <!-- /login form -->

    </div>
    <!-- /content area -->
@endsection
