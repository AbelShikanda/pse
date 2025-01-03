@extends('layouts.app')

@section('content')
    @include('layouts.hero_single')

    <!-- ======= Blog Single Section ======= -->
    <section class="blog-wrapper sect-pt4" id="blog">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
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
                    <div class="post-box">
                        <div class="post-meta">
                            <h1 class="article-title text-center">{{ $blog->full }}</h1><br><br>
                            <ul>
                                <li>
                                    <span class="bi bi-person"></span>
                                    <a href="#">Print Shop</a>
                                </li>
                                <li>
                                    <span class="bi bi-tag"></span>
                                    @foreach ($blog->blogCategories as $b)
                                            <a href="#">{{ $b->name }}</a>
                                    @endforeach
                                </li>
                                <li>
                                    <span class="bi bi-chat-left-text"></span>
                                        <a href="#">{{ $blog->created_at }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="post-thumb">
                            <img src="{{ asset('storage/img/blogs/' . $blog->BlogImage[0]->thumbnail) }}" class="img-fluid"
                                alt="">
                        </div><br><br>
                        <div class="article-content">
                                @php
                                    // Define the total length of the content
                                    $totalLength = mb_strlen($blog->body, 'UTF-8');

                                    // Define percentage portions (e.g., 25%, 25%, 10%, 40%)
                                    $firstPortionLength = intval($totalLength * 0.25); // 25%
                                    $secondPortionLength = intval($totalLength * 0.25); // 25%
                                    $thirdPortionLength = intval($totalLength * 0.1); // 10%
                                    $fourthPortionLength = intval($totalLength * 0.4); // 40%

                                    // Extract each portion
                                    $firstPortion = mb_substr($blog->body, 0, $firstPortionLength, 'UTF-8');
                                    $secondPortion = mb_substr(
                                        $blog->body,
                                        $firstPortionLength,
                                        $secondPortionLength,
                                        'UTF-8',
                                    );
                                    $thirdPortion = mb_substr(
                                        $blog->body,
                                        $firstPortionLength + $secondPortionLength,
                                        $thirdPortionLength,
                                        'UTF-8',
                                    );
                                    $fourthPortion = mb_substr(
                                        $blog->body,
                                        $firstPortionLength + $secondPortionLength + $thirdPortionLength,
                                        $fourthPortionLength,
                                        'UTF-8',
                                    );
                                @endphp

                                <section>
                                    <p>{{ $firstPortion }}</p>
                                </section>
                                <section>
                                    <p>{{ $secondPortion }}</p>
                                </section>
                                <section>
                                    <p>{{ $thirdPortion }}</p>
                                </section>
                                <section>
                                    <blockquote class="blockquote">
                                        <p>{{ $blog->sub_title }}</p>
                                    </blockquote>
                                </section>
                                <section>
                                    <p>{{ $fourthPortion }}</p>
                                </section>
                        </div>
                    </div>
                    <div class="box-comments">
                        <hr>
                        <div class="title-box-2">
                                <h4 class="title-comments title-left">comments ({{ $blog->comments->count() }})</h4>
                        </div>
                        <ul class="list-comments">
                            @foreach ($blog->comments as $comment)
                                    <li>
                                        <div class="comment-avatar">
                                            <img src="{{ asset('assets/img/testimonial-4.jpg') }}" alt="">
                                        </div>
                                        <div class="comment-details">
                                            <h4 class="comment-author">{{ $comment->user->first_name }}</h4>
                                            <span>{{ $comment->created_at }}</span>
                                            <p>
                                                {{ $comment->content }}
                                            </p>
                                            {{-- <a href="3">Reply</a> --}}
                                        </div>
                                    </li>
                            @endforeach
                        </ul>
                    </div>
                    @auth
                        <div class="form-comments">
                            <div class="title-box-2">
                                <h3 class="title-left">
                                    Leave a Comment
                                </h3>
                            </div>
                            <form class="form-mf" action="#" method="POST" role="form">
                                @csrf
                                @method('post')
                                <div class="row">
                                    <input type="text" name="user_id" class="form-control input-mf"
                                        value="{{ Auth::user()->id }}" required hidden readonly>
                                    <input type="text" name="blog_id" class="form-control input-mf"
                                        value="{{ $blog->id }}" required hidden readonly>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <textarea id="textMessage" class="form-control input-mf" placeholder="Comment *" name="message" cols="45"
                                                rows="8" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        {{-- <button type="submit" class="button button-a button-big button-rouded">Send
                                            Message</button> --}}

                                        <a class="button button-a button-big button-rouded"
                                            href="{{ route('underConstruction') }}"></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </section><!-- End Blog Single Section -->
@endsection
