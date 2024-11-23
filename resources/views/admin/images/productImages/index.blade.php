@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Product Image Table</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p class="card-text">
                            Product images available in the organization
                        </p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('product_images.create') }}" type="button" class=" float-right btn mb-2 btn-outline-primary">Add Product Image</a>
                    </div>
                </div>

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
                                            <th>Image</th>
                                            <th>Thumbnail</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productImages as $itm)
                                            <tr>
                                                <td>{{ $itm->id }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/img/products/'.$itm->thumbnail) }}" style="width:50px;" alt="image">
                                                </td>
                                                <td>{{ $itm->full }}</td>
                                                <td><button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="{{ route('product_images.edit', $itm->id) }}">Edit</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('product_images.destroy', $itm->id) }}"
                                                            onclick="event.preventDefault();
                                                            document.getElementById('destroy-product_images').submit();">
                                                            {{ __('Remove') }}
                                                        </a>

                                                        <form id="destroy-product_images"
                                                            action="{{ route('product_images.destroy', $itm->id) }}" method="POST"
                                                            class="d-none">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
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
