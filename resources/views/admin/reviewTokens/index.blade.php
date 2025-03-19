@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Review Tokens Table</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p class="card-text">
                            Review Tokens Available
                        </p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('generateToken') }}" type="button"
                            class=" float-right btn mb-2 btn-outline-primary">Add Token</a>
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
                                <table class="table datatables" id="promoTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Url</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Expires At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($review_tokens as $index => $review)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $review->url }}</td>
                                                <td>{{ $review->is_used }}</td>
                                                <td>{{ $review->created_at }}</td>
                                                <td>{{ $review->expires_at->format('d M Y') }}</td>
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
