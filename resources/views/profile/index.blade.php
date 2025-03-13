@extends('layouts.app')

@section('footer')
    {{-- Leave this section empty to exclude the footer --}}
@endsection

@section('content')
    {{-- @include('layouts.hero_profile') --}}
    <!-- ======= Blog Single Section ======= -->
    <br>
    <br>
    <br>

    <section class="content">
        <div class="content__left">

            @include('layouts.partials.profileNav')

        </div>

        <div class="content__middle">

            <div class="artist is-verified">

                <div class="artist__header"
                    style="background-image: url('{{ asset('assets/img/header.jpg') }}'); opacity: 0.5;">

                    <div class="artist__info">

                        <div class="artist__info__meta">

                            <div class="artist__info__type">{{ Auth::user()->email }}</div>

                            <div class="artist__info__name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                            </div>

                            <div class="artist__info__actions">

                                <button class="button-dark">
                                    <a href="{{ route('profile.index') }}" class="text-light">Home</a>
                                </button>

                                <button class="button-light">
                                    <a href="{{ route('profile.edit') }}">Edit</a>
                                </button>

                                <button class="button-light more">
                                    <i class="ion-ios-more"></i>
                                </button>

                            </div>

                        </div>


                    </div>

                    <div class="artist__listeners">

                        {{-- <div class="artist__listeners__count">15,662,810</div>

                        <div class="artist__listeners__label">Monthly Listeners</div> --}}

                    </div>

                    <div class="artist__navigation">



                        <ul class="nav nav-tabs" role="tablist">

                            <li role="presentation" class="active">
                                <a href="#artist-overview" aria-controls="artist-overview" role="tab"
                                    data-toggle="tab">Dashboard</a>
                            </li>

                        </ul>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger col-md-8 offset-md-3">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="pt-3">
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                        </div>

                        <div class="artist__navigation__friends">
                            <div class="artist__listeners__label">{{ Auth::user()->first_name }}
                                {{ Auth::user()->last_name }}</div>

                        </div>

                    </div>

                </div>

                <div class="artist__content">

                    <div class="tab-content">

                        <!-- Overview -->
                        <div role="tabpanel" class="tab-pane active" id="artist-overview">

                            <div class="overview">

                                <div class="overview__artist">

                                    <!-- Latest Release-->
                                    <div class="section-title">Latest Fashon</div>

                                    <div class="latest-release">
                                        @foreach ($latest as $product)
                                            <div class="latest-release__art">

                                                <img src="{{ asset('storage/img/products/' . $product->thumbnail) }}"
                                                    alt="{{ $product->full }}" />

                                            </div>

                                            <div class="latest-release__song">
                                                <div class="latest-release__song__title">{{ $product->full }}</div>

                                                <div class="latest-release__song__date">

                                                    <span>{{ $product->created_at }}</span>

                                                </div>

                                            </div>
                                        @endforeach

                                    </div>
                                    <!-- / -->

                                    <!-- Popular-->
                                    <div class="section-title">Wishlist</div>

                                    <div class="tracks">

                                        @foreach ($wishlist as $list)
                                            <div class="track">

                                                <div class="track__art">

                                                    <img src="{{ asset('storage/img/products/' . $list->thumbnail) }}"
                                                        alt="{{ $list->full }}" />

                                                </div>

                                                <div class="track__title">{{ Str::words($list->full, 1, '...') }}</div>

                                                <div class="track__explicit">

                                                    <span
                                                        class="label">{{ Str::words($list->products['0']->description, 1, '...') }}
                                                    </span>

                                                </div>
                                                @foreach ($list->products as $item)
                                                    <div class="track__plays px-2"><small>{{ $item->price }}</small></div>
                                                @endforeach
                                                <div class="track__plays px-2">
                                                    <div class="">
                                                        <a href="{{ route('addToCart', $list->id) }}"><span>
                                                                <i class="bi bi-cart"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="track__plays">

                                                    <form method="post" action="{{ route('deleteWish', $list->id) }}">
                                                        @csrf
                                                        @method('POST')
                                                        <input name="product_id" type="text" value="{{ $list->id }}"
                                                            readonly hidden>
                                                        <button class="btn btn-transparent text-danger" type="submit">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>

                                                </div>

                                            </div>
                                        @endforeach

                                    </div>

                                    {{-- <button class="show-more button-light">Show 5 More</button> --}}
                                    <!-- / -->

                                </div>

                                <div class="overview__related">

                                    <div class="section-title">Related Fashion</div>

                                    @foreach ($related as $prod)
                                        <div class="related-artists">

                                            <a href="#" class="related-artist">

                                                <span class="related-artist__img">

                                                    <img src="{{ asset('storage/img/products/' . $prod->thumbnail) }}"
                                                        alt="{{ $prod->full }}" />

                                                </span>

                                                <span
                                                    class="related-artist__name">{{ Str::words($prod->full, 2, '...') }}</span>

                                            </a>

                                        </div>
                                    @endforeach

                                </div>

                                <div class="overview__albums">

                                    <div class="overview__albums__head">

                                        <span class="section-title">Purchased Products</span>

                                    </div>

                                    {{-- <div class="album"> --}}

                                    <div class="album__tracks">

                                        <div class="tracks">

                                            <div class="tracks__heading">

                                                <div class="tracks__heading__number">#</div>

                                                <div class="tracks__heading__title">Item</div>

                                                <div class="tracks__heading__length">

                                                    <i class="ion-ios-stopwatch-outline"></i>

                                                </div>

                                                <div class="tracks__heading__popularity">

                                                    <i class="ion-thumbsup"></i>

                                                </div>

                                            </div>

                                            @foreach ($orders as $bought)
                                                @foreach ($bought->orderItems as $items)
                                                    <div class="track">

                                                        <div class="track__number">#</div>

                                                        <div class="track__title">
                                                            {{ Str::words($items->products->name, 2, '...') }}</div>

                                                        <div class="track__explicit">

                                                            <span
                                                                class="label">{{ Str::words($items->products->name, 2, '...') }}</span>

                                                        </div>

                                                        <div class="track__length">

                                                            @if ($bought->complete == 1)
                                                                <span class="badge badge-success"
                                                                    style="background-color: green; color: white;">Success</span>
                                                            @else
                                                                <span class="badge badge-danger"
                                                                    style="background-color: red; color: white;">Pending</span>
                                                            @endif
                                                        </div>
                                                        @if (!in_array($items->products->id, $ratedItems) && $bought->complete == 1)
                                                            <form id="ratingForm_{{ $items->id }}"
                                                                action="{{ route('ratings.store') }}" method="POST">
                                                                @csrf
                                                                @method('post')
                                                                <div class="track__lengthened">
                                                                    <input type="text" name="productId"
                                                                        value="{{ $items->products->id }}" readonly
                                                                        hidden>
                                                                    <div class="container">
                                                                        <div class="rating">
                                                                            <input type="radio"
                                                                                name="rating_{{ $items->id }}"
                                                                                value="5"
                                                                                id="star5_{{ $items->id }}"
                                                                                style="--c: #ff9933" />
                                                                            <input type="radio"
                                                                                name="rating_{{ $items->id }}"
                                                                                value="4"
                                                                                id="star4_{{ $items->id }}"
                                                                                style="--c: #ff9933" />
                                                                            <input type="radio"
                                                                                name="rating_{{ $items->id }}"
                                                                                value="3"
                                                                                id="star3_{{ $items->id }}"
                                                                                style="--c: #ff9933" />
                                                                            <input type="radio"
                                                                                name="rating_{{ $items->id }}"
                                                                                value="2"
                                                                                id="star2_{{ $items->id }}"
                                                                                style="--c: #ff9933" />
                                                                            <input type="radio"
                                                                                name="rating_{{ $items->id }}"
                                                                                value="1"
                                                                                id="star1_{{ $items->id }}"
                                                                                style="--c: #ff9933" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        @else
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
            <!-- / -->

            <!-- Related Artists -->
            <br>
            <br>
            <span class="section-title">More Related Products</span>
            <br>
            <br>

            <div role="tabpanel" class="tab-pane" id="related-artists">

                <div class="media-cards">
                    @foreach ($related as $item)
                        <div class="mb-5 col-6 col-md-6 col-lg-4">
                            @include('layouts.partials.catalog')
                        </div>
                    @endforeach

                </div>

            </div>
            <!-- / -->

            <!-- About // Coming Soon-->
            <!--<div role="tabpanel" class="tab-pane" id="artist-about">About</div>-->
            <!-- / -->

        </div>

        </div>

        </div>

        </div>

    </section>
@endsection
