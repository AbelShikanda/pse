@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h3 mb-4 page-title">user Details</h2>
                <div class="row mt-5 align-items-center">
                    <div class="col-md-3 text-center mb-5">
                        <div class="avatar avatar-xl">
                            <img src="./assets/avatars/face-1.jpg" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </div>
                    <div class="col">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-md-6">
                                <h4 class="mb-1">{{ $user->first_name }} {{ $user->last_name }}</h4>
                                <p class="small mb-3"><span class="badge badge-dark">Created on:
                                        {{ $user->created_at }}</span></p>
                                <div class="">
                                    <p class="text-muted">
                                        @if ($user->email_verified_at)
                                            <p>user verified</p>
                                        @else
                                            <p>user not verified</p>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                        </div>
                    </div>
                </div>
                <br>
                <br>
                @if ($user->count() > 0)
                    <h3>About user</h3>
                    <p class="text-muted">This is a desctiption about {{ $user->first_name }}.</p>
                    <div class="card-deck my-4">
                        <div class="card mb-4">
                            <div class="card-body text-center my-4">
                                <span class="h1 mb-0">{{ $user->first_name }} {{ $user->last_name }}</span>
                                <a href="#">
                                    <h3 class="h5 mt-4 mb-0">{{ $user->email }}</h3>
                                </a>
                                <a href="#">
                                    <h3 class="h5 mt-4 mb-0">{{ $user->phone }}</h3>
                                </a>
                                <p class="text-muted">

                                    @if ($user->email_verified_at)
                                        <p>user verified</p>
                                    @else
                                        <p>user not verified</p>
                                    @endif
                                </p>
                                <p class="text-muted">{{ $user->gender }}</p>
                                <p class="text-muted">From {{ $user->location }}</p>
                                <p class="text-muted">In {{ $user->town }}</p>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .card-group -->
                @endif
                <br>
                <br>
                @if ($user->order->count() > 0)
                    <h3>User Orders</h3>
                    <p class="text-muted">these are orders made by: {{ $user->first_name }}.</p>
                    <table class="table table-borderless table-striped">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Product</th>
                                <th>Reference</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->order as $orders)
                                <tr>
                                    <th scope="col">{{ $orders->id }}</th>
                                    <td>
                                        @foreach ($orders->orderItems as $item)
                                            {{ $item->products->name }}
                                        @endforeach
                                    </td>
                                    <td>{{ $orders->reference }}</td>
                                    <td>{{ $orders->price }}</td>
                                    <td>
                                        @if ($orders->complete == 1)
                                            <span class="badge badge-pill badge-success mr-2">S</span>
                                            <small class="text-muted">Paid</small>
                                        @else
                                            <span class="badge badge-pill badge-danger mr-2">X</span>
<<<<<<< HEAD
                                            <small class="text-muted">Unconfirmed</small>
=======
                                            <small class="text-muted">Unconformed</small>
>>>>>>> 13b75d815679ffd73381c0dfde26250cc365014e
                                        @endif
                                    </td>
                                    <td>{{ $orders->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <br>
                <br>
                @if ($user->comments->count() > 0)
                    <h3>User Comments</h3>
                    <p class="text-muted">these are comments made by: {{ $user->first_name }}.</p>
                    <table class="table table-borderless table-striped">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Blog</th>
                                <th>Comment</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->comments as $comment)
                                <tr>
                                    <th scope="col">{{ $comment->id }}</th>
                                    <td>
                                        {{ $comment->blog->title }}
                                    </td>
                                    <td>{{ $comment->content }}</td>
                                    <td>{{ $comment->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <br>
                <br>
                @if ($user->ratings->count() > 0)
                <h3>User Ratings</h3>
                <p class="text-muted">these are ratings made by: {{ $user->first_name }}.</p>
                <table class="table table-borderless table-striped">
                    <thead>
                        <tr role="row">
                            <th>#</th>
                            <th>Product</th>
                            <th>Rating</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->ratings as $rating)
                            <tr>
                                <th scope="col">{{ $rating->id }}</th>
                                <td>
                                    {{ $rating->product }}
                                </td>
                                <td>{{ $rating->rating }}</td>
                                <td>{{ $rating->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div> <!-- /.col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
@endsection
