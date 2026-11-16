@extends('layouts.app')

@section('content')
    <section class="ps-section" style="min-height:80vh; display:flex; align-items:center; padding-top:calc(var(--header-h) + 2rem)">
        <div class="ps-container" style="max-width:920px">
            <div class="row gy-4 align-items-center">
                <div class="col-md-5 d-none d-md-block">
                    <span class="ps-eyebrow">Join the studio</span>
                    <h1 class="ps-heading" style="margin-top:.5rem">One account,<br><em>every drop.</em></h1>
                    <p class="ps-lead">Early access to capsules, order tracking, and points on every piece.</p>
                    <img src="{{ asset('assets/img/logo.png') }}" alt="PrintShopEld" style="width:120px; margin-top:1.5rem">
                </div>
                <div class="col-md-7">
                    <form method="POST" action="{{ route('register') }}" class="ps-summary">
                        @csrf
                        @if (count($errors) > 0)
                            <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                        @endif
                        <h2 style="font-size:1.2rem; margin-bottom:1.2rem">Create account</h2>
                        <div class="row gy-3">
                            <div class="col-md-6"><label class="form-label" for="first_name">First name</label><input id="first_name" type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required autocomplete="given-name" autofocus></div>
                            <div class="col-md-6"><label class="form-label" for="last_name">Last name</label><input id="last_name" type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required autocomplete="family-name"></div>
                            <div class="col-12"><label class="form-label" for="phone">Phone</label><input id="phone" type="text" name="phone" class="form-control" value="{{ old('phone') }}" required autocomplete="tel" placeholder="0712 345 678"></div>
                            <div class="col-12"><label class="form-label" for="email">Email</label><input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="email"></div>
                            <div class="col-md-6"><label class="form-label" for="town">Town</label><input id="town" type="text" name="town" class="form-control" value="{{ old('town') }}" required placeholder="Nairobi"></div>
                            <div class="col-md-6"><label class="form-label" for="location">Delivery area</label><input id="location" type="text" name="location" class="form-control" value="{{ old('location') }}" required placeholder="Westlands"></div>
                            <div class="col-md-6"><label class="form-label" for="password">Password</label><input id="password" type="password" name="password" class="form-control" required autocomplete="new-password"></div>
                            <div class="col-md-6"><label class="form-label" for="password_confirmation">Confirm</label><input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password"></div>
                        </div>
                        <button type="submit" class="ps-btn" style="width:100%; justify-content:center; margin-top:1.3rem">Create account <i class="bi bi-arrow-right"></i></button>
                        <p style="text-align:center; margin-top:.9rem; font-size:.88rem; color:var(--text-2)">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
