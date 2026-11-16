@extends('layouts.app')

@section('content')
    <section class="ps-page-band">
        <div class="ps-container">
            <p class="ps-breadcrumb"><a href="{{ url('/') }}">Home</a> / Contact</p>
            <h1>Talk to the <em style="font-style:italic;color:var(--brand-3)">studio</em></h1>
            <p class="ps-lead">Quotes, bulk orders, custom embroidery — we reply within a working day.</p>
        </div>
    </section>

    <section class="ps-section" style="padding-top:2rem">
        <div class="ps-container">
            @if (count($errors) > 0)
                <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif
            @if (session()->has('message'))<div class="alert alert-success">{{ session('message') }}</div>@endif

            <div class="row gy-4">
                <div class="col-lg-7">
                    <form action="{{ route('contactStore') }}" method="POST">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-md-6"><label class="form-label" for="name">Name</label><input id="name" type="text" name="name" class="form-control" required></div>
                            <div class="col-md-6"><label class="form-label" for="email">Email</label><input id="email" type="email" name="email" class="form-control" required></div>
                            <div class="col-12"><label class="form-label" for="subject">Subject</label><input id="subject" type="text" name="subject" class="form-control" required></div>
                            <div class="col-12"><label class="form-label" for="message">Message</label><textarea id="message" name="message" class="form-control" rows="6" required></textarea></div>
                        </div>
                        <button type="submit" class="ps-btn" style="margin-top:1.2rem"><i class="bi bi-send"></i> Send message</button>
                    </form>
                </div>
                <div class="col-lg-5">
                    <div class="ps-summary" style="height:100%">
                        <h2 style="font-size:1.2rem; margin-bottom:1rem">Reach us</h2>
                        <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:1rem">
                            <li style="display:flex; gap:.7rem; align-items:center"><i class="bi bi-geo-alt" style="color:var(--brand-2); font-size:1.2rem"></i><span style="color:var(--text-2)">Nairobi, Kenya</span></li>
                            <li style="display:flex; gap:.7rem; align-items:center"><i class="bi bi-telephone" style="color:var(--brand-2); font-size:1.2rem"></i><a href="tel:+254728157164" style="color:var(--text-2)">+254 728 157 164</a></li>
                            <li style="display:flex; gap:.7rem; align-items:center"><i class="bi bi-envelope" style="color:var(--brand-2); font-size:1.2rem"></i><a href="mailto:info@printshopeld.com" style="color:var(--text-2)">info@printshopeld.com</a></li>
                        </ul>
                        <hr style="border-color:var(--border); margin:1.5rem 0">
                        <h3 style="font-size:.78rem; letter-spacing:.18em; text-transform:uppercase; color:var(--text-3); margin-bottom:.8rem">Elsewhere</h3>
                        <div style="display:flex; gap:.5rem">
                            <a href="https://www.instagram.com/printshopeld/" class="ps-icon-btn" style="border:1px solid var(--border)" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                            <a href="https://www.facebook.com/printshopeldofficial/" class="ps-icon-btn" style="border:1px solid var(--border)" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="https://www.linkedin.com/in/abel-shikanda-4a68a582/" class="ps-icon-btn" style="border:1px solid var(--border)" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        </div>
                        <a href="https://wa.me/254728157164" class="ps-btn" style="margin-top:1.5rem; width:100%; justify-content:center"><i class="bi bi-whatsapp"></i> Chat on WhatsApp</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
