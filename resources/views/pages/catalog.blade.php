@extends('layouts.app')

@section('content')
    <section class="ps-page-band">
        <div class="ps-container">
            <p class="ps-breadcrumb"><a href="{{ url('/') }}">Home</a> / Catalog</p>
            <h1>The <em style="font-style:italic;color:var(--brand-3)">Catalog</em></h1>
            <p class="ps-lead">Printed to order in Nairobi. Filter by category, sort by price, or find the piece you came for.</p>
        </div>
    </section>

    <section class="ps-section" style="padding-top:2rem">
        <div class="ps-container">
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <div class="ps-catalog-toolbar">
                <div class="ps-chip-row" role="group" aria-label="Filter by category">
                    <a href="{{ route('catalog') }}" class="ps-chip {{ request()->is('catalog') ? 'active' : '' }}">All</a>
                    @foreach ($categories ?? [] as $category)
                        <a href="{{ route('catalog.category', $category->slug) }}" class="ps-chip {{ request()->is('catalog/' . $category->slug) ? 'active' : '' }}">{{ $category->name }}</a>
                    @endforeach
                </div>
                <div style="display:flex; gap:.6rem; align-items:center; flex-wrap:wrap">
                    <label class="ps-search" for="catalogSearch"><i class="bi bi-search"></i>
                        <input type="search" id="catalogSearch" placeholder="Search the catalog..." autocomplete="off" aria-label="Search products">
                    </label>
                    <label class="ps-sort" for="catalogSort">Sort
                        <select id="catalogSort" class="form-select" style="width:auto;padding:.55rem .8rem">
                            <option value="featured">Featured</option>
                            <option value="price-asc">Price: low to high</option>
                            <option value="price-desc">Price: high to low</option>
                            <option value="name">Name A–Z</option>
                        </select>
                    </label>
                </div>
            </div>

            <div class="ps-grid" id="catalogGrid">
                @forelse ($images as $item)
                    @include('layouts.partials.catalog')
                @empty
                    <p class="text-muted">No products found.</p>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">{{ $images->links() }}</div>
        </div>
    </section>
@endsection
