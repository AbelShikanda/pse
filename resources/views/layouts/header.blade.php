<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

        <a href="{{ url('/') }}" class="logo"><img src="{{ asset('assets/img/logo.png') }}" alt=""
                class="img-fluid"></a>
        <h1 class="logo"><a href="{{ url('/') }}">PrintShop</a></h1>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                </li>
                <li><a class="nav-link {{ request()->is('catalog') ? 'active' : '' }}"
                        href="{{ url('/catalog') }}">Catalog</a></li>
                <li><a class="nav-link {{ request()->is('blog') ? 'active' : '' }}" href="{{ url('/blog') }}">Stories</a>
                </li>
                <li><a class="nav-link {{ request()->is('contacts') ? 'active' : '' }}"
                        href="{{ url('/contacts') }}">Contact</a></li>
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('login') ? 'active' : '' }}"
                                href="{{ route('underConstruction') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('register') ? 'active' : '' }}"
                                href="{{ route('underConstruction') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->first_name }}
                        </a>
                        <ul>
                            <li><a href="{{ route('profile') }}">Profile</a></li>
                            <li class="">
                                <a href="{{ route('cart') }}">
                                        {{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }}
                                    Cart
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->
