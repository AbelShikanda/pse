@extends('layouts.app')

@section('content')
    <section class="ps-page-band">
        <div class="ps-container">
            <span class="ps-eyebrow">Review request</span>
            <h1>Tell us how it <em style="font-style:italic;color:var(--brand-3)">wears</em></h1>
            <p class="ps-lead">This link was sent to {{ request('name') ? e(request('name')) : 'you' }}. Your review appears on the storefront.</p>
        </div>
    </section>

    <section class="ps-section" style="padding-top:2.5rem">
        <div class="ps-container" style="max-width:760px">
            @if (count($errors) > 0)
                <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif
            @if (session('message'))<div class="alert alert-success">{{ session('message') }}</div>@endif

            <form action="{{ route('review.store') }}" method="POST">
                @csrf
                <input type="hidden" name="guest_name" value="{{ request('name') }}">
                <input type="hidden" name="token" value="{{ $token }}">

                <label class="form-label" for="ratingSelect">Your rating</label>
                <select id="ratingSelect" name="rating" class="form-select" style="max-width:280px; margin-bottom:1.2rem">
                    <option value="5" selected>5 — Excellent</option>
                    <option value="4">4 — Good</option>
                    <option value="3">3 — Average</option>
                    <option value="2">2 — Poor</option>
                    <option value="1">1 — Poor fit / quality</option>
                </select>

                <label class="form-label" for="reviewText">Your review</label>
                <textarea id="reviewText" name="review" class="form-control" rows="5" required placeholder="Fabric, fit, print quality, delivery..."></textarea>

                <button type="submit" class="ps-btn" style="margin-top:1.2rem"><i class="bi bi-send"></i> Submit review</button>
            </form>
        </div>
    </section>
@endsection
