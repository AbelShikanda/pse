@php $product = $item->products[0] ?? null; @endphp
@if ($product)
<article class="ps-card catalog-item" data-reveal data-price="{{ $product->price }}">
    <a href="{{ route('catalogDetail', $product->slug) }}" class="text-decoration-none" aria-label="{{ $product->name }}">
        <div class="ps-card__media" style="background-image:url('{{ asset('storage/img/products/' . $item->thumbnail) }}')">
            @if ($product->promotion)<span class="ps-card__badge">Promo</span>@endif
        </div>
    </a>
    <button type="button" class="ps-card__wishlist" data-wishlist="{{ $product->id }}" aria-label="Save {{ $product->name }} to wishlist"><i class="bi bi-heart"></i></button>
    <div class="ps-card__body">
        <p class="ps-card__name">{{ $product->name }}</p>
        <p class="ps-card__meta">{{ $product->slug }}</p>
        <div class="ps-card__foot">
            <span>
                @if ($product->promotion)<span class="ps-price ps-price--old">KSh {{ number_format($product->price * 1.1) }}</span>@endif
                <span class="ps-price">KSh {{ number_format($product->price) }}</span>
            </span>
            <a href="{{ route('addToCart', $item->id) }}" class="ps-add" aria-label="Add to cart"><i class="bi bi-bag-plus"></i></a>
        </div>
    </div>
</article>
@endif
