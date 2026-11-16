<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="{{ $metaDescription ?? 'PrintShopEld — bespoke print and embroidery in Kenya. Tees, hoodies, caps, polos and uniforms printed to order, with M-Pesa checkout and delivery countrywide.' }}">
    <meta name="keywords"
        content="{{ $metaKeywords ?? 'print shop kenya, custom t-shirts nairobi, embroidery, branded merch, hoodies, caps, uniforms' }}">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="{{ $metaTitle ?? 'PrintShopEld — Bespoke Print & Embroidery in Kenya' }}">
    <meta property="og:description"
        content="{{ $metaDescription ?? 'Bespoke print and embroidery in Kenya. Tees, hoodies, caps, polos and uniforms printed to order.' }}">
    <meta property="og:image" content="{{ asset($metaImage ?? 'assets/img/header.jpg') }}">
    <meta property="og:url" content="{{ $metaUrl ?? url('/') }}">
    <meta property="og:type" content="website">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $metaTitle ?? 'PrintShopEld — Bespoke Print & Embroidery in Kenya' }}</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500;1,600&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}?v={{ filemtime(public_path('assets/css/style.css')) }}" rel="stylesheet">
</head>

<body>
    <a class="ps-skip-link" href="#main">Skip to content</a>
    @include('layouts.header')

    @if (session('message'))
        <div class="ps-container mt-2"><div class="alert alert-success mb-0">{{ session('message') }}</div></div>
    @endif
    @if (session('error'))
        <div class="ps-container mt-2"><div class="alert alert-danger mb-0">{{ session('error') }}</div></div>
    @endif

    <main id="main">
        @yield('content')
    </main>

    @include('layouts.footer')

    <button type="button" class="ps-top" aria-label="Back to top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})"><i class="bi bi-arrow-up"></i></button>
    <div class="ps-toast" role="status" aria-live="polite"></div>

    <script>
        document.querySelectorAll('.ps-raise-error').forEach(function (el) {
            el.addEventListener('click', function () {
                var toast = document.querySelector('.ps-toast');
                toast.textContent = el.dataset.message || 'Something went wrong.';
                toast.style.display = 'block';
                setTimeout(function () { toast.style.display = 'none'; }, 4200);
            });
        });
    </script>
    <script src="{{ asset('assets/js/main.js') }}?v={{ filemtime(public_path('assets/js/main.js')) }}" defer></script>
</body>

</html>
