@extends('panel.layouts.master')

@section('title', 'Orders')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title m-0">Orders</h4>
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
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th class="text-center">Payment Method</th>
                                <th class="text-center">Shipping</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $key => $item)
                            <tr>
                                <td scope="row">{{ $data->firstItem() + $key }}</td>
                                <td>{{ $item->invoice }}</td>
                                <td>{{ $item->user->name ?? '-' }}</td>
                                <td>{{ $item->address ?? '-' }}</td>
                                <td>{{ $item->phone ?? '-' }}</td>
                                <td class="text-center">{{ $item->payment == 'cash' ? 'Cash' : 'Bank Transfer' }}</td>
                                <td class="text-center">{{ $item->shipping == 'dropoff' ? 'Drop-off' : 'Pick-up' }}</td>
                                <td class="text-center">
                                    @if ($item->status == 'not paid')
                                    <span class="badge bg-danger"><i class="las la-dollar-sign me-1"></i>Not Paid</span>
                                    @elseif ($item->status == 'waiting delivery')
                                    <span class="badge bg-warning"><i class="las la-pallet me-1"></i>Waiting
                                        Delivery</span>
                                    @elseif ($item->status == 'processing')
                                    <span class="badge bg-warning"><i class="las la-clock me-1"></i>Processing</span>
                                    @elseif ($item->status == 'picked up')
                                    <span class="badge bg-warning"><i class="las la-truck-pickup me-1"></i>Picked Up</span>
                                    @elseif ($item->status == 'delivered')
                                    <span class="badge bg-info"><i class="las la-truck-pickup me-1"></i>Delivered</span>
                                    @elseif ($item->status == 'cancelled')
                                    <span class="badge bg-danger"><i class="las la-ban me-1"></i>Cancelled</span>
                                    @elseif($item->status == 'completed')
                                    <span class="badge bg-success"><i class="las la-check me-1"></i>Completed</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ri-more-2-fill"></i>
                                        </a>

                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <li><button type="button" class="dropdown-item text-info"
                                                    data-bs-target="#detail-{{ $item->id }}" data-bs-toggle="modal"><i
                                                        class="las la-search align-middle me-1"></i>Detail</button></li>

                                            @if ($item->status !== 'completed' && $item->status !== 'cancelled')
                                            @if ($item->shipping == 'pickup' && is_null($item->driver_id))
                                            <li><button type="button" class="dropdown-item text-dark"
                                                    data-bs-target="#driver-{{ $item->id }}" data-bs-toggle="modal"
                                                    data-id={{ $item->id }}><i
                                                        class="las la-user-circle align-middle me-1"></i>Set
                                                    Driver</button></li>
                                            @endif

                                            <li><button type="button" class="btn-cancel dropdown-item text-danger"
                                                    data-id={{ $item->id }}><i
                                                        class="las la-times-circle align-middle me-1"></i>Canceled</button>
                                            </li>
                                            <li><button type="button" class="btn-complete dropdown-item text-success"
                                                    data-id={{ $item->id }}><i
                                                        class="las la-check-double align-middle me-1"></i>Complete</button>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- Detail Modals -->
                            <div id="detail-{{ $item->id }}" class="modal fade" tabindex="-1"
                                aria-labelledby="myModalLabel-{{ $item->id }}" aria-hidden="true"
                                style="display: none;">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel-{{ $item->id }}">#{{ $item->invoice
                                                }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"> </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="list-unstyled">
                                                <li><strong>Total Weight</strong>: {{ $item->total_weight ?? '-' }} kg
                                                </li>
                                                @if ($item->shipping == 'pickup')
                                                <li><strong>Cost Shipping</strong>: Rp {{
                                                    number_format($item->total_price, 0, ',', '.') }}</li>
                                                @endif
                                                @if (!empty($item->proof_of_payment))
                                                <li><strong>Proof of Payment</strong>: <a
                                                        href="{{ url('/storage/proof_of_payment/' . $item->proof_of_payment) }}"></a>
                                                </li>
                                                @endif
                                                @if ($item->shipping == 'pickup')
                                                <li><strong>Driver</strong>: {{ $item->driver_id ? $item->driver->name :
                                                    '-' }}</li>
                                                @endif
                                            </ul>

                                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                                @foreach ($item->detail as $detail)
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <img src="{{ !empty($detail->picture) ? url('/storage/order/' . $detail->picture) : asset('assets/images/no-image.jpg') }}"
                                                            alt="{{ $detail->product->name }}" width="150">
                                                    </li>
                                                    <li>
                                                        <strong class="mt-3">{{ $detail->product->name }}</strong>
                                                        <small class="text-muted d-block">{{ $detail->weight }}
                                                            kg</small>
                                                    </li>
                                                </ul>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Set Driver Modal -->
                            <div id="driver-{{ $item->id }}" class="modal fade" tabindex="-1"
                                aria-labelledby="driverLabel-{{ $item->id }}" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg">
                                    <form action="{{ route('order.driver', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="driverLabel-{{ $item->id }}">Set Driver</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"> </button>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    <select class="form-select" name="driver_id" required>
                                                        <option value="">Select Driver</option>
                                                        @foreach ($drivers as $driver)
                                                        <option value="{{ $driver->id }}" {{ $driver->id ==
                                                            $item->driver_id ? 'selected' : '' }}>
                                                            {{ $driver->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Set Driver</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
        $('.btn-cancel').on('click', function() {
            swal.fire({
                title: 'Are you sure to cancel this order?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const id = $(this).data('id');
                    let url = "{{ route('order.cancel', ':id') }}";
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

        $('.btn-complete').on('click', function() {
            swal.fire({
                title: 'Are you sure to complete this order?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, complete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const id = $(this).data('id');
                    let url = "{{ route('order.complete', ':id') }}";
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