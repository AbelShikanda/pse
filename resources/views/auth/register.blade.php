@extends('layouts.app')
@section('header')
    {{-- Leave this section empty to exclude the sidebar --}}
@endsection
@section('footer')
    {{-- Leave this section empty to exclude the sidebar --}}
@endsection

@section('content')
    <div class="container pt-5 mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="register-box">
                    <form class="form"method="POST" action="{{ route('register') }}">
                        @csrf
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                        <div class="card-header text-center mb-4">{{ __('Register') }}</div>
                        <a href="{{ url('/') }}" class=" register-box-logo text-center"><img
                                src="{{ asset('assets/img/logo.png') }}" alt=""></a>
                        <div class="row">
                            <div class="col">
                                <div class="inputregister-box">
                                    <input type="text"
                                        name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name"
                                        autofocus>
                                    <span>Frist Name</span>
                                    <i></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="inputregister-box">
                                    <input type="text" name="last_name"
                                        value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
                                    <span>Last Name</span>
                                    <i></i>
                                </div>
                            </div>
                        </div>
                        <div class="inputregister-box">
                            <input type="text" name="phone"
                                value="{{ old('phone') }}" required autocomplete="phone" autofocus>
                            <span>Phone</span>
                            <i></i>
                        </div>
                        <div class="inputregister-box">
                            <input type="email" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <span>Email</span>
                            <i></i>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="inputregister-box">
                                    <input type="text" name="town"
                                        value="{{ old('town') }}" required autocomplete="town" autofocus>
                                    <span>Town</span>
                                    <i></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="inputregister-box">
                                    <input type="text" name="location"
                                        value="{{ old('location') }}" required autocomplete="location" autofocus>
                                    <span>clossest location for delivery</span>
                                    <i></i>
                                </div>
                            </div>
                        </div>
                        <div class="inputregister-box">
                            <input type="password" name="password" required
                                autocomplete="new-password">
                            <span>Password</span>
                            <i></i>
                        </div>
                        <div class="inputregister-box">
                            <input type="password" name="password_confirmation" required autocomplete="new-password">
                            <span>Password Confirmation</span>
                            <i></i>
                        </div>
                        {{-- <input type="submit" value="Register"> --}}
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                        <div class="links">
                            <a href="{{ route('password.request') }}">Forget password</a>
                            <a href="{{ route('login') }}">Log In</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
