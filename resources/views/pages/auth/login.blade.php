@extends('layouts.auth')

@section('title_auth', 'Login')

@section('content_auth')

    <section class="content">
        {{-- <div
            style="
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.4); /* Ubah nilai alpha (0.5) untuk mengatur kegelapan */
    ">
        </div> --}}
        <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2">
                            <div class="text-center">
                                <img src="{{ asset('assets/img/panca-mahottama.png') }}" width="130" class="img-fluid mb-3"
                                    alt="Sample image">
                            </div>
                            <form class="login-form w-100" method="POST" action="{{ route('do-login') }}">
                                @csrf

                                <h3 class="text-center mb-0">SI-ASET</h3>
                                <span class="d-block text-center mb-1">SISTEM INFORMASI ASET</span>
                                <span class="d-block text-muted text-center mb-2 text-uppercase">Perumda Air Minum Panca
                                    Mahottama <br> Kab.
                                    Klungkung</span>
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

                                @if ($errors->has('failed'))
                                    <div class="alert alert-warning alert-icon-start alert-dismissible fade show">
                                        <span class="alert-icon bg-warning text-white">
                                            <i class="ph-warning-circle"></i>
                                        </span>
                                        <span class="fw-semibold">Warning!</span> {{ $errors->first('failed') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

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
    </section>
@endsection
