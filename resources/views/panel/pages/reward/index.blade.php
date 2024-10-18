@extends('panel.layouts.master')

@section('title', 'Rewards')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title m-0">Rewards</h4>
                    </div>
                    <a href="{{ route('reward.create') }}" class="btn btn-primary btn-label waves-effect waves-light"><i
                            class="ri-add-line label-icon align-middle fs-16 me-2"></i>Add New Reward</a>
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
                                <th>Picture</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Point</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $key => $item)
                            <tr>
                                <td scope="row">{{ $data->firstItem() + $key }}</td>
                                <td>
                                    <img class="img-thumbnail" alt="{{ $item->name }}" width="100"
                                        src="{{ !empty($item->picture) ? url('/storage/reward/' . $item->picture) : asset('assets/images/no-image.jpg') }}">
                                </td>
                                <td>{{ $item->name ?? '-' }}</td>
                                <td>{{ $item->description ?? '-' }}</td>
                                <td class="text-center">{{ $item->type == 'item' ? 'Item' : 'Free Shipping Voucher' }}
                                </td>
                                <td class="text-center">{{ $item->point ?? '-' }}</td>
                                <td class="text-center">
                                    <div
                                        class="badge badge-soft-{{ $item->status ? 'success' : 'danger' }} text-uppercase">
                                        {{ $item->status ? 'Active' : 'Inactive' }}</div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('reward.edit', $item->id) }}"
                                            class="btn btn-sm btn-icon waves-effect waves-light btn-warning"
                                            data-bs-toggle="tooltip" data-bs-title="Edit"><i
                                                class="ri-edit-line"></i></a>
                                        <button type="button"
                                            class="btn btn-sm btn-icon waves-effect waves-light btn-danger"
                                            data-bs-toggle="tooltip" data-bs-title="Delete"
                                            onclick="hapus('Reward', '{{ $item->name }}', '{{ route('reward.destroy', $item->id) }}', '{{ csrf_token() }}')"><i
                                                class="ri-delete-bin-line"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">No Data</td>
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