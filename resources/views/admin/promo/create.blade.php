@extends('admin.layouts.app')

@section('content')
    <div class="admin-page">
        <p class="admin-breadcrumb"><a href="{{ route('dashboard.index') }}">Dashboard</a> / <a href="{{ route('promo.index') }}">Promo codes</a> / create</p>
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="admin-title">New <em>promo code</em></h1>
                <p class="admin-subtitle">Create a discount code for customers.</p>
            </div>
            <a href="{{ route('promo.index') }}" class="admin-back"><i class="fe fe-arrow-left fe-16"></i> Back to promo codes</a>
        </div>

        @if ($errors->any())
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
                <i class="fe fe-percent"></i>
                <strong>Promo details</strong>
            </div>
            <form action="{{ route('create.promo') }}" method="POST" class="admin-card__body needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="admin-field">
                            <label class="admin-label" for="discount_percentage">Discount (%) <span class="admin-required">*</span></label>
                            <input id="discount_percentage" type="number" min="1" max="100" name="discount_percentage" class="form-control" value="{{ old('discount_percentage') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admin-field">
                            <label class="admin-label" for="max_uses">Max uses <span class="admin-required">*</span></label>
                            <input id="max_uses" type="number" min="1" name="max_uses" class="form-control" value="{{ old('max_uses') }}" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="admin-field">
                            <label class="admin-label" for="expires_at">Expiry date <span class="admin-required">*</span></label>
                            <input id="expires_at" type="date" name="expires_at" class="form-control" value="{{ old('expires_at') }}" required>
                        </div>
                    </div>
                </div>
                <div class="admin-card__foot" style="padding:0; border:none; margin:0">
                    <button type="submit" class="btn btn-primary"><i class="fe fe-check fe-14"></i> Create promo</button>
                </div>
            </form>
        </div>
    </div>
@endsection
