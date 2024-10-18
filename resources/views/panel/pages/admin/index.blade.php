@extends('panel.layouts.master')

@section('title', 'Admin & Driver')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title m-0">Admin & Driver</h4>
                    </div>
                    <a href="{{ route('admin.create') }}" class="btn btn-primary btn-label waves-effect waves-light"><i
                            class="ri-add-line label-icon align-middle fs-16 me-2"></i>Add New Account</a>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
                    <i class="ri-check-double-line me-3 align-middle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $key => $item)
                            <tr>
                                <td scope="row">{{ $data->firstItem() + $key }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img class="rounded-circle avatar-xxs" width="40"
                                            src="{{ !empty($item->photo) ? url('/storage/account/' . $item->photo) : "
                                            https://ui-avatars.com/api/?name=" . $item->name }}" /><span>{{
                                            $item->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $item->email ?? '-' }}</td>
                                <td class="text-capitalize">{{ $item->level ?? '-' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.edit', $item->id) }}"
                                            class="btn btn-sm btn-icon waves-effect waves-light btn-warning"
                                            data-bs-toggle="tooltip" data-bs-title="Edit"><i
                                                class="ri-edit-line"></i></a>
                                        <button type="button"
                                            class="btn btn-sm btn-icon waves-effect waves-light btn-danger"
                                            data-bs-toggle="tooltip" data-bs-title="Delete"
                                            onclick="hapus('Account', '{{ $item->name }}', '{{ route('admin.destroy', $item->id) }}', '{{ csrf_token() }}')"><i
                                                class="ri-delete-bin-line"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">No Data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div>
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection