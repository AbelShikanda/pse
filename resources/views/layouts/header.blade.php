<header id="psHeader" class="ps-header">
    <div class="ps-header__inner">
        <a href="{{ url('/') }}" class="ps-brand" aria-label="PrintShopEld home">
            <img src="{{ asset('assets/img/logo.png') }}" alt="PrintShopEld logo">
            <span>PrintShop<small>Bespoke Print &amp; Embroidery</small></span>
        </a>

        <nav aria-label="Primary">
            <ul class="ps-nav">
                <li><a class="ps-nav__link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a></li>
                <li><a class="ps-nav__link {{ request()->is('catalog*') ? 'active' : '' }}" href="{{ route('catalog') }}">Catalog</a></li>
                <li><a class="ps-nav__link {{ request()->is('blog*') ? 'active' : '' }}" href="{{ url('/blog') }}">Stories</a></li>
                <li><a class="ps-nav__link {{ request()->is('contacts') ? 'active' : '' }}" href="{{ url('/contacts') }}">Contact</a></li>
            </ul>
        </nav>

        <div class="ps-header__actions">
            <a href="{{ route('cart') }}" class="ps-icon-btn" aria-label="Cart ({{ Session::has('cart') ? Session::get('cart')->totalQty : 0 }} items)">
                <i class="bi bi-bag"></i>
                @if (Session::has('cart') && Session::get('cart')->totalQty > 0)
                    <span class="ps-cart-count">{{ Session::get('cart')->totalQty }}</span>
                @endif
            </a>

            @guest
                <a href="{{ route('login') }}" class="ps-btn ps-btn--ghost d-none d-md-inline-flex" style="padding:.55rem 1.1rem">Sign in</a>
            @else
                <div class="ps-account-menu" id="psAccountMenu">
                    <button type="button" class="ps-icon-btn" id="psAccountToggle" aria-expanded="false" aria-controls="psAccountPanel" aria-haspopup="true">
                        <i class="bi bi-person"></i>
                    </button>
                    <div class="ps-account-menu__panel" id="psAccountPanel" role="menu">
                        <div class="ps-account-menu__header">Signed in as<strong>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</strong><span style="font-size:.75rem">{{ Auth::user()->email }}</span></div>
                        <div class="ps-account-menu__divider"></div>
                        <a class="ps-account-menu__item" role="menuitem" href="{{ route('profile.index') }}"><i class="bi bi-grid"></i> Account &amp; orders</a>
                        <a class="ps-account-menu__item" role="menuitem" href="{{ route('profile.edit') }}"><i class="bi bi-person-gear"></i> Edit profile</a>
                        <a class="ps-account-menu__item" role="menuitem" href="{{ route('cart') }}"><i class="bi bi-bag"></i> View cart</a>
                        <div class="ps-account-menu__divider"></div>
                        <a class="ps-account-menu__item" role="menuitem" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('psLogoutForm').submit();"><i class="bi bi-box-arrow-right"></i> Sign out</a>
                        <form id="psLogoutForm" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                </div>
            @endguest

            <button class="ps-burger" id="psBurger" aria-label="Toggle menu" aria-expanded="false" aria-controls="psMobileNav"><i class="bi bi-list"></i></button>
        </div>
    </div>

    <div class="ps-mobile-nav" id="psMobileNav">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ route('catalog') }}">Catalog</a>
        <a href="{{ url('/blog') }}">Stories</a>
        <a href="{{ url('/contacts') }}">Contact</a>
        @guest
            <a href="{{ route('login') }}" class="ps-mobile-nav__cta">Sign in</a>
        @else
            <a href="{{ route('profile.index') }}">My account</a>
        @endguest
    </div>
</header>
