<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Dynamic Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="{{ $metaDescription ?? 'Print Shop Eld is the best branding option in Kenya for bringing your print to life. We offer t-shirt printing and custom apparel printing at affordable rates' }}">
    <meta name="keywords"
        content="{{ $metaKeywords ?? 'print, printing, custom, brand, t-shirt printing, appareal printing' }}">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Social Media Tags -->
    <meta property="og:title" content="{{ $metaTitle ?? config('app.name', 'PrintShop') }}">
    <meta property="og:description"
        content="{{ $metaDescription ?? 'Print Shop Eld is the best branding option in Kenya for bringing your print to life. We offer t-shirt printing and custom apparel printing at affordable rates' }}">
    <meta property="og:image" content="{{ asset($metaImage ?? 'default-image.jpg') }}">
    <meta property="og:url" content="{{ $metaUrl ?? url('/') }}">
    <meta property="og:type" content="website">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $metaTitle ?? config('app.name', 'PrintShop') }}</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo.png?v=2') }}" rel="icon">
    <link href="{{ asset('assets/img/logo.png') }}" rel="apple-touch-icon">

    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-RBL70XY3HX"></script>
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Organization",
          "url": "https://www.printshopeld.com",
          "name": "Print Shop ELd",
          "logo": "https://www.printshopeld.com/assets/img/logo.png"
        }
    </script>

    <!-- Scripts -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
</head>

<body>
    @section('header')
        @include('layouts.header')
    @show
    <main id="main">
        @yield('content')
    </main>
    @section('footer')
        @include('layouts.footer')
    @show


    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/typed.js/typed.umd.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        // Select all rating inputs
        const ratingInputs = document.querySelectorAll('.rating input[type="radio"]');

        // Add event listener to each input
        ratingInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Find the nearest form element for this input
                const form = input.closest('form');
                if (form) {
                    form.submit(); // Submit the specific form on selection
                }
            });
        });
    </script>

    <!-- Google tag (gtag.js) -->

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-RBL70XY3HX');
    </script>

    <script>
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', function() {
                var buttonId = this.id; // Or any other identifier like class
                fetch('/track-button-click', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        button_id: buttonId,
                    })
                });
            });
        });
    </script>

</body>

</html>
