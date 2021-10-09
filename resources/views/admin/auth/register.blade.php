@extends('layouts.auth')

@section('content')

    <div class="card card-info">
        <div class="card-header"><h4>{{ __('Admin Register') }}</h4></div>

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="role" value="admin">

                <div class="form-group row mb-2">
                    <label for="name" class="col-md-12 col-form-label">{{ __('Name') }}</label>

                    <div class="col-md-12">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label for="email" class="col-md-12 col-form-label">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label for="password" class="col-md-12 col-form-label">{{ __('Password') }}</label>

                    <div class="col-md-12">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" />

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-12 col-form-label">{{ __('Confirm Password') }}</label>

                    <div class="col-md-12">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-block btn-info">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <div class="mt-5 text-muted text-center">
        <p>Already have an account? <a href="{{ route('admin.login') }}">Go to login</a></p>
    </div>

@endsection
