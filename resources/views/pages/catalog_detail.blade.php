@extends('layouts.app')

@section('content')
    @include('layouts.hero_single')

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger col-md-8 offset-md-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="container-blog mt-5 mb-5">
            <div class="product-image">
                <img src="{{ asset('storage/img/products/' . $product->ProductImage[0]->thumbnail) }}"
                    alt="{{ $product->ProductImage[0]->full }}" class="product-pic">
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
                <form action="{{ route('add.single', $product->ProductImage->first()->id) }}" method="POST">
                    @csrf
                    <div class="controls">
                        <div class="color">
                            <h5>color</h5>
                            <div class="td_item item_color">
                                <select name="color">
                                    <option selected>
                                        {{ $product->color[0]->name }}
                                    </option>
                                    <option value="Navy">Navy</option>
                                    <option value="white">white</option>
                                    <option value="grey">grey</option>
                                </select>
                            </div>
                            <!-- <a href="#!">{{ $product->color[0]->name }}</a> -->
                        </div>
                        <div class="size">
                            <h5>size</h5>
                            <div class="td_item item_size">
                                <select name="size">
                                    @foreach ($allSizes as $size)
                                        <option value="{{ $size->id }}"
                                            @if ($product->Size->contains('id', $size->id) || old('size') == $size->id) selected @endif>
                                            {{ $size->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- <a href="#!">{{ $product->size[0]->name }}</a> -->
                        </div>
                        <div class="qty">
                            <h5>qty</h5>
                            <div class="td_item item_qty">
                                <div class="quantity">
                                    <button class="minus" type="button" aria-label="Decrease">&minus;</button>
                                    <input type="number" class="input-box" name="quantity" value="1" min="1"
                                        max="10" readonly>
                                    <button class="plus" type="button" aria-label="Increase">&plus;</button>
                                </div>
                            </div>
                            <!-- <a href="#!">(1)</a> -->
                        </div>
                    </div>
                    <div class="footer">
                        <button type="submit" class="add-to-cart">
                            <img src="http://co0kie.github.io/codepen/nike-product-page/cart.png" style="width:20px;"
                                alt="">
                            <span>add to cart</span>
                        </button>
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
                </form>
            </div>
        </div>
    </section><!-- End Portfolio Details Section -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const minusButton = document.querySelector(".minus");
            const plusButton = document.querySelector(".plus");
            const inputBox = document.querySelector(".input-box");

            minusButton.addEventListener("click", function() {
                let currentValue = parseInt(inputBox.value, 10);
                if (currentValue > parseInt(inputBox.min, 10)) {
                    inputBox.value = currentValue - 1;
                }
            });

            plusButton.addEventListener("click", function() {
                let currentValue = parseInt(inputBox.value, 10);
                if (currentValue < parseInt(inputBox.max, 10)) {
                    inputBox.value = currentValue + 1;
                }
            });
        });
    </script>
@endsection
