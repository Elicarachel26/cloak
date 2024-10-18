@extends('client.layouts.master')

@section('title', 'Account')

@section('content')
<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="content col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Account Details</h5>
                    </div>
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form class="row g-3" method="POST" action="{{ route('client.account.index') }}">
                            @csrf
                            @method('PUT')

                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name <sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', auth()->user()->name) }}" required>

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address <sup
                                        class="text-danger">*</sup></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email', auth()->user()->email) }}" required>

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                    name="phone" value="{{ old('phone', auth()->user()->phone) }}">

                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            @csrf

                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                                    name="address" rows="3"
                                    style="resize: none">{{ old('address', auth()->user()->address) }}</textarea>

                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            
                            <div class="col-12">
                                <label for="kecamatan" class="form-label">Pilih Kecamatan & Kelurahan</label>
                                <select id="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror" name="kecamatan" required>
                                    <!-- <option value="">- Select -</option>
                                    <option value="cigugurgirang" {{ old('kelurahan', auth()->user()->kelurahan) == 'cigugurgirang' ? 'selected' : '' }}>Cigugurgirang</option>
                                    <option value="cihanjuang" {{ old('kelurahan', auth()->user()->kelurahan) == 'cihanjuang' ? 'selected' : '' }}>
                                        Cihanjuang</option>
                                    <option value="cihanjuangrahayu" {{ old('kelurahan', auth()->user()->kelurahan) == 'cihanjuangrahayu' ? 'selected' : '' }}>Cihanjuangrahayu</option>
                                    <option value="cihideung" {{ old('kelurahan', auth()->user()->kelurahan) == 'cihideung' ? 'selected' : '' }}>
                                        Cihideung</option>
                                </select>
                                @error('kelurahan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> -->
                            <option value="">- Select -</option>
                            <option value="parongpong-cigugurgirang" {{ old('kecamatan', auth()->user()->kecamatan) == 'parongpong-cigugurgirang' ? 'selected' : '' }}>
                                Parongpong-Cigugurgirang</option>
                            <option value="parongpong-cihanjuang" {{ old('kecamatan', auth()->user()->kecamatan) == 'parongpong-cihanjuang' ? 'selected' : '' }}>
                                Parongpong-Cihanjuang</option>
                            <option value="parongpong-cihanjuangrahayu" {{ old('kecamatan', auth()->user()->kecamatan) == 'parongpong-cihanjuangrahayu' ? 'selected' : '' }}>Parongpong-Cihanjuangrahayu</option>
                            <option value="parongpong-cihideung" {{ old('kecamatan', auth()->user()->kecamatan) == 'parongpong-cihideung' ? 'selected' : '' }}>
                                Parongpong-Cihideung</option>
                            </select>
                            @error('kelurahan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>

                            <!-- <div class="col-12">
                                <label for="kelurahan" class="form-label">Pilih Kelurahan</label>
                                <select id="kelurahan" class="form-control @error('kelurahan') is-invalid @enderror" name="kelurahan" required>
                                    <option value="">- Select -</option>
                                    <option value="cigugurgirang" {{ old('kelurahan', auth()->user()->kelurahan) == 'cigugurgirang' ? 'selected' : '' }}>Cigugurgirang</option>
                                    <option value="cihanjuang" {{ old('kelurahan', auth()->user()->kelurahan) == 'cihanjuang' ? 'selected' : '' }}>
                                        Cihanjuang</option>
                                    <option value="cihanjuangrahayu" {{ old('kelurahan', auth()->user()->kelurahan) == 'cihanjuangrahayu' ? 'selected' : '' }}>Cihanjuangrahayu</option>
                                    <option value="cihideung" {{ old('kelurahan', auth()->user()->kelurahan) == 'cihideung' ? 'selected' : '' }}>
                                        Cihideung</option>
                                </select>
                                @error('kelurahan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> -->

                            <!--@csrf

                           
                             <div class="col-12 mt-3">
                                <label for="province" class="form-label">Provinsi</label>
                                <select id="province" class="form-select" name="province">
                                    <option value="">Select Provinsi</option>
                                </select>
                            </div>

                            <div class="col-12 mt-3">
                                <label for="regency" class="form-label">Kab/Kota</label>
                                <select id="regency" class="form-select" name="regency">
                                    <option value="">Select Kab/Kota</option>
                                </select>
                            </div>

                            <div class="col-12 mt-3">
                                <label for="district" class="form-label">Kecamatan</label>
                                <select id="district" class="form-select" name="district">
                                    <option value="">Select Kecamatan</option>
                                </select>
                            </div>

                            
                            <div class="col-12 mt-3">
                                <label for="village" class="form-label">Kelurahan/Desa</label>
                                <select id="village" class="form-select" name="village">
                                    <option value="">Select Kelurahan/Desa</option>
                                </select>
                            </div> -->

                            <div class="col-12 d-flex justify-content-end">
                                <a href="{{ route('client.account.change-password') }}" class="btn btn-danger">Change
                                    Password</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fetch provinces
        fetch('/provinces')
            .then(response => response.json())
            .then(data => {
                const provinceSelect = document.getElementById('province');
                data.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.id;
                    option.textContent = province.name;
                    provinceSelect.appendChild(option);
                });
            });

        // Fetch regencies when a province is selected
        document.getElementById('province').addEventListener('change', function () {
            const provinceId = this.value;
            if (provinceId) {
                fetch(`/regencies/${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        const regencySelect = document.getElementById('regency');
                        regencySelect.innerHTML = '<option value="">Select Kab/Kota</option>';
                        data.forEach(regency => {
                            const option = document.createElement('option');
                            option.value = regency.id;
                            option.textContent = regency.name;
                            regencySelect.appendChild(option);
                        });
                    });
            } else {
                document.getElementById('regency').innerHTML = '<option value="">Select Kab/Kota</option>';
                document.getElementById('district').innerHTML = '<option value="">Select Kecamatan</option>';
                document.getElementById('village').innerHTML = '<option value="">Select Kelurahan/Desa</option>';
            }
        });

        // Fetch districts when a regency is selected
        document.getElementById('regency').addEventListener('change', function () {
            const regencyId = this.value;
            if (regencyId) {
                fetch(`/districts/${regencyId}`)
                    .then(response => response.json())
                    .then(data => {
                        const districtSelect = document.getElementById('district');
                        districtSelect.innerHTML = '<option value="">Select Kecamatan</option>';
                        data.forEach(district => {
                            const option = document.createElement('option');
                            option.value = district.id;
                            option.textContent = district.name;
                            districtSelect.appendChild(option);
                        });
                    });
            } else {
                document.getElementById('district').innerHTML = '<option value="">Select Kecamatan</option>';
                document.getElementById('village').innerHTML = '<option value="">Select Kelurahan/Desa</option>';
            }
        });

        // Fetch villages when a district is selected
        document.getElementById('district').addEventListener('change', function () {
            const districtId = this.value;
            if (districtId) {
                fetch(`/villages/${districtId}`)
                    .then(response => response.json())
                    .then(data => {
                        const villageSelect = document.getElementById('village');
                        villageSelect.innerHTML = '<option value="">Select Kelurahan/Desa</option>';
                        data.forEach(village => {
                            const option = document.createElement('option');
                            option.value = village.id;
                            option.textContent = village.name;
                            villageSelect.appendChild(option);
                        });
                    });
            } else {
                document.getElementById('village').innerHTML = '<option value="">Select Kelurahan/Desa</option>';
            }
        });
    });
</script>
@endsection