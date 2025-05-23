@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Edit type</h2>
                <p class="text-muted">Edit this type for posting</p>

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
                                <strong class="card-title">types</strong>
                            </div>
                            <div class="card-body">
                                <form action={{ route('types.update', $types->id) }} method="POST" class="needs-validation"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">Name</label>
                                        <input type="text" name="name" class="form-control" id="validationCustom01" value="{{ $types->name }}" required>
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">Slug</label>
                                        <input type="text" name="slug" class="form-control" id="validationCustom01" value="{{ $types->slug }}" required>
                                        <div class="valid-feedback"> Looks good! </div>
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
