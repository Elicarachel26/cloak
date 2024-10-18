@extends('client.layouts.master')

@section('content')
<div id="slider" class="inspiro-slider slider-fullscreen dots-creative" data-fade="true">
    <div class="slide" data-bg-image="{{ asset('client/images/recycle.jpg') }}">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="slide-captions text-center text-light">
                <h1 data-caption-animate="zoom-out">cLOAK</h1>
                <p>Turn Your Decluttering Efforts into Something Meaningful: Cloak Lets You Trade Your Unwanted Items
                    for Points, Creating a Positive Impact on Both Your Life and the Environment.</p>
                <a href="{{ route('client.product.index') }}" class="button-link">Add to Cart</a>

<style>
  .button-link {
    color: white;
    background-color: #2250FC; /* Warna biru */
    margin: 0px 0px 6px;
    padding: 12px 18px;
    text-decoration: none;
    border-radius: 5px;
  }

  .button-link:hover {
    background-color: #0056b3; /* Biru lebih tua saat hover */
  }
</style>

            </div>
        </div>
    </div>
</div>

<div class="space"></div>

<div class="container shop">
    <h2 class="section-title text-center">Materials</h2>
    <div class="grid-layout grid-3-columns" data-item="grid-item">
        @foreach ($products as $item)
        <div class="grid-item">
            <div class="product">
                <div class="product-image">
                    <img alt="Shop product image!"
                            src="{{ !empty($item->picture) ? url('/storage/product/' . $item->picture) : asset('assets/images/no-image.jpg') }}">
                    <div class="product-overlay">
                        <a href="javascript:void(0)" class="add-to-cart" data-id="{{ $item->id }}">Add to cart</a>
                    </div>
                </div>
                <div class="product-description">
                    <div class="product-title">
                        <h3><a href="javascript:void(0)">{{ $item->name }}</a></h3>
                        <p>{{ $item->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if ($products->isNotEmpty())
    <div class="d-flex justify-content-end">
        <a href="{{ route('client.product.index') }}" class="">View All Material <i class="fas fa-arrow-right align-middle"></i></a>
    </div>
    @endif
</div>

<div class="space"></div>
@endsection

@push('script')
<script>
    $(document).ready(function () {
        $('.add-to-cart').on('click', function () {
            if (!{{ auth()->check() ? 'true' : 'false' }}) {
                toastify('Please login first!', 'warning');
                window.location.href = "{{ route('login.index') }}";
                return false;
            }

            var id = $(this).data('id');
            $.ajax({
                url: "{{ route('client.cart.add') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: id
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
        });
    });
</script>
@endpush