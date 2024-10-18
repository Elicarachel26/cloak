<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/x-icon" href="{{URL('client/images/favicon.ico')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="">
    {{--
    <link rel="icon" type="image/png" href="images/favicon.png"> --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title', 'CLOAK')</title>

    @include('client.layouts.css')
</head>

<body>
    <div class="body-inner">
        @include('client.layouts.header')

        @yield('content')

        @include('client.layouts.footer')
    </div>

    <!-- WhatsApp Button -->
    <a style="position: fixed; right: 16px; bottom: 85px; z-index: 199;" href="https://wa.me/62895331879088?text=Halo" target="_blank" rel="noopener"
        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Hubungi WhatsApp Kami" data-bs-original-title
        title>
        <img src="{{ asset('client/images/whatsapp_icon.png') }}" width="60">
    </a>

    <a id="scrollTop"><i class="icon-chevron-up"></i><i class="icon-chevron-up"></i></a>

    @include('client.layouts.script')
</body>

</html>