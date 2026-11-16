@extends('layouts.app')

@section('content')
    <section class="ps-page-band">
        <div class="ps-container">
            <p class="ps-breadcrumb"><a href="{{ url('/') }}">Home</a> / <a href="{{ route('catalog') }}">Catalog</a> / Cart</p>
            <h1>Your <em style="font-style:italic;color:var(--brand-3)">cart</em></h1>
        </div>
    </section>

    <section class="ps-section" style="padding-top:2rem">
        <div class="ps-container">
            @if (session()->has('message'))<div class="alert alert-success">{{ session('message') }}</div>@endif
            @if (count($errors) > 0)
                <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            @if (count($products) === 0)
                <div class="ps-newsletter" style="text-align:center; padding:4rem 2rem">
                    <i class="bi bi-bag" style="font-size:2.4rem; color:var(--brand-2)"></i>
                    <h2 class="ps-heading" style="font-size:1.6rem; margin-top:.8rem">Your cart is empty</h2>
                    <p class="ps-lead" style="margin-inline:auto">Find something worth wearing.</p>
                    <a href="{{ route('catalog') }}" class="ps-btn" style="margin-top:1rem">Browse the catalog <i class="bi bi-arrow-right"></i></a>
                </div>
            @else
                <div class="row gy-4">
                    <!-- Items -->
                    <div class="col-lg-7">
                        <div class="d-flex flex-column gap-3">
                            @foreach ($products as $cartKey => $product)
                                <form action="{{ route('updateCart', $product['image_id']) }}" method="POST" class="ps-cart-item">
                                    @csrf
                                    <img class="ps-cart-item__img" src="{{ asset('storage/img/products/' . $product['thumbnail']) }}" alt="{{ $product['product_name'] }}">
                                    <div>
                                        <p style="font-weight:700; color:var(--text); margin-bottom:.15rem">{{ $product['product_name'] }}</p>
                                        <p style="color:var(--text-3); font-size:.78rem; margin-bottom:.6rem">{{ Str::limit($product['product_desc'] ?? '', 60) }}</p>
                                        <div class="d-flex gap-2 align-items-center flex-wrap">
                                            <label class="visually-hidden" for="color_{{ $loop->index }}">Color</label>
                                            <select id="color_{{ $loop->index }}" name="color" class="form-select" style="width:auto;padding:.4rem .6rem;font-size:.82rem">
                                                <option selected>{{ $product['color'] }}</option>
                                                @foreach ($colors as $colorOption)
                                                    @if ($colorOption->name !== $product['color'])<option value="{{ $colorOption->name }}">{{ $colorOption->name }}</option>@endif
                                                @endforeach
                                            </select>
                                            <label class="visually-hidden" for="size_{{ $loop->index }}">Size</label>
                                            <select id="size_{{ $loop->index }}" name="size" class="form-select" style="width:auto;padding:.4rem .6rem;font-size:.82rem">
                                                @foreach ($sizes as $sizeOption)
                                                    <option value="{{ $sizeOption->id }}" {{ $sizeOption->id == $product['size'] ? 'selected' : '' }}>{{ $sizeOption->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="number" class="form-control" value="{{ $product['qty'] }}" name="quantity" readonly hidden>
                                            <input type="hidden" name="original_size" value="{{ $product['size'] }}">
                                            <input type="hidden" name="original_color" value="{{ $product['color'] }}">
                                            <button type="submit" class="ps-btn ps-btn--ghost" style="padding:.35rem .8rem; font-size:.75rem; box-shadow:none">Update</button>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <p class="ps-price" style="font-size:1rem">KSh {{ number_format($product['price']) }}</p>
                                        <div class="d-flex gap-2 align-items-center justify-content-end mt-2">
                                            <a href="{{ route('reduceCart', ['key' => $cartKey]) }}" class="ps-icon-btn" aria-label="Reduce quantity" style="width:32px;height:32px;border:1px solid var(--border)"><i class="bi bi-dash"></i></a>
                                            <span style="min-width:24px; text-align:center; font-weight:700">{{ $product['qty'] }}</span>
                                            <a href="{{ route('increaseCart', ['key' => $cartKey]) }}" class="ps-icon-btn" aria-label="Increase quantity" style="width:32px;height:32px;border:1px solid var(--border)"><i class="bi bi-plus"></i></a>
                                            <a href="{{ route('deleteCart', ['key' => $cartKey]) }}" class="ps-icon-btn" aria-label="Remove item" style="width:32px;height:32px;border:1px solid transparent;color:var(--danger)"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                        </div>
                        <a href="{{ route('catalog') }}" class="ps-btn ps-btn--ghost" style="margin-top:1.2rem; box-shadow:none"><i class="bi bi-arrow-left"></i> Continue shopping</a>
                    </div>

                    <!-- Summary -->
                    <div class="col-lg-5">
                        <div class="ps-summary">
                            <h2 style="font-size:1.15rem; margin-bottom:1rem">Order summary</h2>
                            <div class="ps-summary__row"><span>Subtotal</span><span>KSh {{ number_format($totalPrice) }}</span></div>
                            <div class="ps-summary__row"><span>Shipping</span><span>KSh {{ number_format($shipping) }}</span></div>
                            <div class="ps-summary__row ps-summary__row--total"><span>Total</span><span>KSh {{ number_format($totalPrice + $shipping) }}</span></div>

                            @if ($availablePromo && $userCanUsePromo)
                                <form action="{{ route('promo.apply') }}" method="POST" style="display:flex; gap:.5rem; margin:1rem 0">
                                    @csrf
                                    <input name="code" type="text" class="form-control" placeholder="Promo code" autocomplete="off" aria-label="Promo code" style="text-transform:uppercase">
                                    <button type="submit" class="ps-btn" style="padding:.6rem 1rem">Apply</button>
                                </form>
                            @endif
                            @if (Session::get('applied_promo'))
                                <p style="color:var(--ok); font-size:.85rem; margin:0 0 .8rem"><i class="bi bi-check-circle"></i> Promo <strong>{{ Session::get('applied_promo') }}</strong> applied.</p>
                            @endif

                            <form action="{{ route('postCheckout', ['id' => $products[array_key_first($products)]['image_id']]) }}" method="POST">
                                @csrf
                                <label class="form-label" for="phoneInput">M-Pesa number (254…)</label>
                                <input id="phoneInput" name="phone" type="tel" class="form-control" placeholder="254712345678" pattern="254[0-9]{9}" title="254 followed by 9 digits" required>

                                @foreach ($products as $product)
                                    <input name="price" type="hidden" value="{{ $product['price'] }}">
                                    <input name="qntty" type="hidden" value="{{ $product['qty'] }}">
                                    <input name="pID" type="hidden" value="{{ $product['image_id'] }}">
                                    <input name="color" type="hidden" value="{{ $product['color_id'] }}">
                                    <input name="size" type="hidden" value="{{ $product['size'] }}">
                                @endforeach
                                <input name="total" type="hidden" value="{{ $totalPrice + $shipping }}">

                                <p style="font-size:.78rem; color:var(--text-3); margin:.9rem 0 .2rem">Lipa na M-Pesa · Buy Goods · Till <strong style="color:var(--text)">9030355</strong> · Javan Kush Enterprises</p>
                                <button type="submit" class="ps-btn" style="width:100%; justify-content:center; margin-top:.7rem"><i class="bi bi-phone"></i> Pay with M-Pesa</button>
                            </form>

                            <p style="font-size:.75rem; color:var(--text-3); margin-top:.8rem"><i class="bi bi-shield-check"></i> Your number is used once for the STK push fee and never stored on a server we don't control.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
