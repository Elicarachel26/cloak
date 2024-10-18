@extends('panel.layouts.master')

@section('title', 'Add New Account')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('admin.index') }}" class="btn btn-sm btn-soft-secondary waves-light"><i
                class="ri-arrow-left-s-line align-middle"></i> Back</a>
    </div>
</div>

<form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-4">
                    <label class="form-label d-block text-center">Photo Profile</label>
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                            <img src="https://ui-avatars.com/api/?name=a"
                                class="rounded-circle avatar-xl img-thumbnail user-profile-image">
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input" type="file" class="profile-img-file-input"
                                    name="photo" accept="image/png, image/jpg, image/jpeg">
                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <small class="text-muted text-center">Only png, jpg and jpeg files are allowed and max 2MB</small>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name<sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                placeholder="Full Name" value="{{ old('name') }}" required>

                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address <sup class="text-danger">*</sup></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                placeholder="Email Address" value="{{ old('email') }}" required>

                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password<sup class="text-danger">*</sup></label>
                            <div class="position-relative auth-pass-inputgroup">
                                <input type="password"
                                    class="form-control pe-5 password-input @error('password') is-invalid @enderror"
                                    placeholder="Password" id="password-input" name="password" required>
                                <button
                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                    type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                            </div>

                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role<sup class="text-danger">*</sup></label>

                            <select class="form-select @error('level') is-invalid @enderror" name="level" required>
                                <option value="admin" {{ old('level')=='admin' ? 'selected' : '' }}>Admin</option>
                                <option value="driver" {{ old('level')=='driver' ? 'selected' : '' }}>Driver</option>
                            </select>

                            @error('level')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('script')
<script src="{{ asset('assets/js/pages/profile-setting.init.js') }}"></script>
@endpush