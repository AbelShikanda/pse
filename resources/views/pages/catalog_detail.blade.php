@extends('layouts.app')

@section('content')
    <div class="ps-container ps-pdp">
        <!-- Gallery -->
        <div class="ps-pdp__gallery">
            <div class="ps-pdp__stage">
                @if ($product->ProductImage->first())
                    <img src="{{ asset('storage/img/products/' . $product->ProductImage->first()->thumbnail) }}" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('assets/img/logo.png') }}" alt="{{ $product->name }}" style="object-contain; background:var(--bg-2); padding:2rem">
                @endif
                @if ($product->promotion)
                    <span class="ps-card__badge" style="top:1rem; left:1rem">Offer</span>
                @endif
            </div>
            @if ($product->ProductImage->count() > 1)
                <div class="ps-pdp__thumbs">
                    @foreach ($product->ProductImage as $image)
                        <button type="button" data-full="{{ asset('storage/img/products/' . $image->thumbnail) }}" data-alt="{{ $product->name }}" class="{{ $loop->first ? 'active' : '' }}" aria-label="View image {{ $loop->iteration }}">
                            <img src="{{ asset('storage/img/products/' . $image->thumbnail) }}" alt="{{ $product->name }} thumbnail">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Purchase panel -->
        <div>
            <p class="ps-pdp__meta">{{ $product->ProductType->first()->name ?? 'PrintShopEld' }} · SKU {{ $product->id }}</p>
            <h1 class="ps-pdp__name">{{ $product->name }}</h1>
            <div class="ps-rating-row" style="margin-bottom:.2rem">
                <span class="ps-stars">{{ str_repeat('★', max(1, min(5, (int) floor($averageRating)))) }}{{ str_repeat('☆', 5 - max(1, min(5, (int) floor($averageRating)))) }}</span>
                <span style="color:var(--text-3); font-size:.82rem">({{ $product->ratings->count() }} reviews)</span>
            </div>

            <div class="ps-pdp__price">
                @if ($product->promotion)<s>KSh {{ number_format($product->price * 1.1) }}</s>@endif
                <b>KSh {{ number_format($product->price) }}</b>
                <span style="color:var(--text-3); font-size:.8rem">/ piece</span>
            </div>

            <p class="ps-pdp__desc">{{ $product->description }}</p>

            <form action="{{ route('add.single', optional($product->ProductImage->first())->id ?? 0) }}" method="POST">
                @csrf

                <label class="form-label" for="colorSelect">Color</label>
                <select id="colorSelect" name="color" class="form-select" style="max-width:260px; margin-bottom:1.1rem">
                    <option value="{{ optional($product->Color->first())->name }}" selected>{{ optional($product->Color->first())->name }}</option>
                    @foreach (\App\Models\ProductColors::all() as $colorOption)
                        @if (optional($product->Color->first())->id !== $colorOption->id)
                            <option value="{{ $colorOption->name }}">{{ $colorOption->name }}</option>
                        @endif
                    @endforeach
                </select>

                <label class="form-label" for="sizeSelect">Size {{ $product->Size->count() === 0 ? '(coming soon)' : '' }}</label>
                <select id="sizeSelect" name="size" class="form-select" style="max-width:260px; margin-bottom:1.1rem">
                    @foreach ($product->Size as $size)
                        <option value="{{ $size->id }}" {{ old('size', $size->id) == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                    @endforeach
                </select>

                <label class="form-label" for="quantityInput">Quantity</label>
                <div class="ps-qty" data-qty>
                    <button type="button" data-qty-dec aria-label="Decrease quantity">−</button>
                    <input id="quantityInput" name="quantity" type="number" min="1" max="99" value="1" inputmode="numeric">
                    <button type="button" data-qty-inc aria-label="Increase quantity">+</button>
                </div>

                <div class="ps-cta-row">
                    <button type="submit" class="ps-btn" style="flex:1; justify-content:center; min-width:200px"><i class="bi bi-bag-plus"></i> Add to cart</button>
                    <button type="button" class="ps-icon-btn" data-wishlist="{{ optional($product->ProductImage->first())->id ?? 0 }}" aria-label="Save to wishlist" style="width:48px;height:48px;border:1px solid var(--border-strong);border-radius:var(--r-md)"><i class="bi bi-heart"></i></button>
                </div>
            </form>

            <div class="ps-trust">
                <span><i class="bi bi-truck"></i> Countrywide delivery</span>
                <span><i class="bi bi-shield-check"></i> M-Pesa checkout</span>
                <span><i class="bi bi-arrow-repeat"></i> Exchanges within 7 days</span>
            </div>
        </div>
    </div>

    <!-- Reviews -->
    <section class="ps-section" style="background:var(--bg-1); padding-top:2.5rem; padding-bottom:2.5rem">
        <div class="ps-container">
            <div class="ps-section__head">
                <div>
                    <span class="ps-eyebrow">Customer voices</span>
                    <h2 class="ps-heading" style="font-size:clamp(1.5rem,2.4vw,2rem)">Reviews</h2>
                </div>
                <span style="color:var(--text-3)">{{ $product->ratings->count() }} total</span>
            </div>
            @if ($product->ratings->count() === 0)
                <p style="color:var(--text-3)">No reviews yet — be the first to rate this product.</p>
            @else
                <div class="row gy-3">
                    @foreach ($product->ratings->take(6) as $rating)
                        <div class="col-md-4">
                            <figure class="ps-review" style="min-width:0">
                                <div class="ps-review__stars">{{ str_repeat('★', max(1, min(5, $rating->rating))) }}{{ str_repeat('☆', 5 - min(5, $rating->rating)) }}</div>
                                <figcaption class="ps-review__who" style="margin-top:.5rem"><span>{{ $rating->user->first_name ?? 'Customer' }} · {{ $rating->created_at->diffForHumans() }}</span></figcaption>
                            </figure>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
