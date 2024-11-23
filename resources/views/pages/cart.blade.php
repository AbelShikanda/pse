@extends('layouts.app')

@section('content')
    @include('layouts.hero_single')

    <!-- ======= Blog Single Section ======= -->
    <section class="blog-wrapper sect-pt4" id="blog">
        <section class="cart_wrapper">
            <div class="cart_lists">
                <div class="cart_title">
                    <span class="material-icons-outlined">local_mall</span>
                    Your Shopping Cart
                </div>
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif

                <div class="cart_list_wrap">
                    @if (count($products) > 0)
                        @foreach ($products as $product)
                            <div class="cart_responsive">

                                <form action="{{ route('updateCart', $product['item']['id']) }}"method="POST">
                                    @csrf
                                    <div class="tr_item">
                                        <div class="td_item item_img">
                                            <img src="{{ asset('storage/img/products/' . $product['item']['thumbnail']) }}"
                                                alt="" />
                                        </div>
                                        @foreach ($product['item']['products'] as $prod)
                                            <div class="td_item item_name">
                                                <label class="main">{{ Str::words($prod['name'], 2, '...') }}</label>
                                                <label
                                                    class="sub">{{ Str::words($prod['description'], 3, '...') }}</label>
                                            </div>
                                            @foreach ($prod['color'] as $color)
                                                <div class="td_item item_color">
                                                    <select name="color">
                                                        <option selected>
                                                            {{ $color['name'] }}
                                                        </option>
                                                        <option value="black">black</option>
                                                        <option value="white">white</option>
                                                        <option value="grey">grey</option>
                                                    </select>
                                                </div>
                                            @endforeach
                                            @foreach ($prod['size'] as $size)
                                                <div class="td_item item_size">
                                                    <select name="size">
                                                        <option selected>
                                                            {{ $size['name'] }}
                                                        </option>
                                                        <option value="small">small</option>
                                                        <option value="large">large</option>
                                                        <option value="Xlarge">Xlarge</option>
                                                    </select>
                                                </div>
                                            @endforeach
                                        @endforeach
                                        <div class="td_item item_actions">
                                            <span>
                                                <button type="submit" class="btn btn-light"
                                                    style="background-color: transparent; border: none;">
                                                    <i class="bi bi-cart3"></i>
                                                    <p>update</p>
                                                </button>
                                            </span>
                                        </div>
                                </form>
                                <div class="td_item item_like">
                                    <form method="post" action="{{ route('wishlist', $product['item']['id']) }}">
                                        @csrf
                                        @method('post')
                                        <span class="material-icons-outlined">
                                            <input name="product_id" type="text"
                                                value="{{ $product['item']['id'] }}" readonly hidden>
                                            <button class="btn btn-transparent" type="submit">
                                                <i class="bi bi-heart-fill"></i>
                                            </button>
                                        </span>
                                    </form>
                                </div>
                                <div class="td_item item_qty">
                                    <div class="quantity">
                                        <a href="{{ route('reduceCart', ['id' => $product['item']['id']]) }}" class="minus"
                                            aria-label="Decrease">&minus;</a>
                                        <input type="number" class="input-box" value="{{ $product['qty'] }}"
                                            min="1" max="10" readonly>
                                        <a href="{{ route('addToCart', ['id' => $product['item']['id']]) }}" class="plus"
                                            aria-label="Increase">&plus;</a>
                                    </div>
                                </div>
                                <div class="td_item item_price">
                                    <label>Ksh. {{ $product['item']['products']['0']['price'] }}</label>
                                </div>
                                <div class="td_item item_remove">
                                    <span class="material-icons-outlined">
                                        <a href="{{ route('deleteCart', ['id' => $product['item']['id']]) }}">
                                            <i class="bi bi-x"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="footer">
                    <div class="back_cart">
                        <a href="{{ route('catalog') }}">
                            <span class="material-icons-outlined">west</span>
                            Back to Shop
                        </a>
                    </div>
                    <div class="subtotal">
                        <label>Total: </label>
                        <strong>Ksh {{ $totalPrice }}</strong>
                        <br>
                        <label>Shipping: </label>
                        <strong>Ksh {{ $shipping }}</strong>
                        <br>
                        <label>Subtotal: </label>
                        <strong>Ksh {{ $totalPrice + $shipping }}</strong>
                    </div>
                </div>
            </div>
        </section>
        <section class="cart_wrapper">
            <div class="cart_details">
                <div class="cart_title">
                    Cart Details
                </div>
                <div class="form_row">
                    <div class="form_group">
                        @foreach ($products as $product)
                            <form action="{{ route('postCheckout', ['id' => $product['item']['id']]) }}" method="POST">
                        @endforeach
                        @csrf
                        <div class="subtotal">
                            <label>Total: </label>
                            <strong>Ksh {{ $totalPrice }}</strong>
                            <br>
                            <label>Shipping: </label>
                            <strong>Ksh {{ $shipping }}</strong>
                            <br>
                            <br>
                            <br>
                            <div>Lipa Na Mpesa</div>
                            <div>Buy Goods</div>
                            <div>Till: <span> 9030355 </span></div>
                            <div>Name: <span> Javan Kush Enterprises </span></div>
                            <label>Subtotal: </label>
                            <strong class="text-success">Ksh {{ $totalPrice + $shipping }}</strong>
                            <div class="form-group">
                                <label class="col-form-label" for="inputSuccess"><i class="fas fa-check"></i> Your M-pesa
                                    Reference Number</label>
                                <input name="mpesa_ref" type="text" value="" class="form-control is-valid"
                                    id="inputSuccess">

                                @foreach ($products as $product)
                                    <input name="price" type="text" class="form-control" id=""
                                        value="{{ $product['item']['products']['0']['price'] }}" readonly hidden>
                                    <input name="qntty" type="text" class="form-control" id=""
                                        value="{{ $product['qty'] }}" readonly hidden>
                                    <input name="pID" type="text" class="form-control" id=""
                                        value="{{ $product['item']['id'] }}" readonly hidden>
                                    <input name="color" type="text" class="form-control" id=""
                                        value="{{ $product['item']['products']['0']['color']['0']['id'] }}" readonly
                                        hidden>
                                    <input name="size" type="text" class="form-control" id=""
                                        value="{{ $product['item']['products']['0']['size']['0']['id'] }}" readonly
                                        hidden>
                                @endforeach

                                <input name="total" type="text" class="form-control" id=""
                                    value="{{ $totalPrice + $shipping }}" readonly hidden>
                            </div>
                            <br>
                            <br>
                            <br>
                        </div>
                    </div>

                    <button type="submit" class="btn">Checkout</button>
                    </form>
                </div>
            </div>
        </section>
        </div>
    </section><!-- End Blog Single Section -->

@endsection
