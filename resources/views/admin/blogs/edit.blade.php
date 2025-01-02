@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Blogs Edits Posts</h2>
                <p class="text-muted">add more Blogs Edits for posting</p>

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
                                <strong class="card-title">Edit Blog Posts</strong>
                            </div>
                            <div class="card-body">
                                <form action={{ route('blogs.update', $blogs->id) }} method="POST" class="needs-validation"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">Title</label>
                                        <input type="text" name="title" class="form-control" id="validationCustom01"
                                            value="{{ $blogs->title }}" required>
                                        <input type="text" name="slug" class="form-control" id="validationCustom01"
                                            value="{{ $blogs->slug }}" required hidden>
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">Sub Title</label>
                                        <input type="text" name="subtitle" class="form-control" id="validationCustom01"
                                            value="{{ $blogs->sub_title }}" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">category</label>
                                        <select class="form-control select2" style="width: 100%;" name="category">
                                            @if ($category)
                                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                            @endif
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @selected(old('category') == $category)>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="validationTextarea">Body</label>
                                        <textarea class="form-control" name="body" id="validationTextarea" placeholder="Required example textarea" rows="20" cols="0" required>{{ $blogs->body }}</textarea>
                                        <div class="invalid-feedback"> </div>
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
