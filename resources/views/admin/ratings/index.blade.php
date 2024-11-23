@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">ratings Table</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p class="card-text">
                            ratings / stories 
                        </p>
                    </div>
                    <div class="col-md-6">
                        {{-- <a href="{{ route('ratings.create')}}" type="button" class=" float-right btn mb-2 btn-outline-primary">Add rating</a> --}}
                    </div>
                </div>
                <p class="card-text">
                </p>

                @if (Session('success'))
                    <div class="text-success text-center">
                        <strong>{{ Session('success') }}</strong>
                    </div>
                @endif
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <table class="table datatables" id="dataTable-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>Customers</th>
                                            <th>Rating</th>
                                            <th>Created On</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productsWithRatings as $rating)
                                            <tr>
                                                <td>{{ $rating->id }}</td>
                                                <td>{{ $rating->name }}</td>
                                                <td>{{ $rating->ratings->count() }} rater(s)</td>
                                                <td>{{ $rating->ratings->first()->avg_rating ?? 'No Rating' }}</td>
                                                <td>{{ $rating->created_at }}</td>
                                                {{-- <td><button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="{{ route('ratings.show', $rating->id) }}">view</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('ratings.edit', $rating->id) }}">Edit</a>

                                                        <a class="dropdown-item" href="{{ route('ratings.destroy', $rating->id) }}"
                                                            onclick="event.preventDefault();
                                                            document.getElementById('destroy-rating-{{ $rating->id }}').submit();">
                                                            {{ __('Remove') }}
                                                        </a>

                                                        <form id="destroy-rating-{{ $rating->id }}" action="{{ route('ratings.destroy', $rating->id) }}"
                                                            method="post" class="d-none">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td> --}}
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
