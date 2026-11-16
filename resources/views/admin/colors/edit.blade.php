@extends('admin.layouts.app')

@section('content')
    <div class="admin-page">
        <p class="admin-breadcrumb"><a href="{{ route('dashboard.index') }}">Dashboard</a> / <a href="{{ route('colors.index') }}">Colors</a> / edit</p>
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="admin-title">Edit <em>color</em></h1>
                <p class="admin-subtitle">Update this color for catalog use.</p>
            </div>
            <a href="{{ route('colors.index') }}" class="admin-back"><i class="fe fe-arrow-left fe-16"></i> Back to Colors</a>
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

        <div class="card admin-card">
            <div class="admin-card__head">
                <i class="fe fe-droplet"></i>
                <strong>Colors details</strong>
            </div>
            <form action="{{ route('colors.update', $colors->id) }}" method="POST" class="admin-card__body needs-validation" novalidate>
                @csrf
                @method('patch')
                <div class="admin-field">
                    <label class="admin-label" for="field-name">Name <span class="admin-required">*</span></label>
                    <input id="field-name" type="text" name="name" class="form-control" value="{{ old('name', $colors->name) }}" required>
                </div>
                <div class="admin-field">
                    <label class="admin-label" for="field-slug">Slug <span class="admin-required">*</span></label>
                    <input id="field-slug" type="text" name="slug" class="form-control" value="{{ old('slug', $colors->slug) }}" required>
                </div>
                <div class="admin-card__foot" style="padding:0; border:none; margin:0">
                    <button type="submit" class="btn btn-primary"><i class="fe fe-check fe-14"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
