@extends('layouts.app')

@section('content')
    <section class="ps-section" style="min-height:80vh; display:flex; align-items:center; padding-top:calc(var(--header-h) + 2rem)">
        <div class="ps-container" style="max-width:920px">
            <div class="row gy-4 align-items-center">
                <div class="col-md-5 d-none d-md-block">
                    <span class="ps-eyebrow">Welcome back</span>
                    <h1 class="ps-heading" style="margin-top:.5rem">Sign in to <em>PrintShop</em></h1>
                    <p class="ps-lead">Track orders, reorder favourites and save the fits you love.</p>
                    <img src="{{ asset('assets/img/logo.png') }}" alt="PrintShopEld" style="width:120px; opacity:.9; margin-top:1.5rem">
                </div>
                <div class="col-md-7">
                    <form method="POST" action="{{ route('login') }}" class="ps-summary">
                        @csrf
                        <h2 style="font-size:1.2rem; margin-bottom:1.2rem">Sign in</h2>
                        @if ($errors->any())
                            <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                        @endif

                        <label class="form-label" for="email">Email</label>
                        <input id="email" type="email" class="form-control mb-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')<small class="text-danger d-block mb-2">{{ $message }}</small>@enderror

                        <label class="form-label" for="password">Password</label>
                        <input id="password" type="password" class="form-control mb-3 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')<small class="text-danger d-block mb-2">{{ $message }}</small>@enderror

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember" style="color:var(--text-2)">{{ __('Remember Me') }}</label>
                        </div>

                        <button type="submit" class="ps-btn" style="width:100%; justify-content:center">{{ __('Sign in') }} <i class="bi bi-arrow-right"></i></button>
                        <div style="display:flex; justify-content:space-between; margin-top:1rem; font-size:.85rem">
                            <a href="{{ route('password.request') }}">Forgot password?</a>
                            <a href="{{ route('register') }}">Create an account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
