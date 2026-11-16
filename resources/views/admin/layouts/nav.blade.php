<nav class="topnav navbar navbar-light">
    <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
    </button>
    <span class="navbar-brand ml-2" style="font-size:.82rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase; color:var(--text-2)">PrintShop <span style="color:var(--brand-2)">Admin</span></span>
    <ul class="nav">
        <li class="nav-item nav-notif">
            <a class="nav-link my-2" href="{{ route('orders.index') }}" aria-label="Orders needing attention">
                <span class="fe fe-bell fe-16"></span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink"
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="avatar avatar-sm mt-2">
                    <img src="{{ asset('admin/assets/avatars/face-1.jpg')}}" alt="..." class="avatar-img rounded-circle">
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{ route('admins.index') }}">Admins</a>
                <a class="dropdown-item" href="{{ url('/') }}" target="_blank" rel="noopener">View site <i class="fe fe-external-link fe-12"></i></a>
                <a class="dropdown-item" href="{{ route('adminLogout') }}"
                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('adminLogout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
