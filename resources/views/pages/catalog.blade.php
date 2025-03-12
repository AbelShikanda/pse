@extends('layouts.app')

@section('content')
    @include('layouts.hero_single')
    <br>
    <br>
    <br>
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

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
        <div class="container">
            <div class="d-flex justify-content-center mb-5 py-5">
                <div class="row align-items-center justify-content-center w-100 col-lg-8 text-center">

                    <!-- Dropdown (Select Category) -->
                    <div class="col-md-4 pb-2">
                        <div class="dropdown w-100">
                            <button class="btn btn-outline-secondary dropdown-toggle py-2 w-100 home_btn" type="button"
                                id="shopDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Select Category
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="shopDropdown">
                                <li><a class="dropdown-item" href="{{ route('catalog') }}">All</a></li>
                                @foreach ($categories as $category)
                                    <li><a class="dropdown-item"
                                            href="{{ route('catalog.category', ['slug' => $category->slug]) }}">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Search Bar & Like Button -->
                    <div class="col-md-6">
                        <div class="input-group justify-content-center flex-wrap">
                            <input type="text" class="form-control py-2 w-50" placeholder="Search..." aria-label="Search"
                                id="search-transparent">
                            <button class="btn btn-outline-secondary px-3" type="button" id="searchButton">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Images Grid -->
            <div class="row">
                @foreach ($images as $item)
                    <div class="mb-5 col-6 col-md-6 col-lg-4">
                        @include('layouts.partials.catalog')
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Portfolio Details Section -->
    <div class="d-flex justify-content-center">
        {{ $images->links() }}
    </div>


    <br>
    <br>
    <br>
    <!-- <script>
        document.getElementById('searchButton').addEventListener('click', function() {
            let query = document.getElementById('searchInput').value.toLowerCase();
            let items = document.querySelectorAll('.portfolio-details .row .col-lg-4');

            items.forEach(item => {
                let text = item.innerText.toLowerCase();
                item.style.display = text.includes(query) ? 'block' : 'none';
            });
        });

        document.getElementById('likeButton').addEventListener('click', function() {
            alert('You liked this!');
        });
    </script> -->


@endsection
