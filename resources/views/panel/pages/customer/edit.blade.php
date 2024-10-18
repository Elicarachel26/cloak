@extends('panel.layouts.master')

@section('title', 'Edit Customer Account')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('customer.index') }}" class="btn btn-sm btn-soft-secondary waves-light"><i
                class="ri-arrow-left-s-line align-middle"></i> Back</a>
    </div>
</div>

<form action="{{ route('customer.update', $data->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-4">
                    <label class="form-label d-block text-center">Photo Profile</label>
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                            <img src="{{ !empty($data->photo) ? url('/storage/account/' . $data->photo) : "
                                https://ui-avatars.com/api/?name=" . $data->name }}"
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
                                placeholder="Full Name" value="{{ old('name', $data->name) }}" required>

                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address <sup class="text-danger">*</sup></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                placeholder="Email Address" value="{{ old('email', $data->email) }}" required>

                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone"
                                placeholder="Phone Number" value="{{ old('phone', $data->phone) }}">

                            @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" name="address"
                                rows="4" style="resize: none">{{ old('address', $data->address) }}</textarea>

                            @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Point</label>
                            <input type="number" class="form-control @error('point') is-invalid @enderror" name="point"
                                placeholder="Point" value="{{ old('point', $data->point) }}">

                            @error('point')
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
</form>
</div>

@endsection

@push('script')
<script src="{{ asset('assets/js/pages/profile-setting.init.js') }}"></script>
@endpush