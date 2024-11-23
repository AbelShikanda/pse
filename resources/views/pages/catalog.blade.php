@extends('layouts.app')

@section('content')
    @include('layouts.hero_single')
    <br>
    <br>
    <br>
    @if (count($errors) > 0)
        <div class="alert alert-danger col-md-8 offset-md-3">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="pt-3">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
    </div>

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
        <div class="container">
            <div class="row">
                @foreach ($images as $item)
                    <div class="mb-5 col-6 col-md-6 col-lg-4">
                        @include('layouts.partials.catalog')
                    </div>
                @endforeach
            </div>
        </div>
    </section><!-- End Portfolio Details Section -->
    <br>
    <br>
    <br>

@endsection
