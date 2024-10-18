@extends('client.layouts.master')

@section('title', 'Reedem Point')

@section('content')
<section id="page-title">
    <div class="container">
        <div class="page-title">
            <h1>Reedem Point</h1>
        </div>
    </div>
</section>

@if (session('success'))
<div class="container">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

<section id="shop-wishlist">
    <div class="container">
        <div class="page-title">
            <h3 class="section-title m-0">Hi, {{ auth()->user()->name }}. You have <span
                    class="{{ auth()->user()->point <= 0 ? 'text-danger' : 'text-success' }}">{{ auth()->user()->point
                    }}</span> point
            </h3>
            <p class="m-0">You can use your point to redeem your item</p>
        </div>

        <div class="my-5">
            <h3>List Reward</h3>

            <div class="shop">
                <div class="grid-layout grid-3-columns" data-item="grid-item">
                    @forelse ($rewards as $item)
                    <div class="grid-item">
                        <div class="product">
                            <div class="product-image">
                                <img alt="{{ $item->name }}"
                                    src="{{ !empty($item->picture) ? url('/storage/reward/' . $item->picture) : asset('assets/images/no-image.jpg') }}">
                                <div class="product-overlay">
                                    <a href="javascript:void(0)" class="claim-reward" data-id="{{ $item->id }}"
                                        data-point="{{ $item->point }}">Claim Reward</a>
                                </div>
                            </div>
                            <div class="product-description">
                                <div class="product-title">
                                    <h3><a href="javascript:void(0)">{{ $item->name }}</a></h3>
                                    <h6>{{ $item->point }} Point</h6>
                                    <p>{{ $item->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="grid-item text-muted">No Reward Available</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <div class="container">
        <h5 class="section-title">History Reedem</h5>
        <div class="shop-cart">
            <div class="table table-sm table-striped table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Reedem ID</th>
                            <th>Item</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $key => $item)
                        <tr>
                            <td scope="row">{{ $data->firstItem() + $key }}</td>
                            <td>{{ date('Y/m/d', strtotime($item->created_at)) }}</td>
                            <td>{{ $item->reedem_id }}</td>
                            <td>{{ $item->reward->name }}</td>
                            <td>
                                @if ($item->status == 'not-used')
                                <span class="badge bg-light"><i class="fas fa-ban me-2"></i>Not Used</span>
                                @elseif ($item->status == 'used')
                                <span class="badge bg-success"><i class="fas fa-check me-2"></i>Used</span>
                                @elseif ($item->status == 'processing')
                                <span class="badge bg-warning"><i class="fas fa-clock me-2"></i>Processing</span>
                                @elseif ($item->status == 'delivered')
                                <span class="badge bg-info"><i class="fas fa-truck-pickup me-2"></i>Delivered</span>
                                @elseif($item->status == 'completed')
                                <span class="badge bg-success"><i class="fas fa-check me-2"></i>Completed</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-inline-grid">
                                    @if ($item->status == 'delivered')
                                    <button type="button" class="btn-complete btn btn-success btn-xs" data-id="{{ $item->id }}"><i class="fas fa-check align-middle me-2"></i>Completed</button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="6" class="text-center">No Data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            {{ $data->links() }}
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('.claim-reward').click(function() {
            const id = $(this).data('id')
            const point = $(this).data('point')

            swal.fire({
                title: 'Are you sure to claim it for ' + point + ' point?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, claim it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('client.reedem-point.store') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(data) {
                            if (data.success) {
                                toastify(data.message, 'success');
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                toastify(data.message, 'error');
                            }
                        },
                    });
                }
            })
        })

        $('.btn-complete').click(function() {
            const id = $(this).data('id')

            swal.fire({
                title: 'Are you sure you have received this item?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, complete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('client.reedem-point.complete') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(data) {
                            if (data.success) {
                                toastify(data.message, 'success');
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                toastify(data.message, 'error');
                            }
                        },
                    });
                }
            })
        })
    })
</script>
@endpush