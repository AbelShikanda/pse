@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h3 mb-4 page-title">contacts Details</h2>
                <div class="row mt-5 align-items-center">
                    <div class="col-md-3 text-center mb-5">
                        <div class="avatar avatar-xl">
                            <img src="./assets/avatars/face-1.jpg" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </div>
                    <div class="col">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-md-6">
                                <h4 class="mb-1">{{ $contacts->name }}</h4>
                                <p class="small mb-3"><span class="badge badge-dark">Created on:
                                        {{ $contacts->created_at }}</span></p>
                                <div class="">
                                    <p class="text-muted">
                                        {{ $contacts->subject }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                        </div>
                    </div>
                </div>
                <h3>About contacts</h3>
                <p class="text-muted">This is a desctiption about {{ $contacts->name }}.</p>
                <div class="card-deck my-4">
                    <div class="card mb-4">
                        <div class="card-body text-center my-4">
                            <span class="h1 mb-0">{{ $contacts->name }}</span>
                            <a href="#">
                                <h3 class="h5 mt-4 mb-0">{{ $contacts->email }}</h3>
                            </a>
                            <p class="text-muted">{{ $contacts->subject }}</p>
                            <p class="text-muted">{{ $contacts->message }}</p>
                            <div class="row">
                                <div class="col-md-5"></div>
                                {{-- <div class="col">
                                    <a class="btn mb-2 btn-warning btn-lg"
                                        href="{{ route('contacts.edit', $contacts->id) }}">Edit</a>
                                </div>
                                <div class="col">
                                    <form action="{{ route('contacts.destroy', $contacts->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn mb-2 btn-danger btn-lg">Remove</button>
                                    </form>
                                </div> --}}
                                <div class="col-md-5"></div>
                            </div>
                        </div> <!-- .card-body -->
                    </div> <!-- .card -->
                </div> <!-- .card-group -->
            </div> <!-- /.col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
@endsection
