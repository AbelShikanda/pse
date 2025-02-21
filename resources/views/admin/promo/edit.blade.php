@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Edit Promo Code</h2>
                <p class="text-muted">Update the promo code details</p>

                @if ($errors->any())
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
                                <strong class="card-title">Edit Promo Code</strong>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('promo.update', $promoCode->id) }}" method="POST" class="needs-validation">
                                    @method('PATCH')
                                    @csrf
                                    
                                    <div class="col-md-12 mb-3">
                                        <label for="code">Promo Code</label>
                                        <input type="text" name="code" class="form-control" id="code" value="{{ $promoCode->code }}" readonly>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="code">Max Use</label>
                                        <input type="text" name="max_uses" class="form-control" id="code" value="{{ $promoCode->max_uses }}">
                                    </div>
                                    
                                    <div class="col-md-12 mb-3">
                                        <label for="discount">Discount Percentage</label>
                                        <input type="number" name="discount_percentage" class="form-control" id="discount" value="{{ $promoCode->discount }}">
                                    </div>
                                    
                                    <div class="col-md-12 mb-3">
                                        <label for="expiry_date">Expiry Date</label>
                                        <input type="date" name="expires_at" class="form-control" id="expiry_date" value="{{ $promoCode->expiry_date }}">
                                    </div>
                                    
                                    <button class="btn btn-primary" type="submit">Update Promo Code</button>
                                </form>
                            </div> <!-- /.card-body -->
                        </div> <!-- /.card -->
                    </div> <!-- /.col -->
                </div> <!-- end section -->
            </div> <!-- /.col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
@endsection
