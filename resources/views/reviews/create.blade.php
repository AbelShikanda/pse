@extends('layouts.app')

@section('content')
    @include('layouts.hero_single')

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="paralax-mf footer-paralax bg-image route"
        style="background-image: url(assets/img/header.jpg)">
        <div class="overlay-mf"></div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="contact-mf">
                        <div id="contact" class="box-shadow-full">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="title-box-2">
                                        <h5 class="title-left">
                                            Send comment
                                        </h5>
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
                                    </div>
                                    <div>
                                        <form class="php-email-form" action="{{ route('review.store') }}" method="POST"
                                            role="form">
                                            @csrf
                                            @method('post')
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-group">
                                                        <select name="rating" class="form-control">
                                                            <option value="5" selected>5 - Excellent</option>
                                                            <option value="4">4 - Good</option>
                                                            <option value="3">3 - Average</option>
                                                            <option value="2">2 - Poor</option>
                                                            <option value="1">1 - Bad</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="token" value="{{ $token }}">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea class="form-control" name="review" rows="5" placeholder="Comment" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-center my-3">
                                                    <div class="loading">Loading</div>
                                                    <div class="error-message"></div>
                                                    <div class="sent-message">Your comment has been sent. Thank you!
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    <button type="submit"
                                                        class="button button-a button-big button-rouded">Send
                                                        comment</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="title-box-2 pt-4 pt-md-0">
                                        <h5 class="title-left">
                                            Register for more
                                        </h5>
                                    </div>
                                    <div class="more-info">
                                        <p class="lead">

                                        <div class="socials">
                                            <p> Print Shop Eld </p>
                                            <a href="https://www.printshopeld.com/login">
                                                <span class="ico-circle">
                                                    <i class="bi bi-globe"></i>
                                                </span>
                                            </a>
                                        </div>
                                        </p>
                                        <ul class="list-ico">
                                            <li><span class="bi bi-geo-alt"></span> Nairobi Kenya
                                            </li>
                                            <li><span class="bi bi-phone"></span> +254 728 157 164</li>
                                            <li><span class="bi bi-envelope"></span> info@printshopeld.com</li>
                                        </ul>
                                    </div>
                                    <div class="socials">
                                        <ul>
                                            <li><a href="https://www.facebook.com/printshopeldofficial/"><span
                                                        class="ico-circle"><i class="bi bi-facebook"></i></span></a></li>
                                            <li><a href="https://www.instagram.com/printshopeld/"><span
                                                        class="ico-circle"><i class="bi bi-instagram"></i></span></a></li>
                                            {{-- <li><a href=""><span class="ico-circle"><i
                                                            class="bi bi-twitter"></i></span></a></li> --}}
                                            <li><a href="https://www.linkedin.com/in/abel-shikanda-4a68a582/"><span
                                                        class="ico-circle"><i class="bi bi-linkedin"></i></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Contact Section -->

@endsection
