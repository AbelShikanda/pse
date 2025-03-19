@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">review Table</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p class="card-text">
                            review Available
                        </p>
                    </div>
                </div>
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger col-md-8 offset-md-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <table class="table datatables" id="reviewTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Rating</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reviews as $index => $review)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $review->user_id }}</td>
                                                <td>{{ $review->rating }}</td>
                                                <td>{{ $review->created_at }}</td>
                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="{{ route('review.show', $review->id) }}">View</a>
                                                        <!-- <a class="dropdown-item"
                                                            href="#">Edit</a>
                                                            <a class="dropdown-item text-danger"
                                                                href="#"
                                                                onclick="event.preventDefault(); document.getElementById('delete-review-{{ $review->id }}').submit();">
                                                                Delete
                                                            </a>
                                                            <form id="delete-review-{{ $review->id }}"
                                                                action="#"
                                                                method="POST" class="d-none">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form> -->
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div> <!-- simple table -->
                </div> <!-- end section -->
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
@endsection
