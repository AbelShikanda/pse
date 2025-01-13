@extends('layouts.app')

@section('content')
    @include('layouts.hero_single')

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
        <div class="container-blog mt-5 mb-5">
            <div class="product-image">
                <img src="{{ asset('storage/img/products/' . $product->ProductImage[0]->thumbnail) }}" alt="{{$product->ProductImage[0]->full}}" class="product-pic">
            </div>
            <div class="product-details">
                <header>
                    <h1 class="title">{{ $product->name }}</h1>
                    <span class="colorCat">{{ $product->color[0]->name }}</span>
                    <div class="prices">
                        <span class="before">{{ $product->price * 1.1 }}</span>
                        <span class="current">{{ $product->price }}</span>
                    </div>
                    <div class="rate">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($averageRating))
                                <a href="#!" class="active">★</a>
                            @else
                                <a href="#!">★</a>
                            @endif
                        @endfor
                    </div>
                </header>
                <article>
                    <h5>Description</h5>
                    <p>{{ $product->description }}</p>
                </article>
                <div class="controls">
                    <div class="color">
                        <h5>color</h5>
                        <a href="#!">{{ $product->color[0]->name }}</a>
                    </div>
                    <div class="size">
                        <h5>size</h5>
                        <a href="#!">{{ $product->size[0]->name }}</a>
                    </div>
                    <div class="qty">
                        <h5>qty</h5>
                        <a href="#!">(1)</a>
                    </div>
                </div>
                <div class="footer">
                    <a href="{{ route('addToCart', ['id' => $product->ProductImage[0]->id]) }}" type="button">
                        <img src="http://co0kie.github.io/codepen/nike-product-page/cart.png" style="width:20px;" alt="">
                        <span>add to cart</span>
                    </a>
                    <a href="{{ route('catalog') }}" type="button">
                        <span>Catalog</span>
                    </a>
                    {{-- <div class="row mt-5">
                        <div class="col mb-5">
                            <a href="#!" alt=""><i class="bi bi-share-fill"></i></a>
                        </div>
                        <div class="col"></div>
                        <div class="col mb-5">
                            <a href="#!" alt=""><i class="bi bi-chevron-double-right"></i></a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section><!-- End Portfolio Details Section -->
@endsection
