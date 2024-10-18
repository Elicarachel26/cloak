@extends('client.layouts.master')

@section('title', 'All Material')

@section('content')
<div class="my-5">
    <div class="container shop">
        <h2 class="section-title text-center">All Material</h2>
        <a href="{{ route('client.home.index') }}" class="button-link">Back to Home Page</a>

        <div class="grid-layout grid-3-columns" data-item="grid-item">
            @foreach ($products as $item)
            <div class="grid-item">
                <div class="product">
                    <div class="product-image">
                        <img alt="Shop product image!"
                            src="{{ !empty($item->picture) ? url('/storage/product/' . $item->picture) : asset('assets/images/no-image.jpg') }}">
                        <div class="product-overlay" style="position: static;">
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

        <div class="d-flex justify-content-end">
            {{ $products->links() }}
        </div>
    </div>
</div>
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