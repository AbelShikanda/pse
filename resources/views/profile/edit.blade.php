@extends('layouts.app')

@section('footer')
    {{-- Leave this section empty to exclude the footer --}}
@endsection

@section('content')
    {{-- @include('layouts.hero_profile') --}}
    <!-- ======= Blog Single Section ======= -->
    <br>
    <br>
    <br>

    <section class="content">
        <div class="content__left">

                @include('layouts.partials.profileNav')

        </div>

        <div class="content__middle">

            <div class="artist is-verified">

                <div class="artist__header"
                    style="background-image: url('{{ asset('assets/img/header.jpg') }}'); opacity: 0.5;">

                    <div class="artist__info">

                        <div class="artist__info__meta">

                            <div class="artist__info__type">{{ Auth::user()->email }}</div>

                            <div class="artist__info__name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                            </div>

                            <div class="artist__info__actions">

                                <button class="button-dark">
                                    <a href="{{ route('profile.index') }}" class="text-light">Home</a>
                                </button>

                                <button class="button-light">
                                    <a href="{{ route('profile.edit') }}">Edit</a>
                                </button>

                                <button class="button-light more">
                                    <i class="ion-ios-more"></i>
                                </button>

                            </div>

                        </div>


                    </div>

                    <div class="artist__listeners">

                        {{-- <div class="artist__listeners__count">15,662,810</div>

                        <div class="artist__listeners__label">Monthly Listeners</div> --}}

                    </div>

                    <div class="artist__navigation">



                        <ul class="nav nav-tabs" role="tablist">

                            <li role="presentation" class="active">
                                <a href="#artist-overview" aria-controls="artist-overview" role="tab"
                                    data-toggle="tab">Dashboard</a>
                            </li>

                        </ul>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger col-md-8 offset-md-3">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="pt-3">
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                        </div>

                        <div class="artist__navigation__friends">
                            <div class="artist__listeners__label">{{ Auth::user()->first_name }}
                                {{ Auth::user()->last_name }}</div>

                        </div>

                    </div>

                </div>

                <div class="artist__content">

                    <div class="tab-content">

                        <!-- Overview -->
                        <div role="tabpanel" class="tab-pane active" id="artist-overview">

                            <div class="overview">

                                <div class="overview__artist">

                                    <!-- Latest Release-->
                                    <div class="section-title">Edit Profile Details</div>
                                    <div class="container">

                                        @if (session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif

                                        <form action="{{ route('profile.update') }}" method="POST">
                                            @method('patch')
                                            @csrf

                                            <div class="mb-3">
                                                <label class="form-label p-form-label">First Name</label>
                                                <input type="text" name="first_name" class="form-control p-form-control"
                                                    value="{{ old('first_name', $user->first_name) }}" required>
                                                @error('first_name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label p-form-label">Last Name</label>
                                                <input type="text" name="last_name" class="form-control p-form-control"
                                                    value="{{ old('last_name', $user->last_name) }}" required>
                                                @error('last_name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label p-form-label">Email</label>
                                                <input type="email" name="email" class="form-control p-form-control"
                                                    value="{{ old('email', $user->email) }}" required>
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label p-form-label">Gender</label>
                                                <select name="gender" class="form-control p-form-control">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male"
                                                        {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male
                                                    </option>
                                                    <option value="Female"
                                                        {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>
                                                        Female</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label p-form-label">Phone</label>
                                                <input type="text" name="phone" class="form-control p-form-control"
                                                    value="{{ old('phone', $user->phone) }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label p-form-label">Town</label>
                                                <input type="text" name="town" class="form-control p-form-control"
                                                    value="{{ old('town', $user->town) }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label p-form-label">Location</label>
                                                <input type="text" name="location" class="form-control p-form-control"
                                                    value="{{ old('location', $user->location) }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label p-form-label">New Password (optional)</label>
                                                <input type="password" name="password" class="form-control p-form-control">
                                                @error('password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label p-form-label">Confirm Password</label>
                                                <input type="password" name="password_confirmation" class="form-control p-form-control">
                                            </div>

                                            <button type="submit" class="btn btn-primary p-btn-primary">Update Profile</button>
                                        </form>
                                    </div>

                                </div>
                                <!-- / -->

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        </div>

        </div>

        </div>

        </div>

    </section>
@endsection
