@extends('admin.layouts.app')

@section('content')
    <div class="admin-page">
        <p class="admin-breadcrumb"><a href="{{ route('dashboard.index') }}">Dashboard</a> / <a href="{{ route('products.index') }}">Products</a> / edit</p>
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="admin-title">Edit <em>product</em></h1>
                <p class="admin-subtitle">Update the product catalog entry.</p>
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
            <form action="{{ route('products.update', $products->id) }}" method="POST" class="admin-card__body needs-validation" enctype="multipart/form-data" novalidate>
                @method('patch')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="admin-field">
                            <label class="admin-label" for="name">Name <span class="admin-required">*</span></label>
                            <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $products->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admin-field">
                            <label class="admin-label" for="meta">Meta keywords</label>
                            <input id="meta" type="text" name="meta" class="form-control" value="{{ old('meta', $products->meta_keywords) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="admin-field">
                            <label class="admin-label" for="category">Category <span class="admin-required">*</span></label>
                            <select class="form-control select2" id="category" name="category" required>
                                @if ($category)<option value="{{ $category->id }}" selected>{{ $category->name }}</option>@endif
                                @foreach ($categories as $c)
                                    <option value="{{ $c->id }}" @selected(old('category') == $c->id)>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admin-field">
                            <label class="admin-label" for="type">Type <span class="admin-required">*</span></label>
                            <select class="form-control select2" id="type" name="type" required>
                                @if ($product_type)<option value="{{ $product_type->id }}" selected>{{ $product_type->name }}</option>@endif
                                @foreach ($product_types as $s)
                                    <option value="{{ $s->id }}" @selected(old('type') == $s->id)>{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="admin-field">
                            <label class="admin-label" for="color">Color <span class="admin-required">*</span></label>
                            <select class="form-control select2" id="color" name="color" required>
                                @if ($color)<option value="{{ $color->id }}" selected>{{ $color->name }}</option>@endif
                                @foreach ($colors as $c)
                                    <option value="{{ $c->id }}" @selected(old('color') == $c->id)>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="admin-field">
                            <label class="admin-label" for="size">Size <span class="admin-required">*</span></label>
                            <select class="form-control select2" id="size" name="size" required>
                                @if ($size)<option value="{{ $size->id }}" selected>{{ $size->name }}</option>@endif
                                @foreach ($sizes as $s)
                                    <option value="{{ $s->id }}" @selected(old('size') == $s->id)>{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="admin-field">
                            <label class="admin-label" for="material">Material <span class="admin-required">*</span></label>
                            <select class="form-control select2" id="material" name="material" required>
                                @if ($material)<option value="{{ $material->id }}" selected>{{ $material->name }}</option>@endif
                                @foreach ($materials as $m)
                                    <option value="{{ $m->id }}" @selected(old('material') == $m->id)>{{ $m->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="admin-field">
                    <label class="admin-label" for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ $products->description }}</textarea>
                </div>

                <div class="row" style="gap:.4rem 0">
                    @foreach (['whatsapp' => 'Posted on WhatsApp', 'telegram' => 'Posted on Telegram', 'website' => 'On website', 'promotion' => 'Has promotion'] as $flag => $label)
                        <div class="col-md-3">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="{{ $flag }}" id="flag-{{ $flag }}" value="1" {{ old($flag, $products->{$flag}) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="flag-{{ $flag }}">{{ $label }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="admin-card__foot" style="padding:0; border:none; margin:0">
                    <button type="submit" class="btn btn-primary"><i class="fe fe-check fe-14"></i> Update product</button>
                </div>
            </form>
        </div>
    </div>
@endsection
