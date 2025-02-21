@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Create Promo Code</h2>
                <p class="text-muted">Add a new promo code for discounts and special offers.</p>

                @if ($errors->any())
                    <div class="alert alert-danger col-md-8 offset-md-2">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Promo Code Details</strong>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('create.promo') }}" method="POST" class="needs-validation">
                                    @csrf
                                    <div class="col-md-12 mb-3">
                                        <label for="discount_percentage">Discount Percentage</label>
                                        <input type="number" name="discount_percentage" class="form-control" id="discount_percentage" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="max_uses">Max Uses</label>
                                        <input type="number" name="max_uses" class="form-control" id="max_uses" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="expires_at">Expiration Date</label>
                                        <input type="date" name="expires_at" class="form-control" id="expires_at" required>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Create Promo Code</button>
                                </form>
                            </div> <!-- /.card-body -->
                        </div> <!-- /.card -->
                    </div> <!-- /.col -->
                </div> <!-- /.row -->
            </div> <!-- /.col-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->
@endsection
