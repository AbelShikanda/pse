@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Products Table</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p class="card-text">
                            Product available in the organization
                        </p>
                    </div>
                    <div class="col-md-6">
                        <a href={{ route('products.create') }} type="button"
                            class=" float-right btn mb-2 btn-outline-primary">Add Product</a>
                    </div>
                </div>

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
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $p)
                                            <tr>
                                                <td>{{ $p->id }}</td>
                                                <td>{{ $p->name }}</td>
                                                @foreach ($p->ProductType as $item)
                                                    <td>{{ Str::words($item->name, 3, '...') }}</td>
                                                @endforeach
                                                <td>{{ Str::words($p->description, 3, '...') }}</td>
                                                <td>{{ $p->price }}</td>
                                                <td><button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="{{ route('products.show', $p->id) }}">view</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('products.edit', $p->id) }}">Edit</a>

                                                        <a class="dropdown-item" href="{{ route('products.destroy', $p->id) }}"
                                                            onclick="event.preventDefault();
                                                            document.getElementById('destroy-product').submit();">
                                                            {{ __('Remove') }}
                                                        </a>

                                                        <form id="destroy-product" action="{{ route('products.destroy', $p->id) }}"
                                                            method="POST" class="d-none">
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
