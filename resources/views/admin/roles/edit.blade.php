@extends('admin.layouts.app')

@section('content')
    <div class="admin-page">
        <p class="admin-breadcrumb"><a href="{{ route('dashboard.index') }}">Dashboard</a> / <a href="{{ route('roles.index') }}">Roles</a> / create</p>
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="admin-title">Edit <em>role</em></h1>
                <p class="admin-subtitle">Update this role and its permissions.</p>
            </div>
            <a href="{{ route('roles.index') }}" class="admin-back"><i class="fe fe-arrow-left fe-16"></i> Back to roles</a>
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
                <i class="fe fe-lock"></i>
                <strong>Role details</strong>
            </div>
            <form method="post" action="{{ route('roles.update', $role->id) }}" class="admin-card__body needs-validation" novalidate>
                @method('patch')
                @csrf
                <div class="admin-field" style="max-width:420px">
                    <label class="admin-label" for="field-name">Role name <span class="admin-required">*</span></label>
                    <input id="field-name" type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required autocomplete="off">
                </div>
                <p class="admin-label" style="margin-top:1.25rem">Permissions</p>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($permissions as $permission)
                        <div class="form-check" style="min-width:170px">
                            <input name="permission[{{ $permission->name }}]" id="perm-{{ $loop->index }}" class="form-check-input" type="checkbox" value="{{ $permission->name }}" @checked(in_array($permission->name, $rolePermissions ?? []))>
                            <label class="form-check-label" for="perm-{{ $loop->index }}" style="font-size:.82rem">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="admin-card__foot" style="padding:0; border:none; margin:0">
                    <button type="submit" class="btn btn-primary"><i class="fe fe-check fe-14"></i> Create role</button>
                </div>
            </form>
        </div>
    </div>
@endsection
