@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">contacts Table</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p class="card-text">
                            contacts / stories 
                        </p>
                    </div>
                </div>
                <p class="card-text">
                </p>

                @if (Session('success'))
                    <div class="text-success text-center">
                        <strong>{{ Session('success') }}</strong>
                    </div>
                @endif
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <table class="table datatables" id="dataTable-1">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>email</th>
                                            <th>Subject</th>
                                            <th>message</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contacts as $contact)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input">
                                                        <label class="custom-control-label"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $contact->id }}</td>
                                                <td>{{ $contact->name }}</td>
                                                <td>{{ $contact->email }}</td>
                                                <td>{{ Str::words($contact->subject, 3, '...') }}</td>
                                                <td>{{ Str::words($contact->message, 3, '...') }}</td>
                                                <td><button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="{{ route('contact.show', $contact->id) }}">view</a>
                                                        {{-- <a class="dropdown-item"
                                                            href="{{ route('contact.edit', $contact->id) }}">Edit</a> --}}

                                                        {{-- <a class="dropdown-item" href="{{ route('contact.destroy', $contact->id) }}"
                                                            onclick="event.preventDefault();
                                                            document.getElementById('destroy-contact-{{ $contact->id }}').submit();">
                                                            {{ __('Remove') }}
                                                        </a>

                                                        <form id="destroy-contact-{{ $contact->id }}" action="{{ route('contact.destroy', $contact->id) }}"
                                                            method="post" class="d-none">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form> --}}
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
