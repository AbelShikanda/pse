@extends('layouts.app')

@section('content')
    <div class="ps-container" style="padding: calc(var(--header-h) + 2rem) 0 3rem; max-width: 880px">
        @if (count($errors) > 0)
            <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        @if (session()->has('message'))<div class="alert alert-success">{{ session('message') }}</div>@endif

        <p class="ps-breadcrumb"><a href="{{ url('/blog') }}">Stories</a> / {{ Str::limit($blog->title, 40) }}</p>
        <div class="ps-pdp__meta" style="margin-bottom:.4rem">
            @foreach ($blog->blogCategories as $category){{ $category->name }}@if (!$loop->last) · @endif @endforeach · {{ $blog->created_at->format('d M Y') }}
        </div>
        <h1 class="ps-pdp__name" style="margin-top:0">{{ $blog->title }}</h1>

        @if ($blog->BlogImage->count())
            <figure style="margin:1.5rem 0 2rem">
                <img src="{{ asset('storage/img/blogs/' . $blog->BlogImage[0]->thumbnail) }}" alt="{{ $blog->BlogImage[0]->full }}" class="img-fluid" style="border-radius:var(--r-lg); border:1px solid var(--border); width:100%; object-fit:cover; max-height:480px">
            </figure>
        @endif

        <div class="article-content" style="color:var(--text-2); font-size:1.02rem; line-height:1.8">
            {!! $blog->body !!}
            <blockquote style="border-left:3px solid var(--brand); padding-left:1.2rem; font-family:var(--font-serif); font-style:italic; color:var(--text); margin:1.5rem 0">{{ $blog->sub_title }}</blockquote>
        </div>

        <hr style="border-color:var(--border); margin:2.5rem 0 1.5rem">
        <div class="d-flex align-items-center justify-content-between" style="margin-bottom:1.2rem">
            <h2 style="font-size:1.3rem">Comments ({{ $blog->comments->count() }})</h2>
        </div>
        @forelse ($blog->comments as $comment)
            <div style="display:flex; gap:.8rem; padding:1rem 0; border-bottom:1px solid var(--border)">
                <i class="bi bi-person-circle" style="font-size:2rem; color:var(--brand-2)"></i>
                <div>
                    <p style="margin:0; font-weight:700">{{ $comment->user->first_name ?? 'Customer' }} <span style="color:var(--text-3); font-weight:400; font-size:.8rem">· {{ $comment->created_at->diffForHumans() }}</span></p>
                    <p style="margin:.2rem 0 0; color:var(--text-2)">{{ $comment->content }}</p>
                </div>
            </div>
        @empty
            <p style="color:var(--text-3)">Be the first to comment.</p>
        @endforelse

        @auth
            <form action="{{ route('comments') }}" method="POST" style="margin-top:1.5rem">
                @csrf
                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <label class="form-label" for="commentBody">Leave a comment</label>
                <textarea id="commentBody" name="message" class="form-control" rows="3" required placeholder="Share your thoughts..."></textarea>
                <button type="submit" class="ps-btn" style="margin-top:.7rem">Post comment <i class="bi bi-send"></i></button>
            </form>
        @else
            <p style="color:var(--text-2); margin-top:1.2rem"><a href="{{ route('login') }}">Sign in</a> to join the conversation.</p>
        @endauth
    </div>
@endsection
