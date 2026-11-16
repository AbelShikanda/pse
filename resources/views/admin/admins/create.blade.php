@extends('admin.layouts.app')

@section('content')
    <div class="admin-page">
        <p class="admin-breadcrumb"><a href="{{ route('dashboard.index') }}">Dashboard</a> / <a href="{{ route('admins.index') }}">Admins</a> / create</p>
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="admin-title">New <em>admin</em></h1>
                <p class="admin-subtitle">Create a back-office account and assign its roles.</p>
            </div>
            <a href="{{ route('admins.index') }}" class="admin-back"><i class="fe fe-arrow-left fe-16"></i> Back to admins</a>
        </div>

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card admin-card admin-card--wide">
            <div class="admin-card__head">
                <i class="fe fe-shield"></i>
                <strong>Admin details</strong>
            </div>
            <form action="{{ route('admins.store') }}" method="post" class="admin-card__body needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="admin-field">
                            <label class="admin-label" for="first_name">First name <span class="admin-required">*</span></label>
                            <input id="first_name" type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="admin-field">
                            <label class="admin-label" for="user_name">User name <span class="admin-required">*</span></label>
                            <input id="user_name" type="text" name="user_name" class="form-control" value="{{ old('user_name') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="admin-field">
                            <label class="admin-label" for="email">Email <span class="admin-required">*</span></label>
                            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="admin-field">
                            <label class="admin-label" for="password">Password <span class="admin-required">*</span></label>
                            <input id="password" type="password" name="password" class="form-control" autocomplete="new-password" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admin-field">
                            <label class="admin-label" for="password_confirmation">Confirm password <span class="admin-required">*</span></label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" autocomplete="new-password" required>
                        </div>
                    </div>
                </div>

                <p class="admin-label" style="margin-top:.5rem">Flags</p>
                <div class="d-flex flex-wrap gap-3">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="admin" id="flag-admin" value="1" {{ old('admin') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="flag-admin">Is admin</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="staff" id="flag-staff" value="1" {{ old('staff') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="flag-staff">Is staff</label>
                    </div>
                </div>

                <p class="admin-label" style="margin-top:1.5rem">Roles</p>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($roles as $role)
                        <div class="form-check" style="min-width:150px">
                            <input name="role[{{ $role->name }}]" id="role-{{ $loop->index }}" class="form-check-input" type="checkbox" value="{{ $role->name }}">
                            <label class="form-check-label" for="role-{{ $loop->index }}" style="font-size:.82rem">{{ $role->name }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="admin-card__foot" style="padding:0; border:none; margin:0">
                    <button type="submit" class="btn btn-primary"><i class="fe fe-check fe-14"></i> Create admin</button>
                </div>
            </form>
        </div>
    </div>
@endsection
