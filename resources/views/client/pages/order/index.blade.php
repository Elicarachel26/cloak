@extends('client.layouts.master')

@section('title', 'History Order')

@section('content')
<section id="page-title">
    <div class="container">
        <div class="page-title">
            <h1>History Order</h1>
            <a href="{{ route('client.home.index') }}" class="button-link">Back to Home Page</a>
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
        <div class="shop-cart">
            <div class="table table-sm table-striped table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th class="text-center">Total Weight</th>
                            <th>Shipping Method</th>
                            <th class="cart-product-price">Shipping Cost</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $key => $item)
                        <tr>
                            <td scope="row">{{ $data->firstItem() + $key }}</td>
                            <td>{{ date('Y/m/d', strtotime($item->created_at)) }}</td>
                            <td>{{ $item->invoice }}</td>
                            <td class="text-center">{{ $item->total_weight }} kg</td>
                            <td>{{ $item->shipping == 'dropoff' ? 'Drop-off' : 'Pick-up' }}</td>
                            <td class="cart-product-price">
                                <span class="amount">Rp {{ number_format($item->total_price) }}</span>
                            </td>
                            <td>
                                @if ($item->status == 'not paid')
                                <span class="badge bg-danger"><i class="fas fa-dollar-sign me-2"></i>Not Paid</span>
                                @elseif ($item->status == 'waiting delivery')
                                <span class="badge bg-warning"><i class="fas fa-pallet me-2"></i>Waiting Delivery</span>
                                @elseif ($item->status == 'processing')
                                <span class="badge bg-warning"><i class="fas fa-clock me-2"></i>Processing</span>
                                @elseif ($item->status == 'picked up')
                                <span class="badge bg-warning"><i class="fas fa-truck-pickup me-2"></i>Picked Up</span>
                                @elseif ($item->status == 'delivered')
                                <span class="badge bg-info"><i class="fas fa-truck-pickup me-2"></i>Delivered</span>
                                @elseif ($item->status == 'cancelled')
                                <span class="badge bg-danger"><i class="fas fa-ban me-2"></i>Cancelled</span>
                                @elseif($item->status == 'completed')
                                <span class="badge bg-success"><i class="fas fa-check me-2"></i>Completed</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-inline-grid">
                                    <a class="btn btn-xs btn-info" data-bs-target="#detail-{{ $item->id }}"
                                        data-bs-toggle="modal" href="#"><i class="fas fa-search me-2"></i> Detail</a>

                                    @if ($item->status == 'not paid')
                                    <a class="btn btn-xs btn-light" data-bs-target="#upload-{{ $item->id }}"
                                        data-bs-toggle="modal" href="#"><i class="fas fa-upload me-2"></i> Upload Proof
                                        of
                                        Payment</a>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="8" class="text-center">No Data</td>
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

@foreach ($data as $item)

<div class="modal fade" id="upload-{{ $item->id }}" tabindex="-1" role="modal"
    aria-labelledby="modal-label-upload-{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form action="{{ route('client.order.proof-payment', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-label-upload-{{ $item->id }}" class="modal-title">Upload Proof of Payment</h4>
                    <button aria-hidden="true" data-bs-dismiss="modal" class="btn-close" type="button">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="proof_of_payment">Upload Proof of Payment</label>
                        <input type="file" name="proof_of_payment" class="form-control" id="proof_of_payment"
                            accept="image/png, image/jpeg, image/jpg" required>
                        <small class="text-muted">Only png/jpg/jpeg</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" class="btn btn-light" type="button">Cancel</button>
                    <button type="submit" class="btn">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="detail-{{ $item->id }}" tabindex="-1" role="modal"
    aria-labelledby="modal-label-{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modal-label-{{ $item->id }}" class="modal-title">Detail Material</h4>
                <button aria-hidden="true" data-bs-dismiss="modal" class="btn-close" type="button">×</button>
            </div>
            <div class="modal-body">
                @if ($item->status == 'not paid')
                <div class="alert alert-info show">
                    <i class="fas fa-info-circle me-2"></i> Please upload proof of payment
                </div>
                @elseif ($item->status == 'waiting delivery')
                <div class="alert alert-info show">
                    <i class="fas fa-info-circle me-2"></i> Please deliver the goods to our location.
                </div>
                @elseif ($item->status == 'processing')
                <div class="alert alert-info show">
                    <i class="fas fa-info-circle me-2"></i> We are processing your order
                </div>
                @elseif ($item->status == 'picked up')
                <div class="alert alert-info show">
                    <i class="fas fa-info-circle me-2"></i> Your order has been picked up
                </div>
                @elseif ($item->status == 'delivered')
                <div class="alert alert-info show">
                    <i class="fas fa-info-circle me-2"></i> Your order has been delivered
                </div>
                @elseif ($item->status == 'cancelled')
                <div class="alert alert-info show">
                    <i class="fas fa-info-circle me-2"></i> Your order has been cancelled
                </div>
                @elseif($item->status == 'completed')
                <div class="alert alert-info show">
                    <i class="fas fa-info-circle me-2"></i> Your order has been completed. Thanks for using our service
                </div>
                @endif

                <div class="shop-cart">
                    <div class="table table-sm table-striped table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="cart-product-thumbnail">Product</th>
                                    <th class="text-center">Weight</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->detail as $detail)
                                <tr>
                                    <td class="cart-product-thumbnail">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0)">
                                                <img src="{{ !empty($detail->picture) ? url('/storage/order/' . $detail->picture) : asset('assets/images/no-image.jpg') }}"
                                                    alt="{{ $detail->product->name }}">
                                            </a>
                                            <div class="cart-product-thumbnail-name">{{ $detail->product->name }}</div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $detail->weight }} kg</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-bs-dismiss="modal" class="btn btn-b" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection