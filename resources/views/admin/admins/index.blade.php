@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Administrator Table</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p class="card-text">
                            Administrator table diplaying all company admins
                        </p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('admins.create') }}" type="button" class=" float-right btn mb-2 btn-outline-primary">Add Admin</a>
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
                                            <th>User Name</th>
                                            <th>Nick Name</th>
                                            <th>Email</th>
                                            <th>Roles</th>
                                            <th>modified</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($admins as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->username }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>
                                                    @if (!@empty($item->getRoleNames()))
                                                        @foreach ($item->getRoleNames() as $rolename)
                                                            <label class="badge bg-primary">{{ $rolename }}</label>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>{{ $item->updated_at }}</td>
                                                <td><button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="{{ route('admins.show', $item->id) }}">View</a>
                                                        <a class="dropdown-item" href="{{ route('admins.edit', $item->id) }}">Edit</a>

                                                        <a class="dropdown-item" href="{{ route('admins.destroy', $item->id) }}"
                                                            onclick="event.preventDefault();
                                                            document.getElementById('destroy-admin').submit();">
                                                            {{ __('Remove') }}
                                                        </a>

                                                        <form id="destroy-admin" action="{{ route('admins.destroy', $item->id) }}"
                                                            method="post" class="d-none">
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
