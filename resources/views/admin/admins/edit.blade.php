@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Products Posts</h2>
                <p class="text-muted">add more products for posting</p>

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

                            <form action="{{ route('admins.update', $admin->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <table class="table table-hover">
                                    <tbody>
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>
                                                <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                                                Admin Details
                                            </td>
                                        </tr>
                                        <tr class="expandable-body">
                                            <td>
                                                <div class="p-0">
                                                    <table class="table table-hover">
                                                        <tbody>
                                                            <tr">
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="form-group col-12">
                                                                            <label for="exampleInputEmail1">First
                                                                                Name</label>
                                                                            <input type="text" class="form-control"
                                                                                id="exampleInputEmail1"
                                                                                placeholder="First Name" name="first_name" value="{{ $admin->name }}">
                                                                        </div>
                                                                        <div class="form-group col-12">
                                                                            <label for="exampleInputEmail1">User
                                                                                Name</label>
                                                                            <input type="text" class="form-control"
                                                                                id="exampleInputEmail1"
                                                                                placeholder="user Name" name="user_name" value="{{ $admin->username }}">
                                                                        </div>
                                                                        <div class="form-group col-12">
                                                                            <label for="exampleInputEmail1">Email
                                                                                Address</label>
                                                                            <input type="email" class="form-control"
                                                                                id="exampleInputEmail1"
                                                                                placeholder="Enter email" name="email" value="{{ $admin->email }}">
                                                                        </div>
                                                                        <div class="form-group col-12">
                                                                            <div class="col">
                                                                                <!-- checkbox -->
                                                                                <div class="form-group">
                                                                                    <div
                                                                                        class="form-check col-12 col-md-6 col-lg-3">
                                                                                        <input name="admin"
                                                                                            class="form-check-input"
                                                                                            type="checkbox" value="" @if ($admin->is_admin == 1) checked @endif>
                                                                                        <label class="form-check-label">Is
                                                                                            Admin</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col">
                                                                                <!-- checkbox -->
                                                                                <div class="form-group">
                                                                                    <div
                                                                                        class="form-check col-12 col-md-6 col-lg-3">
                                                                                        <input name="staff"
                                                                                            class="form-check-input"
                                                                                            type="checkbox" value="" @if ($admin->is_staff == 1) checked @endif>
                                                                                        <label class="form-check-label">Is
                                                                                            Staff</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="row">
                                                                        <div class="input-field col s12">
                                                                            <div class="for">
                                                                                <p for="certificate">Create New Password
                                                                                </p>

                                                                                <div class="form-group col-12">
                                                                                    <input type="password"
                                                                                        class="form-control"
                                                                                        id="exampleInputEmail1"
                                                                                        placeholder="Enter password"
                                                                                        name="password">
                                                                                </div>
                                                                            </div>
                                                                            <div class="for">
                                                                                <p for="certificate">Password
                                                                                    Confirmation
                                                                                </p>

                                                                                <div class="form-group col-12">
                                                                                    <input type="password"
                                                                                        class="form-control"
                                                                                        id="exampleInputEmail1"
                                                                                        placeholder="Password Confirmation"
                                                                                        name="password_confirmation">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                        </td>
                        </tr>
                        <tr data-widget="expandable-table" aria-expanded="false">
                            <td>
                                <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                                Roles
                            </td>
                        </tr>
                        <tr class="expandable-body">
                            <td>
                                <div class="p-0">
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr data-widget="expandable-table" aria-expanded="false">
                                                <td>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <!-- checkbox -->
                                                            <div
                                                                class="form-group justify-content-between d-flex flex-wrap">
                                                                <div class="row">
                                                                    @foreach ($roles as $role)
                                                                        <div
                                                                            class="form-check pr-2 col-12 col-md-6 col-lg-4">
                                                                            <input name="role[{{ $role->name }}]"
                                                                                class="form-check-input" type="checkbox"
                                                                                value="{{ $role->name }}" {{ in_array($role->name, $roleName) ? 'checked' : '' }}>
                                                                            <label
                                                                                class="form-check-label">{{ $role->name }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4 text-center">
                                <button type="submit" class="btn btn-block btn-dark btn-sm">Update
                                    Admin</button>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <br>
                        <br>
                        </form>
                        <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div> <!-- /.col -->
            </div> <!-- end section -->
        </div> <!-- /.col-12 col-lg-10 col-xl-10 -->
    </div> <!-- .row -->
    </div> <!-- .container-fluid -->
    @include('admin.layouts.partials.modals')
@endsection
