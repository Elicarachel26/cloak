@extends('panel.layouts.auth-master')

@section('title', 'Reset Password')

@section('content')
<div class="auth-page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card mt-4">

                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">Reset Password</h5>
                        </div>
                        <div class="p-2 mt-4">
                            @if (session('success'))
                            <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
                                <i class="ri-check-double-line me-3 align-middle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
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

                            <form action="{{ route('reset-password.auth', $token) }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="password"
                                        class="form-label @error('password') is-invalid @enderror">Password <sup
                                            class="text-danger">*</sup></label>
                                    <input type="password" class="form-control" id="password"
                                        placeholder="Enter Password" name="password" required>

                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="confirm_password"
                                        class="form-label @error('confirm_password') is-invalid @enderror">Confirm
                                        Password <sup class="text-danger">*</sup></label>
                                    <input type="password" class="form-control" id="confirm_password"
                                        placeholder="Confirm Password" name="confirm_password" required>

                                    @error('confirm_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mt-4 mb-2 d-grid gap-2">
                                    <button class="btn btn-success w-100" type="submit">Reset Password</button>
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