@extends('panel.layouts.auth-master')

@section('title', 'Forgot Password')

@section('content')
<div class="auth-page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card mt-4">

                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">Forgot Password</h5>
                        </div>
                        <div class="p-2 mt-4">
                            @if (session('success'))
                            <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
                                <i class="ri-check-double-line me-3 align-middle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif


                            <form action="{{ route('forgot-password.auth') }}" method="POST">
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

                                <div class="mt-4 mb-2 d-grid gap-2">
                                    <button class="btn btn-success w-100" type="submit">Send Reset Password</button>
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