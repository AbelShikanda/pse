@extends('layouts.app')

@section('content')
    @include('layouts.hero_single')

    <!-- ======= Blog Single Section ======= -->
    <section class="blog-wrapper sect-pt4" id="blog">
        <div class="container">
            <div class="row">
                <div class="row  mb-5">
                    @foreach ($blogs as $blog)
                        <div class="mt-2 mb-2 col-12 col-md-6 col-lg-6">
                            @include('layouts.partials.blog')
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section><!-- End Blog Single Section -->
@endsection
