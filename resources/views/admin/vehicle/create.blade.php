@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Add Vehicle') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ __('Vehicle') }}</a></div>
                <div class="breadcrumb-item">{{ __('Add') }}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="card">
                <form action="{{ route('admin.vehicle.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-success mb-2">{{ session()->get('message') }}</div>
                        @endif

                        <div class="form-group" >
                            <label for="inputName">Name</label>
                            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus placeholder="Enter the vehicle name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputCarpark">Car park ID</label>
                            <input id="carpark_id" type="numbric" name="carpark_id" class="form-control @error('carpark_id') is-invalid @enderror" name="carpark_id" required autocomplete="carpark_id" autofocus placeholder="Enter the carpark id to which the vehicle belong to">
                            @error('carpark_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputStatus">Status</label>
                            <input id="status" type="" name="carpark_id" class="form-control @error('carpark_id') is-invalid @enderror" name="carpark_id" required autocomplete="carpark_id" autofocus placeholder="Enter the carpark id to which the vehicle belong to">
                        </div>
                        <div class="form-group">
                            <label for="inputCarpark">Car park ID</label>
                            <input id="carpark_id" type="numbric" name="carpark_id" class="form-control @error('carpark_id') is-invalid @enderror" name="carpark_id" required autocomplete="carpark_id" autofocus placeholder="Enter the carpark id to which the vehicle belong to">
                            @error('carpark_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputCarpark">Car park ID</label>
                            <input id="carpark_id" type="numbric" name="carpark_id" class="form-control @error('carpark_id') is-invalid @enderror" name="carpark_id" required autocomplete="carpark_id" autofocus placeholder="Enter the carpark id to which the vehicle belong to">
                            @error('carpark_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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
