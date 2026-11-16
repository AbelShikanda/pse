@extends('layouts.app')

@section('content')
    <section class="ps-page-band">
        <div class="ps-container">
            <p class="ps-breadcrumb"><a href="{{ url('/') }}">Home</a> / Stories</p>
            <h1>Studio <em style="font-style:italic;color:var(--brand-3)">stories</em></h1>
            <p class="ps-lead">Embroidery notes, print-care guides and the occasional opinion from the workshop floor.</p>
        </div>
    </section>

    <section class="ps-section" style="padding-top:2rem">
        <div class="ps-container">
            <div class="row gy-4">
                @forelse ($blogs as $blog)
                    <div class="col-md-6 col-lg-4">
                        @include('layouts.partials.blog')
                    </div>
                @empty
                    <p class="text-muted">No stories yet — check back soon.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
