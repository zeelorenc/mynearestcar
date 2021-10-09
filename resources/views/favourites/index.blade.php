@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('My Favorites') }}</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4>Your Recent Rentals</h4>
                    <div class="card-header-action">
                        <a href="{{ route('rent.index') }}" class="btn btn-primary">
                            Rent A Car
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">

                        <table class="table table-striped mb-0 table-scrollable">
                            <thead>
                            <tr>
                                <th>Vehicle</th>
                                <th>Type</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Seats</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->favourites as $favourite)
                                    <tr>
                                        <td>{{ $favourite->name }}</td>
                                        <td>{{ $favourite->type }}</td>
                                        <td>{{ $favourite->brand }}</td>
                                        <td>{{ $favourite->model }}</td>
                                        <td>{{ $favourite->seats }}</td>
                                        <td>
                                            <span class="badge badge-{{ $favourite->status === 'available' ? 'success' : 'danger' }}">
                                                {{ ucfirst($favourite->status === 'available' ? 'available' : 'unavailable') }}
                                            </span>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('rent.index') }}">View Vehicle</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
