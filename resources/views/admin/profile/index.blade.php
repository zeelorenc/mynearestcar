@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('My Profile') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ __('Profile') }}</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Hi, {{ $user->name }}!</h2>
            <p class="section-lead">
                Change information about yourself on this page.
            </p>


            <div class="row mt-sm-4">
                <div class="col-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="{{ asset('assets/img/avatar/avatar-4.png') }}" class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Role</div>
                                    <div class="profile-widget-item-value">{{ $user->role }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-widget-description">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Name:</span>
                                    <b>{{ $user->name }}</b>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Phone Number:</span>
                                    <b></b>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Email:</span>
                                    <b>{{ $user->email }}</b>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <form method="POST" action="{{ route('admin.profile.update', $user->id) }}">
                            @csrf
                            {{ method_field('put') }}

                            <div class="card-header">
                                <h4>Edit Profile</h4>
                            </div>

                            <div class="card-body">
                                @if(session()->has('message'))
                                    <div class="alert alert-success mb-2">{{ session()->get('message') }}</div>
                                @endif

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ $user->email }}" autocomplete="email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-primary">{{ __('Save Changes') }}</button>
                            </div>
                        </form>
                    </div>

                    <div class="card">
                        <form method="post">
                            <div class="card-header">
                                <h4>Change Password</h4>
                            </div>
                            <div class="card-body">
                                @if(session()->has('message'))
                                    <div class="alert alert-success mb-2">{{ session()->get('message') }}</div>
                                @endif

                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label for="pwd">Password *</label>
                                        <input type="password" id="pwd" class="form-control" name="pwd[password]" required="">
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label for="repwd">Confirm Password *</label>
                                        <input type="password" id="repwd" class="form-control" name="pwd[repwd]" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary">{{ __('Save Changes') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>


@endsection
