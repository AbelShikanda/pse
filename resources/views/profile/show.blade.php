@extends('layouts.app')

@section('content')
    @include('layouts.hero_profile')
    <!-- ======= Blog Single Section ======= -->
    <section class="blog-wrapper sect-pt4" id="blog">
        <div class="container">
            <section class="profile_wrapper">

                <div class="profile_lists mt-5">
                    <div class="profile_title">
                        <span class="material-outline-icons">shopping_cart</span>
                        Things You Bought
                    </div>

                    @include('layouts.partials.profile')

                </div>

                <div class="profile_details mt-5">

                    @include('layouts.partials.profileFooter')
                </div>
            </section>
        </div>
    </section><!-- End Blog Single Section -->
@endsection
