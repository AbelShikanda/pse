@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Blogs Table</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p class="card-text">
                            blogs / stories
                        </p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('blogs.create') }}" type="button"
                            class=" float-right btn mb-2 btn-outline-primary">Add blog</a>
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
                                            <th>Title</th>
                                            <th>Whatsapp</th>
                                            <th>Telegram</th>
                                            <th>Website</th>
                                            <th>Last Update</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($blogs as $blog)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input">
                                                        <label class="custom-control-label"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $blog->id }}</td>
                                                <td>{{ $blog->title }}</td>
                                                <td>{{ $blog->whatsapp }}</td>
                                                <td>{{ $blog->telegram }}</td>
                                                <td>{{ $blog->website }}</td>
                                                <td>{{ $blog->updated_at }}</td>
                                                <td><button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        {{-- <a class="dropdown-item"
                                                            href="{{ route('blogs.show', $blog->id) }}">view</a> --}}
                                                        <a class="dropdown-item"
                                                            href="{{ route('blogs.edit', $blog->id) }}">Edit</a>

                                                        @if ($blog->BlogImage->isEmpty())
                                                        <a class="dropdown-item"
                                                            href="{{ route('blog_images.create') }}">Add Image</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('blogs.destroy', $blog->id) }}"
                                                                onclick="event.preventDefault();
                                                                document.getElementById('destroy-blog-{{ $blog->id }}').submit();">
                                                                {{ __('Remove') }}
                                                            </a>

                                                            <form id="destroy-blog-{{ $blog->id }}"
                                                                action="{{ route('blogs.destroy', $blog->id) }}"
                                                                method="post" class="d-none">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                            @else
                                                            <a class="dropdown-item"
                                                                href="{{ route('blog_images.index') }}">Remove image first</a>
                                                        @endif

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
