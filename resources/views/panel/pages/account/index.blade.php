@extends('panel.layouts.master')

@section('title', 'Profile')

@section('content')
<div class="row">
    <div class="col-xxl-3">
        <div class="card">
            <div class="card-body p-4">
                <div class="text-center">
                    <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                        <img src="{{ !empty(auth()->user()->photo) ? url('/storage/account/' . auth()->user()->photo) : "
                            https://ui-avatars.com/api/?name=" . auth()->user()->name }}"
                            class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                            alt="user-profile-image" />
                        <form action="{{ route('account.change-photo') }}" id="formChangePhoto">
                            @csrf

                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input" type="file" class="profile-img-file-input"
                                    name="photo" accept="image/png, image/jpg, image/jpeg" />
                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </form>
                    </div>
                    <h5 class="fs-16 mb-1">
                        {{ auth()->user()->name }}
                    </h5>
                    <p class="text-muted mb-0">
                        {{ Str::ucfirst(auth()->user()->level) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-9">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                            <i class="fas fa-home"></i>
                            Account Details
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                            <i class="far fa-user"></i>
                            Change Password
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content">
                    <div class="tab-pane active" id="personalDetails" role="tabpanel">

                        <div class="row" id="error-alert-account"></div>

                        <form action="{{ route('account.update') }}" method="POST" id="formAccount">
                            @csrf

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="example@mail.com" value="{{ auth()->user()->email }}"
                                            required />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Full Name" value="{{ auth()->user()->name }}" required />
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-primary">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="changePassword" role="tabpanel">

                        <div class="row" id="error-alert-password"></div>

                        <form action="{{ route('account.change-password') }}" method="POST" id="formChangePassword">
                            @csrf

                            <div class="row g-2" id="passwordInput">
                                <div class="col-lg-4">
                                    <div>
                                        <label for="password" class="form-label">Current Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Current Password" required />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <label for="newpassword" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="newpassword" name="newpassword"
                                            placeholder="New Password" required />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <label for="confirmpassword" class="form-label">Password Confirmation</label>
                                        <input type="password" class="form-control" id="confirmpassword"
                                            name="confirmpassword" placeholder="Password Confirmation" required />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success">
                                            Change Password
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('assets/js/pages/profile-setting.init.js') }}"></script>
<script>
    $('#profile-img-file-input').change(function() {
        const url = $('#formChangePhoto').attr('action');
        const formData = new FormData();
        const _token = "{{ csrf_token() }}";
        formData.append('photo', $('#profile-img-file-input')[0].files[0]);

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': _token
            },
            success: function(response) {
                if (response.status) {
                    swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    })

                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                    })
                }
            },
            error: function(error) {
                console.log(error);

                swal.fire({
                    title: 'Error',
                    text: error,
                    icon: 'error',
                })
            }
        })
    })

    $('#formAccount').submit(function(e) {
        e.preventDefault();

        const url = $(this).attr('action');
        const formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status) {
                    swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    })

                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    $('#error-alert-account').html('<div class="col-12"><div class="alert alert-danger alert-border-left alert-dismissible fade show" role="alert"><i class="ri-error-warning-line me-3 align-middle"></i>' + response.message + '<button type="button" class="btn-close" data-bs-dismiss="alert"aria-label="Close"></button></div></div>')

                    swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                    })
                }
            },
            error: function(error) {
                swal.fire({
                    title: 'Error',
                    text: error,
                    icon: 'error',
                })
            }
        })
    })

    $('#formChangePassword').submit(function(e) {
        e.preventDefault();

        const url = $(this).attr('action');
        const formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status) {
                    swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    })

                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    $('#error-alert-password').html('<div class="col-12"><div class="alert alert-danger alert-border-left alert-dismissible fade show" role="alert"><i class="ri-error-warning-line me-3 align-middle"></i>' + response.message + '<button type="button" class="btn-close" data-bs-dismiss="alert"aria-label="Close"></button></div></div>')

                    swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                    })

                    $('#passwordInput input').val('');
                }
            },
            error: function(error) {
                swal.fire({
                    title: 'Error',
                    text: error,
                    icon: 'error',
                })
            }
        })
    })
</script>
@endpush