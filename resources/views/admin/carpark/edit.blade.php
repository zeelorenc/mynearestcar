@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Edit Carpark') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ __('Carpark') }}</a></div>
                <div class="breadcrumb-item">{{ __('Edit') }}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="card">
                <form action="{{ route('admin.carpark.update', $carpark->id) }}" method="POST">
                    @csrf
                    {{ method_field('put') }}

                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-success mb-2">{{ session()->get('message') }}</div>
                        @endif

                        <div class="form-group" >
                            <label for="inputAddress">Name</label>
                            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $carpark->name }}" required autocomplete="name" autofocus placeholder="Enter the carpark name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Address</label>
                            <address-finder error-class="@error('latitude') is-invalid @enderror" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </section>

@endsection
