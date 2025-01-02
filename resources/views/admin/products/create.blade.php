@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Products Posts</h2>
                <p class="text-muted">add more products for posting</p>

                @if (count($errors) > 0)
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
                                <strong class="card-title">Product Posts</strong>
                            </div>
                            <div class="card-body">
                                <form action={{ route('products.store') }} method="POST" class="needs-validation"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('post')
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">Name</label>
                                        <input type="text" name="name" class="form-control" id="validationCustom01" value="caption"
                                            >
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">meta_title</label>
                                        <input type="text" name="meta_title" class="form-control" id="validationCustom01" value="meta_title"
                                            >
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">meta_description</label>
                                        <input type="text" name="meta_description" class="form-control" id="validationCustom01" value="meta_description"
                                            >
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">meta_keywords</label>
                                        <input type="text" name="meta_keywords" class="form-control" id="validationCustom01" value="meta_keywords"
                                            >
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">meta_image</label>
                                        <input type="text" name="meta_image" class="form-control" id="validationCustom01" value="meta_image"
                                            >
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">category</label>
                                        <select class="form-control select2" style="width: 100%;" name="category">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @selected(old('category') == $category)>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">type</label>
                                        <select class="form-control select2" style="width: 100%;" name="type">
                                            @foreach ($product_types as $types)
                                                <option value="{{ $types->id }}" @selected(old('types') == $types)>
                                                    {{ $types->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">color</label>
                                        <select class="form-control select2" style="width: 100%;" name="color">
                                            @foreach ($colors as $types)
                                                <option value="{{ $types->id }}" @selected(old('types') == $types)>
                                                    {{ $types->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">size</label>
                                        <select class="form-control select2" style="width: 100%;" name="size">
                                            @foreach ($sizes as $types)
                                                <option value="{{ $types->id }}" @selected(old('types') == $types)>
                                                    {{ $types->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">material</label>
                                        <select class="form-control select2" style="width: 100%;" name="material">
                                            @foreach ($materials as $types)
                                                <option value="{{ $types->id }}" @selected(old('types') == $types)>
                                                    {{ $types->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="validationTextarea">Description</label>
                                        <textarea class="form-control" name="description" id="validationTextarea" placeholder="Required example textarea" required></textarea>
                                        <div class="invalid-feedback"> Please enter a message in the
                                            textarea. </div>
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
