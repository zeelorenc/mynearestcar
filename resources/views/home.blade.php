@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Welcome back, {{ $currentUser->name }}</h1>
        </div>
        <div class="section-body">
            <div class="card card-warning">
                <div class="card-header">
                    <h4><span class="text-warning">Save 50%</span> on rentals near the airport this weekend!</h4>
                    <div class="card-header-action">
                        <a href="{{ route('rent.index') }}" class="btn btn-warning">
                            View Rental Deals
                        </a>
                    </div>
                </div>
            </div>

            @if ($currentOrder)
                <div class="card card-success">
                    <div class="card-header">
                        <h4>Your {{ $currentOrder->vehicle->name }} is due in {{ $currentOrder->to_date->diffForHumans() }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('order.show', $currentOrder->id) }}" class="btn btn-success">
                                View Order
                            </a>
                        </div>
                    </div>
                </div>
            @endif

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
                                <th>Start Date</th>
                                <th>Rental Due</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->vehicle->name }}</td>
                                        <td>{{ $order->from_date->toDayDateTimeString() }}</td>
                                        <td>{{ $order->to_date->toDayDateTimeString() }}</td>
                                        <td>
                                            <span class="badge badge-{{ \App\Schemas\OrderStatusSchema::asCssClass($order->status) }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>${{ number_format($order->grand_total, 2) }}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('order.show', $order->id) }}">View Order</a>
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
