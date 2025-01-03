<div class="box"
    style="background: url('{{ asset('storage/img/products/' . $item->thumbnail) }}'); background-size: cover; background-position: center;">
    <div class="overlay">
        <div class = "items"></div>
        <div class = "items head">
            <p>{{ $item->products[0]->name }}</p>
            <hr>
        </div>
        <div class = "items price">
            <p class="old">Ksh {{ $item->products[0]->price}}</p>
            <p class="new">Ksh {{ $item->products[0]->price * 0.9 }}</p>
        </div>
        <div class="items cart">
            <i class="bi bi-view-list"></i>
            <a href="{{ route('catalogDetail', $item->products[0]->slug) }}"><span>VIEW</span></a>
            <br><br>
            <i class="bi bi-cart"></i>
            <a href="{{ route('addToCart', $item->id) }}"><span>ADD TO CART</span></a>
        </div>
    </div>
</div>
