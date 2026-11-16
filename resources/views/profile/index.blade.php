@extends('layouts.app')

@section('content')
    <section class="ps-page-band" style="background:linear-gradient(rgba(17,17,22,.82), rgba(17,17,22,.82)), url('{{ asset('assets/img/header.jpg') }}') center/cover; border:none">
        <div class="ps-container">
            <div class="d-flex align-items-end justify-content-between flex-wrap gap-3">
                <div>
                    <span class="ps-eyebrow">Account</span>
                    <h1 class="ps-heading" style="color:var(--text)">{{ Auth::user()->first_name }} <em>{{ Auth::user()->last_name }}</em></h1>
                    <p class="ps-lead" style="color:var(--text-2)">{{ Auth::user()->email }} · Member since {{ Auth::user()->created_at->format('M Y') }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="ps-btn ps-btn--ghost" style="box-shadow:none"><i class="bi bi-pencil"></i> Edit profile</a>
            </div>
        </div>
    </section>

    <section class="ps-section" style="padding-top:2.5rem">
        <div class="ps-container">
            @if (count($errors) > 0)
                <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif
            @if (session()->has('message'))<div class="alert alert-success">{{ session('message') }}</div>@endif

            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3"><div class="ps-summary" style="text-align:center;padding:1.1rem"><div style="font-size:1.6rem;font-weight:800">{{ $orders->count() }}</div><div style="color:var(--text-3);font-size:.78rem;letter-spacing:.08em;text-transform:uppercase">Orders</div></div></div>
                <div class="col-6 col-md-3"><div class="ps-summary" style="text-align:center;padding:1.1rem"><div style="font-size:1.6rem;font-weight:800">{{ $wishlist->count() }}</div><div style="color:var(--text-3);font-size:.78rem;letter-spacing:.08em;text-transform:uppercase">Wishlist</div></div></div>
                <div class="col-6 col-md-3"><div class="ps-summary" style="text-align:center;padding:1.1rem"><div style="font-size:1.6rem;font-weight:800">{{ $orders->where('complete', 1)->count() }}</div><div style="color:var(--text-3);font-size:.78rem;letter-spacing:.08em;text-transform:uppercase">Delivered</div></div></div>
                <div class="col-6 col-md-3"><div class="ps-summary" style="text-align:center;padding:1.1rem"><div style="font-size:1.6rem;font-weight:800">{{ $ratedItems ? count(array_unique($ratedItems)) : 0 }}</div><div style="color:var(--text-3);font-size:.78rem;letter-spacing:.08em;text-transform:uppercase">Ratings given</div></div></div>
            </div>

            <div class="row gy-4">
                <!-- Orders -->
                <div class="col-lg-7">
                    <h2 style="font-size:1.25rem; margin-bottom:1rem">Purchased products</h2>
                    @if ($orders->isEmpty())
                        <p style="color:var(--text-3)">No orders yet. <a href="{{ route('catalog') }}">Start shopping →</a></p>
                    @else
                        <div class="d-flex flex-column gap-3">
                            @foreach ($orders as $bought)
                                @foreach ($bought->orderItems as $items)
                                    <div class="ps-cart-item" style="grid-template-columns:84px 1fr auto">
                                        <img class="ps-cart-item__img" src="{{ $items->products->ProductImage->first() ? asset('storage/img/products/' . $items->products->ProductImage->first()->thumbnail) : asset('assets/img/logo.png') }}" alt="{{ $items->products->name }}">
                                        <div>
                                            <p style="font-weight:700;color:var(--text);margin:0">{{ Str::limit($items->products->name, 48) }}</p>
                                            <p style="font-size:.8rem;color:var(--text-3);margin:.15rem 0 .4rem">{{ $bought->created_at->format('d M Y') }} · Qty {{ $items->quantity }} · Order #{{ $bought->id }}</p>
                                            @if (!in_array($items->products->id, $ratedItems) && $bought->complete == 1)
                                                <form action="{{ route('ratings.store') }}" method="POST" class="d-flex align-items-center gap-2">
                                                    @csrf
                                                    <input type="hidden" name="productId" value="{{ $items->products->id }}">
                                                    <label style="font-size:.78rem;color:var(--text-2)" for="rating_{{ $items->id }}">Rate</label>
                                                    <select id="rating_{{ $items->id }}" name="rating_{{ $items->id }}" class="form-select" style="width:auto;padding:.3rem .5rem;font-size:.82rem">
                                                        @foreach ([5,4,3,2,1] as $star)<option value="{{ $star }}">{{ str_repeat('★', $star) }}</option>@endforeach
                                                    </select>
                                                    <button type="submit" class="ps-btn ps-btn--ghost" style="padding:.3rem .7rem;font-size:.75rem;box-shadow:none">Submit</button>
                                                </form>
                                            @elseif ($bought->complete == 1)
                                                <span style="color:var(--ok); font-size:.8rem"><i class="bi bi-check-circle"></i> Rated</span>
                                            @endif
                                        </div>
                                        <div class="text-end">
                                            <span class="ps-price" style="font-size:.95rem">KSh {{ number_format($items->price) }}</span>
                                            <div>
                                                @if ($bought->complete == 1)
                                                    <span style="font-size:.72rem; color:var(--ok); letter-spacing:.1em; text-transform:uppercase">Delivered</span>
                                                @else
                                                    <span style="font-size:.72rem; color:var(--warning); letter-spacing:.1em; text-transform:uppercase">Processing</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Wishlist + latest -->
                <div class="col-lg-5">
                    <h2 style="font-size:1.25rem; margin-bottom:1rem">Wishlist</h2>
                    @if ($wishlist->isEmpty())
                        <p style="color:var(--text-3)">Nothing saved yet. Tap the heart on any product.</p>
                    @else
                        <div class="d-flex flex-column gap-2">
                            @foreach ($wishlist as $list)
                                @php $item = $list->products[0] ?? null; @endphp
                                @if ($item)
                                    <div class="ps-cart-item" style="grid-template-columns:64px 1fr auto; padding:.7rem">
                                        <img class="ps-cart-item__img" src="{{ asset('storage/img/products/' . $list->thumbnail) }}" alt="{{ $item->full }}" style="width:64px">
                                        <div>
                                            <a href="{{ route('catalogDetail', $item->slug) }}" style="font-weight:700;color:var(--text)">{{ Str::limit($item->full, 40) }}</a>
                                            <p style="color:var(--text-3); font-size:.8rem; margin:.2rem 0 0">KSh {{ number_format($item->price) }}</p>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('addToCart', $list->id) }}" class="ps-icon-btn" aria-label="Add to cart" style="border:1px solid var(--border)"><i class="bi bi-bag-plus"></i></a>
                                            <form method="post" action="{{ route('deleteWish', $list->id) }}">
                                                @csrf
                                                <input name="product_id" type="hidden" value="{{ $item->id }}">
                                                <button type="submit" class="ps-icon-btn" aria-label="Remove from wishlist" style="border:1px solid transparent;color:var(--danger)"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <h2 style="font-size:1.25rem; margin:1.8rem 0 1rem">Fresh off the line</h2>
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach ($latest as $product)
                            @php $p = $product->products[0] ?? null; @endphp
                            @if ($p)
                                <a href="{{ route('catalogDetail', $p->slug) }}" class="text-decoration-none" style="display:flex;align-items:center;gap:.6rem;border:1px solid var(--border);border-radius:var(--r-md);padding:.55rem .8rem;background:var(--bg-2)">
                                    <img src="{{ asset('storage/img/products/' . $product->thumbnail) }}" alt="{{ $p->full }}" style="width:44px;height:54px;object-fit:cover;border-radius:var(--r-sm)">
                                    <span style="font-size:.82rem;color:var(--text-2)">{{ Str::limit($p->name, 32) }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>

                    <h2 style="font-size:1.25rem; margin:1.8rem 0 1rem">Related picks</h2>
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach ($related as $prod)
                            @php $p = $prod->products[0] ?? null; @endphp
                            @if ($p)
                                <a href="{{ route('catalogDetail', $p->slug) }}" class="text-decoration-none" style="display:flex;align-items:center;gap:.6rem;border:1px solid var(--border);border-radius:var(--r-md);padding:.55rem .8rem;background:var(--bg-2)">
                                    <img src="{{ asset('storage/img/products/' . $prod->thumbnail) }}" alt="{{ $p->full }}" style="width:44px;height:54px;object-fit:cover;border-radius:var(--r-sm)">
                                    <span style="font-size:.82rem;color:var(--text-2)">{{ Str::limit($p->name, 32) }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
