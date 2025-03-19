<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ route('dashboard.index') }}">
                <img src="{{ asset('admin/assets/images/logo.png') }}" alt="logo" class="w-50">
            </a>
        </div>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item dropdown">
                <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span><span class="sr-only">(current)</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="dashboard">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('dashboard.index') }}"><span
                                class="ml-1 item-text">Home</span></a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('schedules') }}"><span
                                class="ml-1 item-text">schedule</span></a>
                    </li> --}}
                </ul>
            </li>
        </ul>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Orders Components</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item dropdown">
                <a href="#ui-elements" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-box fe-16"></i>
                    <span class="ml-3 item-text">Orders</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="ui-elements">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('orders.index') }}"><span class="ml-1 item-text">Order</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#forms" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-credit-card fe-16"></i>
                    <span class="ml-3 item-text">Catalog Components</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="forms">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('products.index') }}"><span
                                class="ml-1 item-text">Products</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('product_categories.index') }}"><span
                                class="ml-1 item-text">Categories</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('sizes.index') }}"><span
                                class="ml-1 item-text">Size</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('colors.index') }}"><span 
                            class="ml-1 item-text">Color</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('materials.index') }}"><span
                                class="ml-1 item-text">Material</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('types.index') }}"><span 
                            class="ml-1 item-text">Type</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('product_images.index') }}"><span
                                class="ml-1 item-text">Images</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('prices.index') }}"><span
                                class="ml-1 item-text">Prices</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('ratings.index') }}"><span
                                class="ml-1 item-text">Ratings</span></a>
                    </li>
                </ul>
            </li>
        </ul>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>User Components</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item dropdown">
                <a href="#charts" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-pie-chart fe-16"></i>
                    <span class="ml-3 item-text">User Components</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="charts">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('users.index') }}"><span
                                class="ml-1 item-text">Users</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('contact.index') }}"><span
                                class="ml-1 item-text">Contacts</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('admins.index') }}"><span
                                class="ml-1 item-text">Admins</span></a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#chart" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-pie-chart fe-16"></i>
                    <span class="ml-3 item-text">User Management</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="chart">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('roles.index') }}"><span
                                class="ml-1 item-text">Roles</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('permissions.index') }}"><span
                                class="ml-1 item-text">Permissions</span></a>
                    </li>
                </ul>
            </li>
        </ul>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Blog Components</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">

            <li class="nav-item dropdown">
                <a href="#tables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-3 item-text">Blog Components</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="tables">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('blogs.index') }}"><span
                                class="ml-1 item-text">Articles</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('blog_categories.index') }}"><span
                                class="ml-1 item-text">Categories</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('blog_images.index') }}"><span
                                class="ml-1 item-text">Images</span></a>
                    </li>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('comment.index') }}"><span
                                class="ml-1 item-text">Comments</span></a>
                    </li>
                </ul>
            </li>
        </ul>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Promo Codes Components</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">

            <li class="nav-item dropdown">
                <a href="#table" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-3 item-text">Promotion Codes</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="table">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('promo.index') }}"><span
                                class="ml-1 item-text">Promo Codes</span></a>
                    </li>
                </ul>
            </li>
        </ul>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Review Tokens Components</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">

            <li class="nav-item dropdown">
                <a href="#Review" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-3 item-text">Review Tokens</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="Review">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('review_tokens.index') }}"><span
                                class="ml-1 item-text">Tokens</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('review.index') }}"><span
                                class="ml-1 item-text">Reviews</span></a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>
