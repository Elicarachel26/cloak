@extends('client.layouts.master')

@section('title', 'Account')

@section('content')
<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="content col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <span class="h4">Change your password</span>
                    </div>
                    <div class="card-body">
                        <form class="row" method="POST" action="{{ route('client.account.change-password') }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Old password <sup
                                                class="text-danger">*</sup></label>
                                        <input class="form-control @error('password') is-invalid @enderror"
                                            type="password" name="password" required>

                                        @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">New password <sup
                                                class="text-danger">*</sup></label>
                                        <input class="form-control @error('newpassword') is-invalid @enderror"
                                            type="password" name="newpassword" required>

                                        @error('newpassword')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Confirm password <sup
                                                class="text-danger">*</sup></label>
                                        <input class="form-control @error('confirmpassword') is-invalid @enderror"
                                            type="password" name="confirmpassword" required>

                                        @error('confirmpassword')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 d-flex justify-content-end">
                                <button type="submit" class="btn">Update password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection