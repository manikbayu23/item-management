@extends('layouts.auth')

@section('title_auth', 'Login')

@section('content_auth')

    <section class="content">
        <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-12 col-md-7 text-center d-flex justify-content-center">
                            <img src="{{ asset('assets/img/panca-mahottama.png') }}" width="100"
                                class="img-fluid d-block d-md-none" alt="Sample image">
                            <img src="{{ asset('assets/img/panca-mahottama.png') }}" width="90%"
                                class="img-fluid d-none d-md-block" alt="Sample image">
                        </div>
                        <div class="col-12 col-md-5 d-flex align-items-center justify-content-center ">
                            <form class="login-form w-100" method="POST" action="{{ route('do-login') }}">
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
                                <h3>Login</h3>

                                <div class="mb-3">
                                    <label class="form-label">Username / Email</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="text" name="login" value="{{ old('login') }}"
                                            class="form-control" placeholder="Masukan username/email" required>
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-user-circle text-muted"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="password" name="password" class="form-control"
                                            placeholder="•••••••••••" required>
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

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
