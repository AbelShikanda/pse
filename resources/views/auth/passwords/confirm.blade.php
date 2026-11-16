@extends('layouts.app')

@section('content')
    <section class="ps-section" style="min-height:70vh; display:flex; align-items:center; padding-top:calc(var(--header-h) + 2rem)">
        <div class="ps-container" style="max-width:640px">
            <div class="ps-summary">
                <span class="ps-eyebrow">Security check</span>
                <h1 style="font-size:1.4rem; margin:.6rem 0 .4rem">Please confirm your password</h1>
                <p style="color:var(--text-2); font-size:.92rem; margin-bottom:1.2rem">This area is sensitive. Confirm your password before continuing.</p>
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <label class="form-label" for="passwordConfirm">Password</label>
                    <input id="passwordConfirm" type="password" name="password" class="form-control mb-3 @error('password') is-invalid @enderror" required autocomplete="current-password" autofocus>
                    @error('password')<small class="text-danger d-block mb-2">{{ $message }}</small>@enderror
                    <button type="submit" class="ps-btn" style="width:100%; justify-content:center">Confirm password</button>
                </form>
            </div>
        </div>
    </section>
@endsection
