@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Add Car Park') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ __('Car Park') }}</a></div>
                <div class="breadcrumb-item">{{ __('Add') }}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="card">
                <form action="{{ route('admin.carpark.save') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-success mb-2">{{ session()->get('message') }}</div>
                        @endif

                        <div class="form-group" >
                            <label for="inputAddress">Name</label>
                            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus placeholder="Enter the car park name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Address</label>
                            <address-finder error-class="@error('latitude') is-invalid @enderror"/>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </section>

@endsection
