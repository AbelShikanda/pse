@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Price Details Table</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p class="card-text">
                            Price Details available in the organization
                        </p>
                    </div>
                    <div class="col-md-6">
                        <a href={{ route('prices.create') }} type="button" class=" float-right btn mb-2 btn-outline-primary">Add Price Details</a>
                    </div>
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
                                            <th>Price</th>
                                            <th>Type of product</th>
                                            <th>created at</th>
                                            <th>updated at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($prices as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td>{{ $item->type_name }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->updated_at }}</td>
                                                <td><button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="{{ route('prices.edit', $item->id) }}">Edit</a>

                                                        {{-- javascript will keep picking the same item unless the id is made unique for each item --}}
                                                        <a class="dropdown-item"
                                                            href="{{ route('prices.destroy', $item->id) }}"
                                                            onclick="event.preventDefault();
                                                            document.getElementById('destroy-prices-{{ $item->id }}').submit();">
                                                            {{ __('Remove') }}
                                                        </a>

                                                        <form id="destroy-prices-{{ $item->id }}"
                                                            action="{{ route('prices.destroy', $item->id) }}" method="POST"
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
