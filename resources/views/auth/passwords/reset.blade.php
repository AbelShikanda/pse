@extends('layouts.app')

@section('content')
    <section class="ps-section" style="min-height:70vh; display:flex; align-items:center; padding-top:calc(var(--header-h) + 2rem)">
        <div class="ps-container" style="max-width:640px">
            <div class="ps-summary">
                <span class="ps-eyebrow">Account recovery</span>
                <h1 style="font-size:1.4rem; margin:.6rem 0 1rem">Choose a new password</h1>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" name="email" class="form-control mb-3 @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    @error('email')<small class="text-danger d-block mb-2">{{ $message }}</small>@enderror
                    <label class="form-label" for="password">New password</label>
                    <input id="password" type="password" name="password" class="form-control mb-3 @error('password') is-invalid @enderror" required autocomplete="new-password">
                    @error('password')<small class="text-danger d-block mb-2">{{ $message }}</small>@enderror
                    <label class="form-label" for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control mb-3" required autocomplete="new-password">
                    <button type="submit" class="ps-btn" style="width:100%; justify-content:center">Update password</button>
                </form>
            </div>
        </div>
    </section>
@endsection
