@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h3 mb-4 page-title">Promo Code Details</h2>
                <div class="row mt-5 align-items-center">
                    <div class="col-md-3 text-center mb-5">
                        <div class="avatar avatar-xl">
                            <img src="{{ asset('assets/avatars/discount-icon.png') }}" alt="Promo Icon"
                                class="avatar-img rounded-circle">
                        </div>
                    </div>
                    <div class="col">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-md-6">
                                <h4 class="mb-1">{{ $promoCode->code }}</h4>
                                <p class="small mb-3"><span class="badge badge-dark">Created on:
                                        {{ $promoCode->created_at->format('d M Y') }}</span></p>
                                <div class="">
                                    <p class="text-muted">
                                        Discount: <strong>{{ $promoCode->discount_percentage }}%</strong>
                                    </p>
                                    <p class="text-muted">
                                        Max Uses: <strong>{{ $promoCode->max_uses }}</strong>
                                    </p>
                                    <p class="text-muted">
                                        Times Used: <strong>{{ $promoCode->times_used }}</strong>
                                    </p>
                                    <p class="text-muted">
                                        Expires At: <strong>{{ $promoCode->expires_at->format('d M Y') }}</strong>
                                    </p>
                                    <p class="text-muted">
                                        Status:
                                        @if (now() > $promoCode->expires_at)
                                            <span class="badge badge-danger">Expired</span>
                                        @elseif ($promoCode->times_used >= $promoCode->max_uses)
                                            <span class="badge badge-warning">Fully Used</span>
                                        @else
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="card-deck my-4">
                                    <div class="card mb-4">
                                        <div class="card-body text-center my-4">
                                            <h3 class="h5 mt-4 mb-0">#</h3>
                                            <p class="text-muted">#</p>
                                            <p class="text-muted">#<strong>#</strong></p>
                                            <p class="text-muted">#</p>
                                        </div> <!-- .card-body -->
                                    </div> <!-- .card -->
                                </div> <!-- .card-group -->
                            </div>
                        </div>
                    </div>
                </div>

                <h3>Promo Code Usage</h3>
                <p class="text-muted">Track the usage and effectiveness of the promo code.</p>

                <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col">
                        <a class="btn mb-2 btn-warning btn-lg" href="{{ route('promo.edit', $promoCode->id) }}">Edit</a>
                    </div>
                    @if (!$promoCode->orders()->exists())
                        <div class="col">
                            <form action="{{ route('promo.destroy', $promoCode->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn mb-2 btn-danger btn-lg">Delete</button>
                            </form>
                        </div>
                    @endif
                    <div class="col-md-5"></div>
                </div>
            </div> <!-- /.col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
@endsection
