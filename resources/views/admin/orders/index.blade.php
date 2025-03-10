@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-12 my-4">
                        <h2 class="h4 mb-1">Expandable rows</h2>
                        <p class="mb-3">Child rows with additional detailed information</p>

                        @if (Session('message'))
                            <div class="text-success text-center">
                                <strong>{{ Session('message') }}</strong>
                            </div>
                        @endif
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <table class="table table-hover table-borderless border-v">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Date</th>
                                            <th>Customer</th>
                                            <th>REf #</th>
                                            <th>Status</th>
                                            <th>Sub Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            @php
                                                $orderId = 'order-' . $order->id;
                                            @endphp
                                            <tr class="accordion-toggle collapsed" id="{{ $orderId }}"
                                                data-toggle="collapse" data-parent="#{{ $orderId }}"
                                                href="#collap-{{ $orderId }}">
                                                <td>{{ $order->created_at }}</td>
                                                <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                                                <td>{{ $order->reference }}</td>
                                                <td>
                                                    @if ($order->complete == 1)
                                                        <span class="badge badge-pill badge-success mr-2">S</span>
                                                        <small class="text-muted">Paid</small>
                                                    @else
                                                        <span class="badge badge-pill badge-danger mr-2">X</span>
                                                        <small class="text-muted">Unconfirmed</small>
                                                    @endif
                                                </td>
                                                <td>Ksh {{ $order->price }}</td>
                                                <td>
                                                    @if ($order->complete == 1)
                                                    @else
                                                        <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                            type="button" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <span class="text-muted sr-only">Action</span>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">

                                                            <a class="dropdown-item"
                                                                href="{{ route('orders.update', $order->id) }}"
                                                                onclick="event.preventDefault();
                                                                document.getElementById('update-order-{{ $order->id }}').submit();">
                                                                {{ __('Confirm Order') }}
                                                            </a>

                                                            <form id="update-order-{{ $order->id }}"
                                                                action="{{ route('orders.update', $order->id) }}"
                                                                method="post" class="d-none">
                                                                @csrf
                                                                @method('patch')
                                                            </form>

                                                            @if ($order->created_at->diffInDays(now()) > 3)
                                                                <a class="dropdown-item"
                                                                    href="{{ route('orders.destroy', $order->id) }}"
                                                                    onclick="event.preventDefault();
                                                                document.getElementById('destroy-order-{{ $order->id }}').submit();">
                                                                    {{ __('Delete Order') }}
                                                                </a>

                                                                <form id="destroy-order-{{ $order->id }}"
                                                                    action="{{ route('orders.destroy', $order->id) }}"
                                                                    method="post" class="d-none">
                                                                    @csrf
                                                                    @method('patch')
                                                                </form>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr id="collap-{{ $orderId }}" class="collapse in p-3 bg-light">
                                                <td colspan="8">
                                                    <dl class="row mb-0 mt-1">
                                                        <dt class="col-sm-3">{{ $order->user->email }}</dt>
                                                        <dt class="col-sm-3">{{ $order->user->phone }}</dt>
                                                        <dt class="col-sm-3">{{ $order->user->town }}</dt>
                                                        <dd class="col-sm-3">{{ $order->user->location }}</dd>
                                                    </dl>
                                                </td>
                                            </tr>
                                            @foreach ($order->orderItems as $item)
                                                <tr id="collap-{{ $orderId }}" class="collapse in p-3 bg-light">
                                                    <td colspan="8">
                                                        <dl class="row mb-0 mt-1">
                                                            <dt class="col-sm-2"><img
                                                                    src="{{ asset('storage/img/products/' . $item->products->ProductImage[0]->thumbnail) }}"
                                                                    style="width:40px;"
                                                                    alt="{{ $item->products->ProductImage[0]->full }}">
                                                            </dt>
                                                            <dt class="col-sm-2">
                                                                {{ Str::words($item->products->name, 3, '...') }}</dt>
                                                            <dt class="col-sm-2">
                                                                {{ Str::words($item->products->producttype[0]->name, 3, '...') }}
                                                            </dt>
                                                            <dt class="col-sm-2">{{ $item->products->color[0]->name }}</dt>
                                                            <dt class="col-sm-2">{{ $item->products->size[0]->name }}</dt>
                                                            <dt class="col-sm-2">{{ $item->quantity }}</dt>
                                                        </dl>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end section -->
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
@endsection
