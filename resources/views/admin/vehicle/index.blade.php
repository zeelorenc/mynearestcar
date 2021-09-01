@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Vehicle List') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ __('Vehicle') }}</a></div>
                <div class="breadcrumb-item">{{ __('List') }}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-body">

                    <form action="">
                        <div class="form-group mb-0">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg" placeholder="Enter information you want to search">
                                <div class="input-group-append">
                                    <button class="btn btn-lg btn-primary" type="button">
                                        <i class="fas fa-search"></i> {{ __('Search') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Result') }}</h4>
                </div>
                {{-- <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <tbody><tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Irwansyah Saputra</td>
                                <td>2017-01-09</td>
                                <td><div class="badge badge-success">Active</div></td>
                                <td><a href="#" class="btn btn-secondary">Detail</a></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Hasan Basri</td>
                                <td>2017-01-09</td>
                                <td><div class="badge badge-success">Active</div></td>
                                <td><a href="#" class="btn btn-secondary">Detail</a></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Kusnadi</td>
                                <td>2017-01-11</td>
                                <td><div class="badge badge-danger">Not Active</div></td>
                                <td><a href="#" class="btn btn-secondary">Detail</a></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Rizal Fakhri</td>
                                <td>2017-01-11</td>
                                <td><div class="badge badge-success">Active</div></td>
                                <td><a href="#" class="btn btn-secondary">Detail</a></td>
                            </tr>
                            </tbody></table>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <nav class="d-inline-block">
                        <ul class="pagination mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div> --}}

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Car Park ID</th>
                                <th>Status</th>
                                <th>Price</th>
                                <th>Seats</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th></th>
                            </tr>
                            @foreach ($vehicles as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->id }}</td>
                                    <td>{{ $vehicle->name }}</td>
                                    <td>{{ $vehicle->carpark_id }}</td>
                                    <td>{{ $vehicle->status }}</td>
                                    <td>{{ $vehicle->price }}</td>
                                    <td>{{ $vehicle->seats }}</td>
                                    <td>{{ $vehicle->created_at->toFormattedDateString() }}</td>
                                    <td>{{ $vehicle->updated_at->toFormattedDateString() }}</td>
                                    <td><a href="{{ route('admin.vehicle.edit', $vehicle->id) }}" class="btn btn-primary">Edit</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <nav class="d-inline-block">
                        {{ $vehicles->links() }}
                    </nav>
                </div>
            </div>

        </div>
    </section>

@endsection
