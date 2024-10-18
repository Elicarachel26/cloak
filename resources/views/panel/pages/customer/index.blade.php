@extends('panel.layouts.master')

@section('title', 'Customers')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title m-0">Customers</h4>
                    </div>
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
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th class="text-center">Point</th>
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
                                <td>{{ $item->phone ?? '-' }}</td>
                                <td>{{ $item->address ?? '-' }}</td>
                                <td class="text-center">{{ $item->point }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('customer.edit', $item->id) }}"
                                            class="btn btn-sm btn-icon waves-effect waves-light btn-warning"
                                            data-bs-toggle="tooltip" data-bs-title="Edit"><i
                                                class="ri-edit-line"></i></a>
                                        <button type="button"
                                            class="btn btn-sm btn-icon waves-effect waves-light btn-danger"
                                            data-bs-toggle="tooltip" data-bs-title="Delete"
                                            onclick="hapus('Customer', '{{ $item->name }}', '{{ route('customer.destroy', $item->id) }}', '{{ csrf_token() }}')"><i
                                                class="ri-delete-bin-line"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">No Data</td>
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