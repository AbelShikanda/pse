@extends('admin.layouts.app')
@section('nav')
@endsection
@section('sidebar')
@endsection

@section('content')
    <div style="min-height:100vh; display:flex; align-items:center; justify-content:center; background:radial-gradient(ellipse at 50% 0%, #171029 0%, var(--bg-0) 60%); padding:2rem">
        <form action="{{ route('postLogin') }}" method="POST" style="width:100%; max-width:420px; background:var(--bg-1); border:1px solid var(--border); border-radius:var(--r-lg); padding:2rem 1.75rem; box-shadow:var(--shadow-md)">
            @csrf
            <div style="text-align:center; margin-bottom:1.5rem">
                <img src="{{ asset('assets/img/logo.png') }}" alt="PrintShopEld" style="height:48px; margin-bottom:.9rem">
                <p class="admin-section-title" style="margin:0">Admin Panel</p>
                <h1 style="font-size:1.3rem; margin:.35rem 0 0; color:var(--text)">Sign in to continue</h1>
            </div>

            @if (Session('error'))
                <div class="alert alert-danger">{{ Session('error') }}</div>
            @endif
            @if (Session('success'))
                <div class="alert alert-success">{{ Session('success') }}</div>
            @endif

            <label class="form-label" for="inputEmail">Email</label>
            <input type="email" id="inputEmail" name="email" class="form-control" placeholder="admin@example.com" required autofocus autocomplete="username" style="margin-bottom:1rem">

            <label class="form-label" for="inputPassword">Password</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="••••••••" required autocomplete="current-password" style="margin-bottom:1.1rem">

            <button class="btn btn-primary btn-block" type="submit" style="width:100%; padding:.7rem; font-size:.95rem">Sign in <i class="fe fe-arrow-right"></i></button>
            <p class="text-muted" style="text-align:center; font-size:.75rem; margin:1.1rem 0 0">Authorized personnel only.</p>
        </form>
    </div>
@endsection
