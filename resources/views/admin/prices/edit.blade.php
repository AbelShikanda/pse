@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">edit prices Posts</h2>
                <p class="text-muted">edit prices available for posting</p>
                <div class="row">
                    <div class="col-md-8 offset-2">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">edit prices Posts</strong>
                            </div>
                            <div class="card-body">
                                <form action={{ route('prices.update', $prices->id) }} method="POST" class="needs-validation" novalidate>
                                    @csrf
                                    @method('patch')

                                    <div class="row">
                                        <div class="col-md-8 col-sm-12">
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom01">Type of edit products</label>
                                                <select class="form-control select2" style="width: 100%;" name="types">
                                                    @if ($type)
                                                        <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                                                    @endif
                                                    @foreach($types as $t)
                                                        <option value="{{ $t->id }}" @selected(old('t') == $t)>{{ $t->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="valid-feedback"> Looks good! </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom01">Amount</label>
                                                <input name="price" type="text" class="form-control" id="validationCustom01" value="{{ $prices->price }}"
                                                    required>
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
