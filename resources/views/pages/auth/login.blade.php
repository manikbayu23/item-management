@extends('layouts.auth')

@section('title_auth', 'Login')

@section('content_auth')

    <section class="content vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="{{ asset('assets/img/panca-mahottama.png') }}" width="90%" class="img-fluid"
                        alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
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
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="text" name="login"
                                            value="{{ old('login', 'johndoe@example.com') }}" class="form-control"
                                            placeholder="john@doe.com" required>
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-user-circle text-muted"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="password" name="password" value="{{ old('password', '12345678') }}"
                                            class="form-control" placeholder="•••••••••••" required>
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-lock text-muted"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    {{-- <a href="{{ route('forgot_password') }}">Forgot password?</a> --}}
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Sign in</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /login form -->
                </div>
            </div>
        </div>
    </section>
@endsection
