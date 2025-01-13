<div class="blog-card rupauls13"
    style="background: url('{{ asset('storage/img/blogs/' . $blog->thumbnail) }}'); background-size: cover; background-position: center; height: 100hv;">
    <div class="title-blog">
        <h3>{{ $blog->full }}</h3>
        <hr />
        {{-- <div class="intro">STRAIGHT OUTTA OZ: THE MUSICAL</div> --}}
    </div><!--/.title-content-->
    <div class="card-info">
        @foreach ($blog->blogs as $item)
            {{ Str::words($item->body, 7, '...') }}
        @endforeach
    </div><!--/.card-info-->
    <div class="utility-info">
        <ul class="utility-list">
            @foreach ($blog->blogs as $item)
                <li class="date">
                    @php
                        $createdDate = $item->created_at;
                        $now = \Carbon\Carbon::now();
                        $diffInDays = $createdDate->diffInDays($now);
                        $diffInYears = $createdDate->diffInYears($now);
                    @endphp

                    @if ($diffInDays < 7)
                        {{ $createdDate->diffForHumans() }}
                    @elseif ($diffInYears < 1)
                        {{ $createdDate->format('d M, H:i') }}
                    @else
                        {{ $createdDate->format('d M Y, H:i') }}
                    @endif
                </li>
            @endforeach
            <li><a href="{{ route('blogSingle', $blog->blogs[0]->slug) }}"><i
                        class="bi bi-arrow-right-circle-fill px-2"></i>More</a></li>
        </ul>
    </div><!--/.utility-info-->
    <!--overlays-->
    <div class="gradient-overlay"></div>
    <div class="color-overlay"></div>
</div><!--/.blog-card closure-->
