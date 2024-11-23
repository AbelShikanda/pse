@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="w-50 mx-auto text-center justify-content-center pb-5 mb-5">
                    <h2 class="page-title mb-0">What would you like to know today?</h2>
                    <p class="lead text-muted mb-4">Your analytics at the tip of your fingers</p>
                    <form class="searchform searchform-lg">
                        <input class="form-control form-control-lg bg-white rounded-pill pl-5" type="search"
                            placeholder="Search" aria-label="Search">
                        <p class="help-text mt-2 text-muted">You can ask anything about your database</p>
                    </form>
                    <button type="button" class="btn mb-2 btn-secondary" data-toggle="modal" data-target=".modal-full">Add a Schedule</button>
                </div>
                {{-- <div class="row my-4">
                    <div class="col-6 col-lg-3">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <i class="fe fe-info fe-32 text-primary"></i>
                                <a href="#">
                                    <h3 class="h5 mt-4 mb-1">Schedule 1</h3>
                                </a><br>
                                <p class="text-muted">Start working with theme</p>
                                <p class="text-muted">Start working with theme</p>
                                <p class="text-muted">Start working with theme</p>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col-md-->
                    <div class="col-6 col-lg-3">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <i class="fe fe-help-circle fe-32 text-success"></i>
                                <a href="./page-faqs.html">
                                    <h3 class="h5 mt-4 mb-1">Schedule 2</h3>
                                </a><br>
                                <p class="text-muted">Frequently asked questions</p>
                                <p class="text-muted">Frequently asked questions</p>
                                <p class="text-muted">Frequently asked questions</p>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col-md-->
                    <div class="col-6 col-lg-3">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <i class="fe fe-globe fe-32 text-warning"></i>
                                <a href="#">
                                    <h3 class="h5 mt-4 mb-1">Schedule 3</h3>
                                </a><br>
                                <p class="text-muted">Learn more about products?</p>
                                <p class="text-muted">Learn more about products?</p>
                                <p class="text-muted">Learn more about products?</p>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col-md-->
                    <div class="col-6 col-lg-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <i class="fe fe-alert-triangle fe-32 text-danger"></i>
                                <a href="#">
                                    <h3 class="h5 mt-4 mb-1">Schedule 4</h3>
                                </a><br>
                                <p class="text-muted">Report a bug</p>
                                <p class="text-muted">Report a bug</p>
                                <p class="text-muted">Report a bug</p>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col-md-->
                </div> <!-- .row --> --}}
            </div> <!-- .col-12 -->
            <!-- Fullscreen modal -->
            <div class="modal fade modal-full" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
              <button aria-label="" type="button" class="close px-2" data-dismiss="modal" aria-hidden="true">
                <span aria-hidden="true">×</span>
              </button>
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-body text-center">
                    <p> What would you like to schedule? </p>
                    <form class="form-inline justify-content-center">
                      <a href={{ route('products.create')}} class="btn btn-primary btn-lg mb-2 my-2 my-sm-0 m-2" type="submit">Post</a>
                      <a href={{ route('blogs.create')}} class="btn btn-primary btn-lg mb-2 my-2 my-sm-0 m-2" type="submit">Blog</a>
                    </form>
                  </div>
                </div>
              </div>
            </div> <!-- small modal -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
    @include('admin.layouts.partials.modals')
@endsection
