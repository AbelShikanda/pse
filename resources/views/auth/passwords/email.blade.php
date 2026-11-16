@extends('layouts.app')

@section('content')
    <section class="ps-section" style="min-height:70vh; display:flex; align-items:center; padding-top:calc(var(--header-h) + 2rem)">
        <div class="ps-container" style="max-width:640px">
            <div class="ps-summary">
                <span class="ps-eyebrow">Account recovery</span>
                <h1 style="font-size:1.4rem; margin:.6rem 0 .4rem">Reset your password</h1>
                <p style="color:var(--text-2); font-size:.92rem; margin-bottom:1.2rem">Enter your email and we'll send a reset link.</p>
                @if (session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" name="email" class="form-control mb-3 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')<small class="text-danger d-block mb-2">{{ $message }}</small>@enderror
                    <button type="submit" class="ps-btn" style="width:100%; justify-content:center">Send reset link <i class="bi bi-send"></i></button>
                </form>
                <div style="margin-top:1rem; font-size:.88rem"><a href="{{ route('login') }}">Back to sign in</a></div>
            </div>
        </div>
    </section>
@endsection
