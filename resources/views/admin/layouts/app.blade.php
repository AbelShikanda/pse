<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">

    <title>{{ config('app.name', 'PrintShop Admin') }}</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href=" {{ asset('admin/css/simplebar.css') }} ">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href=" {{ asset('admin/css/feather.css') }} ">
    <link rel="stylesheet" href=" {{ asset('admin/css/select2.css') }} ">





    <link rel="stylesheet" href=" {{ asset('admin/css/dataTables.bootstrap4.css') }}">
    <!-- Date Range Picker CSS -->

    <!-- Bundled Bootstrap 4 + base theme (layout grid/utilities) -->
    <link rel="stylesheet" href="{{ asset('admin/css/app-light.css') }}">
    <!-- Brand theme overrides -->
    <link rel="stylesheet" href="{{ asset('admin/css/brand.css') }}">

    <!-- Scripts -->


</head>

<body class="vertical dark">
    <div class="wrapper">
        @section('nav')
            @include('admin.layouts.nav')
        @show
        @section('sidebar')
            @include('admin.layouts.sidebar')
        @show
        <main role="main" class="main-content">
            @yield('content')
        </main>
    </div>


    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/js/simplebar.min.js') }}"></script>

    <script src="{{ asset('admin/js/Chart.min.js') }}"></script>
    <script>
        /* Chart.js v2 defaults */
        Chart.defaults.global.defaultFontFamily = 'Manrope, sans-serif';
        Chart.defaults.global.defaultFontColor = '#a5a1b2';
    </script>
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $('.select2').select2({
            theme: 'bootstrap4',
        });
        $('.select2-multi').select2({
            multiple: true,
            theme: 'bootstrap4',
        });


        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
    <script>
        $('#dataTable-1').DataTable({
            autoWidth: true,
            "lengthMenu": [
                [16, 32, 64, -1],
                [16, 32, 64, "All"]
            ]
        });
    </script>
    <script src="{{ asset('admin/js/apps.js') }}"></script>



</body>

</html>
