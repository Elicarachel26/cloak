@extends('panel.layouts.auth-master')

@section('title', 'Login')

@section('content')
<div class="auth-page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card mt-4">

                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">Welcome Back !</h5>
                        </div>
                        <div class="p-2 mt-4">

                            @if (session('success'))
                            <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
                                <i class="ri-check-double-line me-3 align-middle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            @if (session('error'))
                            <div class="alert alert-danger alert-dismissible alert-solid alert-label-icon fade show"
                                role="alert">
                                <i class="ri-error-warning-line label-icon"></i>{{ session('error') }}
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            @endif


                            <form action="{{ route('login.auth') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="email"
                                        class="form-label @error('email') is-invalid @enderror">Email <sup class="text-danger">*</sup></label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter Email"
                                        name="email" required>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="password-input">Password <sup class="text-danger">*</sup></label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input type="password"
                                            class="form-control pe-5 password-input @error('password') is-invalid @enderror"
                                            placeholder="Enter Password" id="password-input" name="password" required>
                                        <button
                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                            type="button" id="password-addon"><i
                                                class="ri-eye-fill align-middle"></i></button>
                                    </div>

                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('forgot-password.index') }}" class="text-primary">Forgot
                                            password?</a>
                                    </div>
                                </div>
                                {{-- <div class="mb-3">
                                    <label class="form-label">Captcha</label>
                                    <div class="mb-2">
                                        <div class="mb-1">
                                            <img src="{{ captcha_src('flat') }}" id="captcha-quest">
                                        </div>
                                        <a href="javascript:void(0)" onclick="reloadCaptcha()">refresh?</a>
                                    </div>
                                    <input id="captcha" type="text"
                                        class="form-control @error('captcha') is-invalid @enderror"
                                        placeholder="Enter Captcha" name="captcha" required>
                                    @error('captcha')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div> --}}

                                <div class="mt-4 mb-2 d-grid gap-2">
                                    <button class="btn btn-success w-100" type="submit">Login</button>
                                    <a href="{{ route('google.redirect') }}" class="btn btn-outline-danger"><i class="ri-google-fill align-middle me-2"></i> Login with Google </a>
                                </div>

                                <div class="text-center">
                                    <span>Don't have an account? <a
                                            href="{{ route('register.index') }}">Register</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
    </div>
    <!-- end row -->
</div>
@endsection