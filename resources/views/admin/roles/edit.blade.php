@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Roles Posts</h2>
                <p class="text-muted">add more Roles for posting</p>

                @if (count($errors) > 0)
                    <div class="alert alert-danger col-md-8 offset-md-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6 offset-3">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Roles Posts</strong>
                            </div>
                            <div class="card-body">
                                <form id="quickForm" method="post" action="{{ route('roles.update', $role->id) }}">
                                    @csrf
                                    @method('patch')
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Role Name</label>
                                            <input type="tect" name="name" class="form-control"
                                                id="exampleInputEmail1" placeholder="Role Name" required
                                                value="{{ $role->name }}" readonly>
                                        </div>
                                        <div class="row">
                                            <p>Add Permissions to New Role</p>
                                            <div class="col-sm-12">
                                                <!-- checkbox -->
                                                <div class="form-group justify-content-between d-flex flex-wrap">
                                                    <div class="row">
                                                        @foreach ($permissions as $permission)
                                                            <div class="form-check pr-2 col-12 col-md-6 col-lg-3">
                                                                <input name="permission[{{ $permission->name }}]"
                                                                    class="form-check-input" type="checkbox"
                                                                    value="{{ $permission->name }}"
                                                                    {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                                                <label
                                                                    class="form-check-label">{{ $permission->name }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer text-center">
                                        <button type="submit" class="btn btn-primary w-50">Add Roles</button>
                                    </div>
                                </form>
                            </div> <!-- /.card-body -->
                        </div> <!-- /.card -->
                    </div> <!-- /.col -->
                </div> <!-- end section -->
            </div> <!-- /.col-12 col-lg-10 col-xl-10 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
    @include('admin.layouts.partials.modals')
@endsection
