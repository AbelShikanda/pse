@extends('admin.layouts.app')

@section('content')
    <div class="admin-page">
        <p class="admin-breadcrumb"><a href="{{ route('dashboard.index') }}">Dashboard</a> / <a href="{{ route('prices.index') }}">Prices</a> / create</p>
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="admin-title">Edit <em>price</em></h1>
                <p class="admin-subtitle">Update the price for this product type.</p>
            </div>
            <a href="{{ route('prices.index') }}" class="admin-back"><i class="fe fe-arrow-left fe-16"></i> Back to prices</a>
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
                <i class="fe fe-tag"></i>
                <strong>Price details</strong>
            </div>
            <form action="{{ route('prices.update', $prices->id) }}" method="POST" class="admin-card__body needs-validation" novalidate>
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-md-7">
                        <div class="admin-field">
                            <label class="admin-label" for="field-types">Product type <span class="admin-required">*</span></label>
                            <select class="form-control select2" id="field-types" name="types" required>
                                @foreach ($types as $typeOption)
                                    <option value="{{ $typeOption->id }}" @selected(old('types', $prices->type_id) == $typeOption->id)>{{ $typeOption->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="admin-field">
                            <label class="admin-label" for="field-price">Amount (KSh) <span class="admin-required">*</span></label>
                            <input id="field-price" name="price" type="number" min="0" step="0.01" class="form-control" value="{{ old('price', $prices->price) }}" required>
                        </div>
                    </div>
                </div>
                <div class="admin-card__foot" style="padding:0; border:none; margin:0">
                    <button type="submit" class="btn btn-primary"><i class="fe fe-check fe-14"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
