@extends('client.layouts.master')

@section('title', 'Cart')

@section('content')
<section id="page-title">
    <div class="container">
        <div class="page-title">
            <h1>Cart</h1>
            <a href="{{ route('client.home.index') }}" class="button-link">Back to Home Page</a>
        </div>
    </div>
</section>

@if (session('error'))
<div class="container">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

<!-- SHOP CART -->
<form action="{{ route('client.checkout.store', $data->id) }}" method="POST" enctype="multipart/form-data" novalidate>
    @csrf
    @method('PUT')

    <section id="shop-cart">
        <div class="container">
            <div class="shop-cart">
                <div class="table table-sm table-striped table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="cart-product-remove"></th>
                                <th class="cart-product-thumbnail">Material</th>
                                <th class="cart-product-quantity">Weight (kg)</th>
                                <th>Picture <small class="text-muted">(Only png, jpg and jpeg files are allowed and max
                                        2MB)</small></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->detail as $item)
                            <tr id="product-{{ $item->id }}">
                                <td class="cart-product-remove">
                                    <a href="javascript:void(0)" class="remove" data-id="{{ $item->id }}"><i
                                            class="fa fa-times text-danger"></i></a>
                                </td>
                                <td class="cart-product-thumbnail d-flex align-items-center">
                                    <a href="javascript:void(0)">
                                        <img src="{{ !empty($item->picture) ? url('/storage/product/' . $item->picture) : asset('assets/images/no-image.jpg') }}"
                                            alt="{{ $item->product->name }}">
                                    </a>
                                    <div class="cart-product-thumbnail-name">{{ $item->product->name }}</div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="number" placeholder="Weight (kg)"
                                            class="form-control form-control-sm @error('product.' . $item->id . '.weight') is-invalid @enderror"
                                            min="1" value="1" required name="product[{{ $item->id }}][weight]">

                                        @error('product.' . $item->id . '.weight')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="file" name="product[{{ $item->id }}][picture]"
                                            class="form-control @error('product.' . $item->id . '.picture') is-invalid @enderror"
                                            accept="image/png, image/jpg, image/jpeg">

                                        @error('product.' . $item->id . '.picture')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <hr class="space">

                <div class="row justify-content-end">
                    <div class="col-lg-6">
                        <h4>Shipping Details</h4>
                        <div class="row">
                            <div class="col-12 form-group">
                                <input type="tel" placeholder="Phone Number"
                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ old('phone', $data->phone) }}" required>

                                @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-12 form-group">
                                <textarea placeholder="Address"
                                    class="form-control @error('address') is-invalid @enderror" name="address" rows="3"
                                    style="resize: none" required>{{ old('address', $data->address) }}</textarea>

                                @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            <div class="col-12 form-group">
                                <select class="form-select @error('kecamatan') is-invalid @enderror" name="kecamatan" id="kecamatan" required>
                                    <option value="">Kecamatan & Kelurahan</option>
                                    <!-- <option value="parongpong" {{ old('kecamatan', $data->kecamatan) == 'parongpong' ?
    'selected' : '' }}>Parongpong</option>
                                </select>
                            
                                @error('kecamatan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> -->
                            <option value="parongpong-cigugurgirang" {{ old('parongpong-kelurahan', $data->kecamatan) == 'cigugurgirang' ?
    'selected' : '' }}>Parongpong-Cigugurgirang
                            </option>
                            <option value="parongpong-cihanjuang" {{ old('kecamatan', $data->kecamatan) == 'parongpong-cihanjuang' ? 'selected'
    : '' }}>Parongpong-Cihanjuang
                            </option>
                            <option value="parongpong-cihanjuangrahayu" {{ old('kecamatan', $data->kecamatan) == 'parongpong-cihanjuangrahayu' ? 'selected'
    : '' }}>
                                Parongpong-Cihanjuangrahayu
                            </option>
                            <option value="parongpong-cihideung" {{ old('kecamatan', $data->kecamatan) == 'parongpong-cihideung' ? 'selected'
    : '' }}>Parongpong-Cihideung
                            </option>
                            </select>
                            
                            @error('kecamatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>

                            <!-- <div class="col-12 form-group">
                                <select class="form-select @error('kelurahan') is-invalid @enderror" name="shipping" id="shipping" required>
                                    <option value="">Kelurahan</option>
                                    <option value="cigugurgirang" {{ old('kelurahan', $data->kelurahan) == 'cigugurgirang' ?
    'selected' : '' }}>Cigugurgirang</option>
                                    <option value="cihanjuang" {{ old('kelurahan', $data->kelurahan) == 'cihanjuang' ? 'selected'
    : '' }}>Cihanjuang
                                    </option>
                                    <option value="cihanjuangrahayu" {{ old('kelurahan', $data->kelurahan) == 'cihanjuangrahayu' ? 'selected'
    : '' }}>Cihanjuangrahayu
                                    </option>
                                    <option value="cihideung" {{ old('kelurahan', $data->kelurahan) == 'cihideung' ? 'selected'
    : '' }}>Cihideung
                                    </option>
                                </select>
                            
                                @error('kelurahan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> -->
                            

                            <div class="col-12 form-group">
                                <select class="form-select @error('shipping') is-invalid @enderror" name="shipping"
                                    id="shipping" required>
                                    <option value="">Shipping Method</option>
                                    <option value="dropoff" {{ old('shipping', $data->shipping) == 'dropoff' ?
    'selected' : '' }}>Drop-off</option>
                                    <option value="pickup" {{ old('shipping', $data->shipping) == 'pickup' ? 'selected'
    : '' }}>Pick-up (Rp. 9.000)</option>
                                </select>

                                @error('shipping')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            @if ($vouchers->isNotEmpty())
                            <div class="col-12 form-group" id="voucher-field">
                                <select class="form-select" name="voucher" id="voucher" required>
                                    <option value="">Choose Voucher</option>
                                    @foreach ($vouchers as $item)
                                    <option value="{{ $item[0]->id }}" {{ old('voucher') == $item[0]->id
            ? 'selected' : '' }}>{{ $item[0]->name }} ({{ $item->count() }})</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="col-12 form-group" id="payment_method">
                                <select class="form-select" name="payment" id="payment" required>
                                    <option value="">Payment Method</option>
                                    <option value="cash" {{ old('payment', $data->payment) == 'cash' ? 'selected' : ''
                                        }}>Cash</option>
                                    <option value="transfer" {{ old('payment', $data->payment) == 'transfer' ?
    'selected' : ''
                                        }}>Bank Transfer</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
@endsection

@push('script')
<script>
    $('#shipping').on('change', function () {
        if ($(this).val() == 'dropoff') {
            $('#payment_method').hide();
            $('#payment').attr('required', false);

            $('#voucher-field').hide();
            $('#voucher').val('');
        } else {
            $('#payment_method').show();
            $('#voucher-field').show();
        }
    })

    $('#voucher').on('change', function () {
        if ($(this).val() != '') {
            $('#payment_method').hide();
            $('#payment').attr('required', false);
        } else {
            $('#payment_method').show();
        }
    })
</script>
<script>
    $(document).ready(function () {
        $('.remove').on('click', function () {
            var id = $(this).data('id');
            $.ajax({
                url: "{{ route('client.cart.remove') }}",
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function (data) {
                    if (data.success) {
                        toastify(data.message, 'success');
                        
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    } else {
                        toastify(data.message, 'error');
                    }
                }
            });
        })
    })
</script>
@endpush