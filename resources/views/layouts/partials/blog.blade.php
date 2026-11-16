@php $post = $blog->blogs[0] ?? null; @endphp
@if ($post)
<a href="{{ route('blogSingle', $post->slug) }}" style="text-decoration:none">
    <article class="ps-blog-card" data-reveal>
        <div class="ps-blog-card__media" style="background-image:url('{{ asset('storage/img/blogs/' . $blog->thumbnail) }}')"><span class="ps-blog-card__tag">Studio notes</span></div>
        <div class="ps-blog-card__body">
            <h3 class="ps-blog-card__title">{{ $post->title }}</h3>
            <p class="ps-blog-card__excerpt">{{ Str::limit(strip_tags($post->body), 120) }}</p>
            <span style="color:var(--text-3); font-size:.78rem">{{ $post->created_at->diffForHumans() }}</span>
        </div>
    </article>
</a>
@endif
