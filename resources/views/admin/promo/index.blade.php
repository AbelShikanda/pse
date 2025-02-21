@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Promo Codes Table</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p class="card-text">
                            Promo Codes Available
                        </p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('promo.create') }}" type="button"
                            class=" float-right btn mb-2 btn-outline-primary">Add Promo Code</a>
                    </div>
                </div>
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger col-md-8 offset-md-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <table class="table datatables" id="promoTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Promo Code</th>
                                            <th>Discount (%)</th>
                                            <th>Max Uses</th>
                                            <th>Times Used</th>
                                            <th>Expires At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($promoCodes as $index => $promo)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $promo->code }}</td>
                                                <td>{{ $promo->discount_percentage }}%</td>
                                                <td>{{ $promo->max_uses }}</td>
                                                <td>{{ $promo->times_used }}</td>
                                                <td>{{ $promo->expires_at->format('d M Y') }}</td>
                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="{{ route('promo.show', $promo->id) }}">View</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('promo.edit', $promo->id) }}">Edit</a>
                                                        @if (!$promo->orders()->exists())
                                                            <a class="dropdown-item text-danger"
                                                                href="{{ route('promo.destroy', $promo->id) }}"
                                                                onclick="event.preventDefault(); document.getElementById('delete-promo-{{ $promo->id }}').submit();">
                                                                Delete
                                                            </a>
                                                            <form id="delete-promo-{{ $promo->id }}"
                                                                action="{{ route('promo.destroy', $promo->id) }}"
                                                                method="POST" class="d-none">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div> <!-- simple table -->
                </div> <!-- end section -->
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
@endsection
