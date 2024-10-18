@extends('panel.layouts.master')

@section('title', 'User Reward')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title m-0">User Reward</h4>
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
                                <th>Reedem ID</th>
                                <th>Customer</th>
                                <th>Item</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $key => $item)
                            <tr>
                                <td scope="row">{{ $data->firstItem() + $key }}</td>
                                <td>{{ $item->reedem_id }}</td>
                                <td>{{ $item->user->name ?? '-' }}</td>
                                <td>{{ $item->reward->name ?? '-' }}</td>
                                <td>{{ $item->user->address ?? '-' }}</td>
                                <td>{{ $item->user->phone ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($item->status == 'not-used')
                                    <span class="badge bg-secondary"><i class="las la-ban align-middle me-1"></i>Not
                                        Used</span>
                                    @elseif ($item->status == 'used')
                                    <span class="badge bg-success"><i
                                            class="las la-check align-middle me-1"></i>Used</span>
                                    @elseif ($item->status == 'processing')
                                    <span class="badge bg-warning"><i
                                            class="las la-clock align-middle me-1"></i>Processing</span>
                                    @elseif ($item->status == 'delivered')
                                    <span class="badge bg-info"><i
                                            class="las la-truck-pickup align-middle me-1"></i>Delivered</span>
                                    @elseif($item->status == 'completed')
                                    <span class="badge bg-success"><i
                                            class="las la-check align-middle me-1"></i>Completed</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($item->status == 'processing')
                                    <div class="dropdown">
                                        <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ri-more-2-fill"></i>
                                        </a>

                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <li><button type="button" class="btn-delivered dropdown-item text-info"
                                                    data-id={{ $item->id }}><i
                                                        class="las la-truck-pickup align-middle me-1"></i>Delivered</button>
                                            </li>
                                        </ul>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">No Data</td>
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

@push('script')
<script>
    $(document).ready(function() {
        $('.btn-delivered').on('click', function() {
            swal.fire({
                title: 'Are you sure to delivered this reward?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delivered it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const id = $(this).data('id');

                    let url = "{{ route('user-reward.delivered', ':id') }}";
                    url = url.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.success) {
                                swal.fire({
                                    title: 'Success',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                })
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else {
                                swal.fire({
                                    title: 'Error',
                                    text: response.message,
                                    icon: 'error',
                                })
                            }
                        }
                    })
                }
            })
        })
    });
</script>
@endpush