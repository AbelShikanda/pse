

<div class="hero hero-single route bg-image" style="background-image: url('{{ asset('assets/img/header.jpg') }}')">
    <div class="overlay-mf"></div>
    <div class="hero-content display-table">
        <div class="table-cell">
            <div class="container">
                <h2 class="hero-title mb-4">{{ $pageTitle }}</h2>
                <ol class="breadcrumb d-flex justify-content-center">
                    @foreach ($breadcrumbLinks as $link)
                    <li class="breadcrumb-item">
                        <a href="{{ $link['url'] }}" 
                        class="{{ request()->is($link['url']) ? 'active' : '' }}"
                        >{{ $link['label'] }}</a>
                    </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>