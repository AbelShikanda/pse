@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h3 mb-4 page-title">admin Details</h2>
                <div class="row mt-5 align-items-center">
                    <div class="col-md-3 text-center mb-5">
                        <div class="avatar avatar-xl">
                            <img src="./assets/avatars/face-1.jpg" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </div>
                    <div class="col">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-md-6">
                                <h4 class="mb-1">{{ $admin->username }}</h4>
                                <p class="small mb-3"><span class="badge badge-dark">created on:
                                        {{ $admin->created_at }}</span></p>
                                <p class="small mb-3"><span class="badge badge-dark">updated on:
                                        {{ $admin->updated_at }}</span></p>
                                <div class="">
                                    <p class="text-muted">
                                        @if ($admin->is_staff)
                                            <p>admin is staff</p>
                                        @else
                                            <p>admin not staff</p>
                                        @endif
                                    </p>
                                </div>
                                <div class="">
                                    <p class="text-muted">
                                        @if ($admin->is_admin)
                                            <p>admin is admin</p>
                                        @else
                                            <p>admin not admin</p>
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
                @if ($admin->count() > 0)
                    <h3>About admin</h3>
                    <p class="text-muted">This is a desctiption about {{ $admin->username }}.</p>
                    <div class="card-deck my-4">
                        <div class="card mb-4">
                            <div class="card-body text-center my-4">
                                <span class="h1 mb-0">{{ $admin->username }}</span>
                                <a href="#">
                                    <h3 class="h5 mt-4 mb-0">{{ $admin->email }}</h3>
                                </a>
                                <p class="text-muted">Admin From: {{ $admin->created_at }}</p>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .card-group -->
                @endif
                <br>
                <br>
                @if ($admin->roles->count() > 0)
                    <h3>admin roles</h3>
                    <p class="text-muted">these are roles : {{ $admin->username }}.</p>
                    <table class="table table-borderless table-striped">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admin->roles as $role)
                                <tr>
                                    <th scope="col">{{ $role->id }}</th>
                                    <td>
                                            {{ $role->name }}
                                    </td>
                                    <td>{{ $role->created_at }}</td>
                                    <td>{{ $role->updated_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div> <!-- /.col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
@endsection
