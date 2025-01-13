@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Edit product_images Posts</h2>
                <p class="text-muted">Edit product_images available for posting</p>
                <div class="row">
                    <div class="col-md-8 offset-2">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Edit product_images Posts</strong>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('product_images.update', $image->id) }}" method="POST"
                                    class="needs-validation" novalidate enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom01">products</label>
                                                <select class="form-control select2" style="width: 100%;" name="product">
                                                    @if ($product)
                                                        <option value="{{ $product->id }}" selected>{{ $product->name }}
                                                        </option>
                                                    @endif
                                                </select>
                                                <div class="valid-feedback"> Looks good! </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    @if ($image->thumbnail)
                                                        <img src="{{ asset('storage/img/products/' . $image->thumbnail) }}"
                                                            alt="{{$image->full}}"
                                                            style="max-width: 200px; margin-right: 10px;">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="validationCustom01">Image</label>
                                                    <div class="input-group">
                                                        <input class="file-path validate form-control"
                                                            id="validationCustom01" name="filepath" type="file"
                                                            placeholder="Select file to upload">
                                                    </div>
                                                    <div class="valid-feedback"> Looks good! </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom01">Caption</label>
                                                <input type="text" name="full" class="form-control"
                                                    id="validationCustom01" value="{{ $image->full }}" required>
                                                <div class="valid-feedback"> Looks good! </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </form>
                            </div> <!-- /.card-body -->
                        </div> <!-- /.card -->
                    </div> <!-- /.col -->
                </div> <!-- end section -->
            </div> <!-- /.col-12 col-lg-10 col-xl-10 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
    @include('admin.layouts.partials.modals')
@endsection
