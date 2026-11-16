@extends('layouts.app')

@section('content')
    <section class="ps-page-band">
        <div class="ps-container">
            <span class="ps-eyebrow">Account</span>
            <h1>Edit <em style="font-style:italic;color:var(--brand-3)">profile</em></h1>
            <p class="ps-lead">Keep your details fresh — we use phone and town for delivery.</p>
        </div>
    </section>

    <section class="ps-section" style="padding-top:2.5rem">
        <div class="ps-container" style="max-width:760px">
            @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

            <form action="{{ route('profile.update') }}" method="POST">
                @method('PATCH')
                @csrf
                <div class="row gy-3">
                    <div class="col-md-6"><label class="form-label" for="first_name">First name</label><input id="first_name" type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" required>@error('first_name')<small class="text-danger">{{ $message }}</small>@enderror</div>
                    <div class="col-md-6"><label class="form-label" for="last_name">Last name</label><input id="last_name" type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}" required>@error('last_name')<small class="text-danger">{{ $message }}</small>@enderror</div>
                    <div class="col-12"><label class="form-label" for="email">Email</label><input id="email" type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>@error('email')<small class="text-danger">{{ $message }}</small>@enderror</div>
                    <div class="col-md-4"><label class="form-label" for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-select">
                            <option value="">Select…</option>
                            @foreach (['Male', 'Female'] as $option)
                                <option value="{{ $option }}" {{ old('gender', $user->gender) === $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4"><label class="form-label" for="phone">Phone</label><input id="phone" type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">@error('phone')<small class="text-danger">{{ $message }}</small>@enderror</div>
                    <div class="col-md-4"><label class="form-label" for="town">Town</label><input id="town" type="text" name="town" class="form-control" value="{{ old('town', $user->town) }}"></div>
                    <div class="col-12"><label class="form-label" for="location">Location</label><input id="location" type="text" name="location" class="form-control" value="{{ old('location', $user->location) }}"></div>
                    <div class="col-md-6"><label class="form-label" for="password">New password (optional)</label><input id="password" type="password" name="password" class="form-control" autocomplete="new-password">@error('password')<small class="text-danger">{{ $message }}</small>@enderror</div>
                    <div class="col-md-6"><label class="form-label" for="password_confirmation">Confirm password</label><input id="password_confirmation" type="password" name="password_confirmation" class="form-control" autocomplete="new-password"></div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="ps-btn"><i class="bi bi-check2"></i> Update profile</button>
                    <a href="{{ route('profile.index') }}" class="ps-btn ps-btn--ghost" style="box-shadow:none">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection
