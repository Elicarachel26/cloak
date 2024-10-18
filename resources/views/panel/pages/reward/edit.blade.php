@extends('panel.layouts.master')

@section('title', 'Edit Reward')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-xl-6 mb-3">
        <a href="{{ route('reward.index') }}" class="btn btn-sm btn-soft-secondary waves-light"><i
                class="ri-arrow-left-s-line align-middle"></i> Back</a>
    </div>
</div>

<form action="{{ route('reward.update', $data->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row justify-content-center">
        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Photo Reward</label>

                            @if (!empty($data->picture))
                            <div class="mb-3">
                                <img class="img-thumbnail" alt="{{ $data->name }}" width="150"
                                    src="{{ url('/storage/reward/' . $data->picture) }}">
                            </div>
                            @endif

                            <input type="file" class="form-control @error('picture') is-invalid @enderror"
                                name="picture" accept="image/png, image/jpg, image/jpeg">
                            <small class="text-muted">Only png, jpg and jpeg files are allowed and max 2MB</small>

                            @error('picture')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Reward Name<sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                placeholder="Reward Name" value="{{ old('name', $data->name) }}" required>

                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="description"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Description" rows="4"
                                style="resize: none">{{ old('description', $data->description) }}</textarea>

                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Reward Type<sup class="text-danger">*</sup></label>
                            <select class="form-select @error('type') is-invalid @enderror" name="type" required>
                                <option value="" disabled selected>Select Reward Type</option>
                                <option value="free-shipping" {{ old('type', $data->type)=='free-shipping' ? 'selected'
                                    : '' }}>Free
                                    Shipping Voucher</option>
                                <option value="item" {{ old('type', $data->type)=='item' ? 'selected' : '' }}>Item
                                </option>
                            </select>

                            @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Point<sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control @error('point') is-invalid @enderror" name="point"
                                placeholder="Point" value="{{ old('point', $data->point) }}" required>

                            @error('point')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Status<sup class="text-danger">*</sup></label>
                            <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                <option value="" disabled selected>-- Select Status --</option>
                                <option value="1" @selected(old('status')==1)>Active</option>
                                <option value="0" @selected(old('status')==0)>Inactive</option>
                            </select>

                            @error('status')
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