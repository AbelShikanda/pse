@extends('admin.layouts.app')

@section('content')
    <div class="admin-page">
        <p class="admin-breadcrumb"><a href="{{ route('dashboard.index') }}">Dashboard</a> / <a href="{{ route('products.index') }}">Products</a> / create</p>
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="admin-title">New <em>product</em></h1>
                <p class="admin-subtitle">Add a product to the catalog.</p>
            </div>
            <a href="{{ route('products.index') }}" class="admin-back"><i class="fe fe-arrow-left fe-16"></i> Back to products</a>
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
                <i class="fe fe-box"></i>
                <strong>Product details</strong>
            </div>
            <form action="{{ route('products.store') }}" method="POST" class="admin-card__body needs-validation" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="admin-field">
                            <label class="admin-label" for="name">Name <span class="admin-required">*</span></label>
                            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admin-field">
                            <label class="admin-label" for="meta_title">Meta title</label>
                            <input id="meta_title" type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admin-field">
                            <label class="admin-label" for="meta_description">Meta description</label>
                            <input id="meta_description" type="text" name="meta_description" class="form-control" value="{{ old('meta_description') }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="admin-field">
                            <label class="admin-label" for="meta_keywords">Meta keywords</label>
                            <input id="meta_keywords" type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="admin-field">
                            <label class="admin-label" for="meta_image">Meta image</label>
                            <input id="meta_image" type="text" name="meta_image" class="form-control" value="{{ old('meta_image') }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="admin-field">
                            <label class="admin-label" for="category">Category <span class="admin-required">*</span></label>
                            <select class="form-control select2" id="category" name="category" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category') == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admin-field">
                            <label class="admin-label" for="type">Type <span class="admin-required">*</span></label>
                            <select class="form-control select2" id="type" name="type" required>
                                @foreach ($product_types as $types)
                                    <option value="{{ $types->id }}" @selected(old('types') == $types->id)>{{ $types->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="admin-field">
                            <label class="admin-label" for="color">Color <span class="admin-required">*</span></label>
                            <select class="form-control select2" id="color" name="color" required>
                                @foreach ($colors as $types)
                                    <option value="{{ $types->id }}" @selected(old('types') == $types->id)>{{ $types->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="admin-field">
                            <label class="admin-label" for="size">Size <span class="admin-required">*</span></label>
                            <select class="form-control select2" id="size" name="size" required>
                                @foreach ($sizes as $types)
                                    <option value="{{ $types->id }}" @selected(old('types') == $types->id)>{{ $types->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="admin-field">
                            <label class="admin-label" for="material">Material <span class="admin-required">*</span></label>
                            <select class="form-control select2" id="material" name="material" required>
                                @foreach ($materials as $types)
                                    <option value="{{ $types->id }}" @selected(old('types') == $types->id)>{{ $types->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="admin-field">
                    <label class="admin-label" for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                </div>

                <div class="admin-card__foot" style="padding:0; border:none; margin:0">
                    <button type="submit" class="btn btn-primary"><i class="fe fe-check fe-14"></i> Create product</button>
                </div>
            </form>
        </div>
    </div>
@endsection
