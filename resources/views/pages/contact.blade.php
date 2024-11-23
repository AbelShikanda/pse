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
                                            Send Message Us
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
                                        <form class="php-email-form" action="{{ route('contactStore') }}" method="POST" role="form">
                                            @csrf
                                            @method('post')
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-group">
                                                        <input type="text" name="name" class="form-control"
                                                            placeholder="Your Name" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-group">
                                                        <input type="email" class="form-control" name="email"
                                                            placeholder="Your Email" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="subject"
                                                            placeholder="Subject" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-center my-3">
                                                    <div class="loading">Loading</div>
                                                    <div class="error-message"></div>
                                                    <div class="sent-message">Your message has been sent. Thank you!
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    <button type="submit"
                                                        class="button button-a button-big button-rouded">Send
                                                        Message</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="title-box-2 pt-4 pt-md-0">
                                        <h5 class="title-left">
                                            Get in Touch
                                        </h5>
                                    </div>
                                    <div class="more-info">
                                        <p class="lead">
                                            To get in touch <br>
                                            Fill out the form <br>
                                            send us an email. <br>
                                            We are passionate about our customers and are always 
                                            ready to help with all your needs!
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
                                            <li><a href="https://www.facebook.com/printshopeldofficial/"><span class="ico-circle"><i
                                                            class="bi bi-facebook"></i></span></a></li>
                                            <li><a href="https://www.instagram.com/printshopeld/"><span class="ico-circle"><i
                                                            class="bi bi-instagram"></i></span></a></li>
                                            {{-- <li><a href=""><span class="ico-circle"><i
                                                            class="bi bi-twitter"></i></span></a></li> --}}
                                            <li><a href="https://www.linkedin.com/in/abel-shikanda-4a68a582/"><span class="ico-circle"><i
                                                            class="bi bi-linkedin"></i></span></a></li>
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
