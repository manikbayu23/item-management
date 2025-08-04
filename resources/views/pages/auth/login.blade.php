@extends('layouts.auth')

@section('title_auth', 'Login')

@section('content_auth')
    <div class="d-flex flex-row justify-content-center align-items-center">
        <div class="col-12 col-md-6 vh-100 d-none d-md-block" style="background-color: #375489;">
            <div class="container p-5 d-flex justify-content-center align-items-center h-100">
                <img src="{{ asset('assets/img/comp1.png') }}" class="img-fluid" alt="logo computer">
            </div>
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-center align-items-center bg-white vh-100">
            <div class="card shadow-none" style="width: 30rem;">
                <div class="card-body">
                    @if ($errors->has('failed'))
                        <div class="alert alert-warning alert-icon-start alert-dismissible fade show">
                            <span class="alert-icon bg-warning text-white">
                                <i class="ph-warning-circle"></i>
                            </span>
                            <span class="fw-semibold">Warning!</span> {{ $errors->first('failed') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    <div class="mb-2">
                        <div class="text-center">
                            <img src="{{ asset('assets/img/panca-mahottama.png') }}" width="130" class="img-fluid mb-1"
                                alt="Sample image">
                        </div>
                        <form class="login-form w-100" method="POST" action="{{ route('do-login') }}">
                            @csrf

                            <h3 class="text-center mb-0">SI-ASET</h3>
                            <span class="d-block text-center mb-1">SISTEM INVENTARIS ASET</span>
                            <span class="d-block text-muted text-center mb-2 text-uppercase">Perumda Air Minum Panca
                                Mahottama <br> Kab.
                                Klungkung</span>
                            <div class="mb-3">
                                <label class="form-label">Username / Email</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="text" name="login" value="{{ old('login') }}" class="form-control"
                                        placeholder="Masukan username/email" required>
                                    <div class="form-control-feedback-icon">
                                        <i class="ph-user-circle text-muted"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="form-control-feedback form-control-feedback-start position-relative">
                                    <input type="password" name="password" class="form-control" id="passwordInput"
                                        placeholder="•••••••••••" required>

                                    <!-- Icon lock di sisi kiri -->
                                    <div class="form-control-feedback-icon start-0">
                                        <i class="ph-lock text-muted"></i>
                                    </div>

                                    <!-- Tombol lihat password di sisi kanan -->
                                    <button type="button"
                                        class="btn btn-sm position-absolute end-0 top-50 translate-middle-y me-2 border-0 bg-transparent"
                                        onclick="togglePasswordVisibility()">
                                        <i class="ph-eye text-muted" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>


                            <!-- Script toggle password -->
                            <script>
                                function togglePasswordVisibility() {
                                    const input = document.getElementById('passwordInput');
                                    const icon = document.getElementById('toggleIcon');
                                    if (input.type === 'password') {
                                        input.type = 'text';
                                        icon.classList.remove('ph-eye');
                                        icon.classList.add('ph-eye-slash');
                                    } else {
                                        input.type = 'password';
                                        icon.classList.remove('ph-eye-slash');
                                        icon.classList.add('ph-eye');
                                    }
                                }
                            </script>


                            <div class="text-center">
                                {{-- <a href="{{ route('forgot_password') }}">Forgot password?</a> --}}
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100">Sign in</button>
                            </div>

                        </form>
                    </div>
                    <div class="text-center text-body bg-white">
                        <a href="/" class="text-body" style="color: rgb(152, 152, 152) !important">&copy;
                            {{ Carbon\Carbon::now()->year }} -
                            Perumda Air Minum Panca Mahottama Kab. Klungkung</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
