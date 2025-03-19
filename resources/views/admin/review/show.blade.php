@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h3 mb-4 page-title">Review Details</h2>
                <div class="row mt-5 align-items-center">
                    <div class="col-md-3 text-center mb-5">
                        <div class="avatar avatar-xl">
                            <img src="{{ asset('assets/avatars/discount-icon.png') }}" alt="Review Icon"
                                class="avatar-img rounded-circle">
                        </div>
                    </div>
                    <div class="col">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-md-6">
                                <h4 class="mb-1">{{ $review->token }}</h4>
                                <p class="small mb-3"><span class="badge badge-dark">Created on:
                                        {{ $review->created_at->format('d M Y') }}</span></p>
                                <div class="">
                                    <p class="text-muted">
                                        Discount: <strong>{{ $review->user_id }}</strong>
                                    </p>
                                    <p class="text-muted">
                                        Max Uses: <strong>{{ $review->rating }}</strong>
                                    </p>
                                    <p class="text-muted">
                                        Times Used: <strong>{{ $review->review }}</strong>
                                    </p>
                                    <p class="text-muted">
                                        Created At: <strong>{{ $review->created_at->format('d M Y') }}</strong>
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="card-deck my-4">
                                    <div class="card mb-4">
                                        <div class="card-body text-center my-4">
                                            <h3 class="h5 mt-4 mb-0">#</h3>
                                            <p class="text-muted">#</p>
                                            <p class="text-muted">#<strong>#</strong></p>
                                            <p class="text-muted">#</p>
                                        </div> <!-- .card-body -->
                                    </div> <!-- .card -->
                                </div> <!-- .card-group -->
                            </div>
                        </div>
                    </div>
                </div>

                <h3>Review Usage</h3>
                <p class="text-muted">Track the usage and effectiveness of the Review.</p>

                <div class="row">
                    <div class="col-md-5"></div>
                    {{-- <div class="col">
                        <a class="btn mb-2 btn-warning btn-lg" href="{{ route('Review.edit', $review->id) }}">Edit</a>
                    </div> --}}
                    <div class="col">
                        <form action="{{ route('review.destroy', $review->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn mb-2 btn-danger btn-lg">Delete</button>
                        </form>
                    </div>
                    <div class="col-md-5"></div>
                </div>
            </div> <!-- /.col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
@endsection
