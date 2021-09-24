@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Carpark List') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ __('Carpark') }}</a></div>
                <div class="breadcrumb-item">{{ __('List') }}</div>
            </div>
        </div>

        <div class="section-body">

            <!--<div class="card">
                <div class="card-body">

                    <form action="">
                        <div class="form-group mb-0">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg"
                                       placeholder="Enter information you want to search">
                                <div class="input-group-append">
                                    <button class="btn btn-lg btn-primary" type="button">
                                        <i class="fas fa-search"></i> {{ __('Search') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>-->

            <div class="card">
                <div class="card-body">
                    @if (session('message'))
                        <p class="alert alert-success">{{ session('message') }}</p>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Coordinates (Lat, Long)</th>
                                <th>Vehicles</th>
                                <th>Created At</th>
                                <th></th>
                            </tr>
                            @foreach ($carparks as $carpark)
                                <tr>
                                    <td>{{ $carpark->id }}</td>
                                    <td>{{ $carpark->name }}</td>
                                    <td>{{ $carpark->lat }}, {{ $carpark->lng }}</td>
                                    <td>{{ $carpark->vehicles->count() }}</td>
                                    <td>{{ $carpark->created_at->toFormattedDateString() }}</td>
                                    <td>
                                        <!-- <a href="{{ route('admin.carpark.edit', $carpark->id) }}" class="btn btn-primary">Edit</a> -->
                                        <form method="POST" action="{{ route('admin.carpark.destroy', $carpark->id) }}" onsubmit="return confirm('Are you sure want to delete this?')">
                                            @csrf
                                            {{ method_field('delete') }}
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <nav class="d-inline-block">
                        {{ $carparks->links() }}
                    </nav>
                </div>
            </div>

        </div>
    </section>

@endsection
