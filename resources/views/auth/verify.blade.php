@extends('layouts.app')

@section('content')
    <section class="ps-section" style="min-height:70vh; display:flex; align-items:center; padding-top:calc(var(--header-h) + 2rem)">
        <div class="ps-container" style="max-width:640px; text-align:center">
            <div class="ps-summary">
                <i class="bi bi-envelope" style="font-size:2.4rem; color:var(--brand-2)"></i>
                <span class="ps-eyebrow" style="justify-content:center; margin-top:1rem">One more step</span>
                <h1 style="font-size:1.4rem; margin:.6rem 0 .6rem">Verify your email</h1>
                <p style="color:var(--text-2); margin-bottom:1.3rem">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                @if (session('resent'))<div class="alert alert-success" role="alert">{{ __('A fresh verification link has been sent to your email address.') }}</div>@endif
                <p style="color:var(--text-3)">Didn't get it?</p>
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="ps-btn" style="margin-top:.4rem"><i class="bi bi-send"></i> Resend verification link</button>
                </form>
            </div>
        </div>
    </section>
@endsection
