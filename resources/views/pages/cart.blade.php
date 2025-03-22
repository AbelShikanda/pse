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

                @if (count($errors) > 0)
                    <div class="alert alert-danger col-md-8 offset-md-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="cart_list_wrap">
                    @if (count($products) > 0)
                        @foreach ($products as $product)
                            <div class="cart_responsive">

                                <form action="{{ route('updateCart', $product['image_id']) }}"method="POST">
                                    @csrf
                                    <div class="tr_item">
                                        <div class="td_item item_img">
                                            <img src="{{ asset('storage/img/products/' . $product['thumbnail']) }}"
                                                {{-- alt="{{ $product['full'] }}" --}} />
                                        </div>
                                        <div class="td_item item_name">
                                            <label
                                                class="main">{{ Str::words($product['product_name'], 2, '...') }}</label>
                                            <label
                                                class="sub">{{ Str::words($product['product_desc'], 3, '...') }}</label>
                                        </div>
                                        <div class="td_item item_color">
                                            <select name="color">
                                                <option selected>{{ $product['color'] }}</option>
                                                <option value="Black">Black</option>
                                                <option value="White">White</option>
                                                <option value="Grey">Grey</option>
                                                <option value="Navy Blue">Navy Blue</option>
                                            </select>
                                        </div>

                                        <div class="td_item item_size">
                                            <select name="size">
                                                @foreach ($sizes as $s)
                                                    <option value="{{ $s->id }}"
                                                        @if (old('size', is_object($product['size']) ? $product['size'] : $product['size']) == $s->id) selected @endif>
                                                        {{ $s->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="td_item item_actions">
                                            <span>
                                                <button type="submit" class="btn btn-light"
                                                    style="background-color: transparent; border: none;">
                                                    <i class="bi bi-cart3"></i>
                                                    <p>update</p>
                                                </button>
                                            </span>
                                        </div>
                                        <input type="number" class="input-box" value="{{ $product['qty'] }}" name="quantity" readonly hidden>
                                        <input type="hidden" name="original_size" value="{{ $product['size'] }}">
                                        <input type="hidden" name="original_color" value="{{ $product['color'] }}">
                                </form>
                                <div class="td_item item_like">
                                    <form method="post" action="{{ route('wishlist', $product['image_id']) }}">
                                        @csrf
                                        @method('post')
                                        <span class="material-icons-outlined">
                                            <input name="product_id" type="text" value="{{ $product['image_id'] }}"
                                                readonly hidden>
                                            <button class="btn btn-transparent" type="submit">
                                                <i class="bi bi-heart-fill"></i>
                                            </button>
                                        </span>
                                    </form>
                                </div>
                                <div class="td_item item_qty">
                                    <div class="quantity">
                                        @php
                                            $cartKey =
                                                $product['image_id'] . '-' . $product['size'] . '-' . $product['color'];
                                        @endphp
                                        <a href="{{ route('reduceCart', ['key' => $cartKey]) }}" class="minus"
                                            aria-label="Decrease">&minus;</a>
                                        <input type="number" class="input-box" value="{{ $product['qty'] }}"
                                            min="1" max="10" readonly>
                                        <a href="{{ route('increaseCart', ['key' => $cartKey]) }}" class="plus"
                                            aria-label="Increase">&plus;</a>
                                    </div>
                                </div>
                                <div class="td_item item_price">
                                    <label>Ksh. {{ $product['price'] }}</label>
                                </div>
                                <div class="td_item item_remove">
                                    @php
                                        $cartKey =
                                            $product['image_id'] . '-' . $product['size'] . '-' . $product['color'];
                                    @endphp
                                    <span class="material-icons-outlined">
                                        <a href="{{ route('deleteCart', ['key' => $cartKey]) }}">
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
                @if ($availablePromo && $userCanUsePromo)
                    <div>If you can see this</div>
                    <div><a href="https://wa.me/message/UFM7WYYHEIMRA1"><strong class="text-success"> Reach out to get your
                                promo-code </strong></a></div>
                    <form action="{{ route('promo.apply') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="col-form-label" for="inputSuccess">
                                <i class="fas fa-check"></i> Apply promo-code
                            </label>
                            <input name="code" type="text" value="" class="form-control is-valid"
                                id="inputSuccess">
                        </div>
                        <br>
                        <button type="submit" class="apply-btn">Apply</button>
                    </form>
                    <br>
                @endif
                <div class="form_row">
                    <div class="form_group">
                        @foreach ($products as $product)
                            <form action="{{ route('postCheckout', ['id' => $product['image_id']]) }}" method="POST">
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
                                        value="{{ $product['price'] }}" readonly hidden>
                                    <input name="qntty" type="text" class="form-control" id=""
                                        value="{{ $product['qty'] }}" readonly hidden>
                                    <input name="pID" type="text" class="form-control" id=""
                                        value="{{ $product['image_id'] }}" readonly hidden>
                                    <input name="color" type="text" class="form-control" id=""
                                        value="{{ $product['color_id'] }}" readonly hidden>
                                    <input name="size" type="text" class="form-control" id=""
                                        value="{{ $product['size'] }}" readonly hidden>
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
