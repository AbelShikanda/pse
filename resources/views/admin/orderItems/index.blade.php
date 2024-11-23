@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Order Item Table</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p class="card-text">
                            Order items made
                        </p>
                    </div>
                    <div class="col-md-6">
                        {{-- <a type="button" class=" float-right btn mb-2 btn-outline-primary">Add Product Image</a> --}}
                    </div>
                </div>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <table class="table datatables" id="dataTable-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Department</th>
                                            <th>Company</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>368</td>
                                            <td>Imani Lara</td>
                                            <td>(478) 446-9234</td>
                                            <td>Asset Management</td>
                                            <td>Borland</td>
                                            <td>9022 Suspendisse Rd.</td>
                                            <td>High Wycombe</td>
                                            <td>Jun 8, 2019</td>
                                            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#">View</a>
                                                    <a class="dropdown-item" href="#">Remove</a>
                                                </div>
                                            </td>
                                        </tr>
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
