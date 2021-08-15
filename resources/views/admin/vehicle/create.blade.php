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

                        <div class="row">
                            <div class="col">
                                <div class="form-group" >
                                    <label for="inputName">Name</label>
                                    <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus placeholder="Enter the vehicle name">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                <label for="inputCarpark">Car park ID</label>
                                <input id="carpark_id" type="numeric" name="carpark_id" class="form-control @error('carpark_id') is-invalid @enderror" name="carpark_id" required autocomplete="carpark_id" autofocus placeholder="Enter the carpark id to which the vehicle belong to">
                                @error('carpark_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputStatus">Status</label>
                                    <select id="status" name="status" class="form-select form-control" aria-label="Select the vehicle's status" >
                                        <option selected value="available">available</option>
                                        <option value="pending">pending</option>
                                        <option value="booked">booked</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputPrice">Price</label>
                                    <input id="price" type="numeric" name="price" class="form-control" error-class="@error('price') is-invalid @enderror" name="price" required autocomplete="price" autofocus placeholder="Enter the price">
                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputSeats">Seats</label>
                                    <input id="seats" type="numeric" name="seats" class="form-control" error-class="@error('seats') is-invalid @enderror" name="seats" required autocomplete="seats" autofocus placeholder="Enter the seats">
                                    @error('seats')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
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
