@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Search User') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ __('User') }}</a></div>
                <div class="breadcrumb-item">{{ __('Search') }}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.order.searchByUser') }}" method="POST">
                        <div class="form-group mb-0">
                            <div class="input-group">
                                @csrf
                                <input type="text" name="user_id" class="form-control form-control-lg" placeholder="Enter the user id you want to search">
                                <div class="input-group-append">
                                    <button class="btn btn-lg btn-primary">
                                        <i class="fas fa-search"></i> {{ __('Search') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-xl-6">
                    <div class="card">
                        <form method="post" class="needs-validation" novalidate="">
                            <div class="card-header">
                                <h4>User Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Name</label>
                                        <input type="text" class="form-control" value="Ujang" required="">
                                        <div class="invalid-feedback">
                                            Please fill in the name
                                        </div>
                                    </div>
                                    <div class="form-group col-md-7 col-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control" value="ujang@maman.com" required="">
                                        <div class="invalid-feedback">
                                            Please fill in the email
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5 col-12">
                                        <label>Phone</label>
                                        <input type="tel" class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-xl-6">
                    @if (count($orders))

                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Result') }}</h4>
                        </div>
                        <div class="card-body">
                            @if (session()->has('message'))
                                <div class="alert alert-success mb-4">{{ session()->get('message') }}</div>
                            @elseif (session()->has('error'))
                                <div class="alert alert-warning mb-4">{{ session()->get('error') }}</div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody><tr>
                                        <th>ID</th>
                                        <th>User id</th>
                                        <th>Vehicle id</th>
                                        <th>From date</th>
                                        <th>To date</th>
                                        <th>Uber pickup</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user_id }}</td>
                                        <td>{{ $order->vehicle_id }}</td>
                                        <td>{{ $order->from_date->toFormattedDateString() }}</td>
                                        <td>{{ $order->to_date->toFormattedDateString() }}</td>
                                        <td>{{ $order->uber_pickup ? 'Yes' : 'No' }}</td>
                                        <td>${{ $order->total }}</td>
                                        <td>{{ ucfirst($order->status) }}</td>
                                        <td>
                                            <form action="{{ route('admin.order.update', $order->id) }}" method="POST">
                                                @csrf
                                                {{ method_field('put') }}
                                                <button
                                                    class="btn btn-primary btn-block"
                                                    @if ($order->vehicle->status !== \App\Schemas\VehicleStatusSchema::RETURNED)
                                                        disabled="disabled"
                                                    @endif
                                                >
                                                    Confirm Return
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                    </tbody></table>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <nav class="d-inline-block">
                                {{ $orders->links() }}
                            </nav>
                        </div>
                    </div>

                    @endif
                </div>
            </div>

        </div>
    </section>

@endsection
