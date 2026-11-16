@extends('admin.layouts.app')

@section('content')
    <div class="admin-page">
        <p class="admin-breadcrumb"><a href="{{ route('dashboard.index') }}">Dashboard</a> / <a href="{{ route('sizes.index') }}">Sizes</a> / create</p>
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="admin-title">New <em>sizes</em></h1>
                <p class="admin-subtitle">Add a new size option.</p>
            </div>
            <a href="{{ route('sizes.index') }}" class="admin-back"><i class="fe fe-arrow-left fe-16"></i> Back to Sizes</a>
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
                <i class="fe fe-maximize"></i>
                <strong>Sizes details</strong>
            </div>
            <form action="{{ route('sizes.store', ) }}" method="POST" class="admin-card__body needs-validation" novalidate>
                @csrf
                @method('post')
                <div class="admin-field">
                    <label class="admin-label" for="field-name">Name <span class="admin-required">*</span></label>
                    <input id="field-name" type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="admin-field">
                    <label class="admin-label" for="field-slug">Slug <span class="admin-required">*</span></label>
                    <input id="field-slug" type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
                </div>
                <div class="admin-card__foot" style="padding:0; border:none; margin:0">
                    <button type="submit" class="btn btn-primary"><i class="fe fe-check fe-14"></i> Create</button>
                </div>
            </form>
        </div>
    </div>
@endsection
