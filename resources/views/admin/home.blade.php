@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Admin Dashboard</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Users</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUsers }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-dark">
                            <i class="fas fa-parking"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Carparks</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalCarparks }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Vehicles</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalVehicles }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Orders</h4>
                            </div>
                            <div class="card-body">
                                todo
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Overdue Rentals</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.order.search') }}" class="btn btn-primary">Search Orders</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>User</th>
                                    <th>Vehicle</th>
                                    <th>Rental Started</th>
                                    <th>Rental Due</th>
                                    <th>Uber pickup</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($delayedOrders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->vehicle->name }}</td>
                                        <td>{{ $order->from_date->toFormattedDateString() }}</td>
                                        <td>{{ $order->to_date->toFormattedDateString() }}</td>
                                        <td>{{ $order->uber_pickup ? 'Yes' : 'No' }}</td>
                                        <td>${{ $order->grand_total }}</td>
                                        <td>{{ ucfirst($order->status) }}</td>
                                        <td>
                                            <form action="{{ route('admin.order.complete', $order->id) }}" method="POST">
                                                @csrf
                                                {{ method_field('put') }}
                                                <button
                                                    class="btn btn-primary btn-block"
                                                >
                                                    Force Complete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Nothing overdue yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <nav class="d-inline-block">
                        {{ $delayedOrders->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </section>

@endsection
