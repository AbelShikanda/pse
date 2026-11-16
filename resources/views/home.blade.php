@extends('layouts.app')

@section('content')

    <section class="ps-hero">
        <div class="ps-hero__inner">
            <span class="ps-eyebrow ps-hero__kicker">Bespoke Print &amp; Embroidery · Kenya</span>
            <h1 class="ps-hero__title">Worn loud.<br>Printed <em>right.</em></h1>
            <p class="ps-hero__sub">Tees, hoodies, caps, polos and uniforms printed to order at our Nairobi workshop — then delivered countrywide. M-Pesa checkout, printed in days, not weeks.</p>
            <div class="ps-hero__ctas">
                <a href="{{ route('catalog') }}" class="ps-btn">Shop the catalog <i class="bi bi-arrow-right"></i></a>
                <a href="{{ url('/contacts') }}" class="ps-btn ps-btn--ghost">Talk to the studio</a>
            </div>
            <div class="ps-hero__meta">
                <span><strong>M-Pesa</strong>Pay on the spot</span>
                <span><strong>Printed in Kenya</strong>Short runs OK</span>
                <span><strong>Countrywide delivery</strong>Same-week dispatch</span>
            </div>
        </div>
        <div class="ps-hero__scroll"><span></span>Scroll</div>
    </section>

    <!-- New arrivals carousel -->
    <section class="ps-section">
        <div class="ps-container">
            <div class="ps-section__head">
                <div>
                    <span class="ps-eyebrow">Just printed</span>
                    <h2 class="ps-heading">New <em>arrivals</em></h2>
                </div>
                <a href="{{ route('catalog') }}" class="ps-btn ps-btn--ghost" style="padding:.5rem 1.1rem; font-size:.82rem">View all <i class="bi bi-arrow-right"></i></a>
            </div>

            <div class="ps-carousel" role="list">
                @foreach ($images as $item)
                    @php $product = $item->products[0] ?? null; @endphp
                    @if ($product)
                        <article class="ps-card" role="listitem">
                            <a href="{{ route('catalogDetail', $product->slug) }}" style="text-decoration:none">
                                <div class="ps-card__media" style="background-image:url('{{ asset('storage/img/products/' . $item->thumbnail) }}')">
                                    @if ($product->promotion)<span class="ps-card__badge">Promo</span>@endif
                                </div>
                            </a>
                            <div class="ps-card__body">
                                <p class="ps-card__name">{{ $product->name }}</p>
                                <p class="ps-card__meta">{{ strtoupper(str_replace('-', ' ', $product->slug)) }}</p>
                                <div class="ps-card__foot">
                                    <span><span class="ps-price ps-price--old">KSh {{ number_format($product->price * 1.1) }}</span><span class="ps-price">KSh {{ number_format($product->price) }}</span></span>
                                    <a href="{{ route('addToCart', $item->id) }}" class="ps-add" aria-label="Add {{ $product->name }} to cart"><i class="bi bi-bag-plus"></i></a>
                                </div>
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- Editorial banner -->
    <section class="ps-section" style="padding-top:0">
        <div class="ps-container">
            <div class="ps-editorial" style="background-image:url('{{ asset('assets/img/header.jpg') }}')">
                <div class="ps-editorial__content">
                    <span class="ps-eyebrow" style="color:var(--brand-3)">Made in Nairobi</span>
                    <h3 style="font-family:var(--font-serif); font-size:clamp(1.6rem,3vw,2.4rem); margin:.6rem 0 .4rem">Your brand,<br><em style="color:var(--brand-2)">worn everywhere.</em></h3>
                    <p style="color:var(--text-2); max-width:52ch; margin-bottom:1.1rem">Bulk uniforms, event merchandise, band tees and statement caps — printed and embroidered in-house. Send artwork, we handle the rest.</p>
                    <a href="{{ url('/contacts') }}" class="ps-btn">Request a quote <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stories -->
    <section class="ps-section ps-section--alt">
        <div class="ps-container">
            <div class="ps-section__head">
                <div>
                    <span class="ps-eyebrow">From the studio</span>
                    <h2 class="ps-heading">Latest <em>stories</em></h2>
                </div>
                <a href="{{ url('/blog') }}" class="ps-btn ps-btn--ghost" style="padding:.5rem 1.1rem; font-size:.82rem">All stories <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="row gy-4">
                @foreach ($blogs as $image)
                    @php $blog = $image->blogs[0] ?? null; @endphp
                    @if ($blog)
                        <div class="col-md-6">
                            <a href="{{ route('blogSingle', $blog->slug) }}" style="text-decoration:none">
                                <article class="ps-blog-card">
                                    <div class="ps-blog-card__media" style="background-image:url('{{ asset('storage/img/blogs/' . $image->thumbnail) }}')"><span class="ps-blog-card__tag">Studio notes</span></div>
                                    <div class="ps-blog-card__body">
                                        <h3 class="ps-blog-card__title">{{ $blog->title }}</h3>
                                        <p class="ps-blog-card__excerpt">{{ Str::limit(strip_tags($blog->body), 110) }}</p>
                                        <span style="color:var(--brand-3); font-size:.82rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase">Read story <i class="bi bi-arrow-right"></i></span>
                                    </div>
                                </article>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- Reviews -->
    <section class="ps-section">
        <div class="ps-container">
            <span class="ps-eyebrow">From customers</span>
            <h2 class="ps-heading">Word on the <em>street</em></h2>
            <div class="ps-carousel" style="margin-top:1.6rem">
                @foreach ($reviews as $review)
                    <figure class="ps-review">
                        <div class="ps-review__stars">{{ str_repeat('★', max(1, min(5, (int) $review->rating))) }}{{ str_repeat('☆', 5 - max(1, min(5, (int) $review->rating))) }}</div>
                        <blockquote class="ps-review__text">“{{ $review->review }}”</blockquote>
                        <figcaption class="ps-review__who"><i class="bi bi-person-circle" style="font-size:1.4rem; color:var(--brand-2)"></i><span><strong style="color:var(--text)">{{ $review->guest_name ?: ($review->user->first_name ?? 'Customer') }}</strong></span></figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Newsletter + standards -->
    <section class="ps-section ps-section--alt" style="padding-top:2rem">
        <div class="ps-container">
            <div class="ps-newsletter">
                <span class="ps-eyebrow" style="justify-content:center">The studio list</span>
                <h2 class="ps-heading" style="font-size:clamp(1.6rem,3vw,2.4rem)">Drops, care notes &amp; <em>studio stories</em></h2>
                <p class="ps-lead" style="margin-inline:auto">One email a month. Printed with restraint, like everything else we make.</p>
                <form action="#" method="post" onsubmit="event.preventDefault(); var m=this.querySelector('.ps-newsletter-msg'); m.textContent='Asante — you are on the list.'; this.querySelector('input[type=email]').value='';" style="display:flex; gap:.6rem; justify-content:center; flex-wrap:wrap; margin-top:1.3rem">
                    <label class="visually-hidden" for="homeEmail">Email</label>
                    <input id="homeEmail" type="email" required placeholder="you@example.com">
                    <button type="submit" class="ps-btn">Subscribe <i class="bi bi-arrow-right"></i></button>
                </form>
                <p class="ps-newsletter-msg" style="color:var(--ok); margin-top:.6rem; font-size:.86rem"></p>
            </div>
            <div class="ps-press" style="margin-top:2rem"><span>M-Pesa</span><span>Printed in Nairobi</span><span>Embroidery in-house</span><span>Bulk orders welcome</span></div>
        </div>
    </section>

@endsection
