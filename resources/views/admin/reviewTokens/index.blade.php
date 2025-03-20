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
                        <!-- Button to trigger modal -->
                        <button type="button" class="float-right btn mb-2 btn-outline-primary" data-toggle="modal" data-target="#generateTokenModal">
                            Add Token
                        </button>
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


    <!-- Modal for Token Generation -->
    <div class="modal fade" id="generateTokenModal" tabindex="-1" role="dialog" aria-labelledby="generateTokenModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateTokenModalLabel">Generate Review Token</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('generateToken') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="guest_name">Enter Name</label>
                            <input type="text" class="form-control" id="guest_name" name="guest_name" required placeholder="Enter guest name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Generate Token</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
