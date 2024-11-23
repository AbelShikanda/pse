@extends('admin.layouts.app')
@section('nav')
    {{-- Leave this section empty to exclude the sidebar --}}
@endsection
@section('sidebar')
    {{-- Leave this section empty to exclude the sidebar --}}
@endsection

@section('content')
    <div class="row align-items-center h-100">
        <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" action="{{ route('postLogin') }}" method="POST">
            @csrf
            @if (Session('error'))
                <div class="text-danger text-center">
                    <strong>{{ Session('error') }}</strong>
                </div>
            @endif
            @if (Session('success'))
                <div class="text-success text-center">
                    <strong>{{ Session('success') }}</strong>
                </div>
            @endif
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ asset('/') }}">
                <img src="{{ asset('admin/assets/images/logo.png') }}" alt="logo" class="w-50">
            </a>
            <h1 class="h6 mb-3">Login in</h1>
            <div class="form-group">
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" class="form-control form-control-lg" placeholder="Email address"
                    required="" autofocus="" name="email">
            </div>
            <div class="form-group">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" class="form-control form-control-lg" placeholder="Password"
                    required="" name="password">
            </div>
            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Stay logged in </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Let me in</button>
            <p class="mt-5 mb-3 text-muted">© 2024</p>
        </form>
    </div>
@endsection
