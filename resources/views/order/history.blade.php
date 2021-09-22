@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Rental History') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ __('Order') }}</a></div>
                <div class="breadcrumb-item">{{ __('Rental History') }}</div>
            </div>
        </div>

        <div class="section-body">

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
                                <th>Created At</th>
                                <th>Updated At</th>
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user_id }}</td>
                                <td>{{ $order->vehicle_id }}</td>
                                <td>{{ $order->from_date->toFormattedDateString() }}</td>
                                <td>{{ $order->to_date->toFormattedDateString() }}</td>
                                <td>{{ $order->uber_pickup ? 'Yes' : 'No' }}</td>
                                <td>${{ $order->grand_total }}</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>{{ $order->updated_at }}</td>
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
    </section>

@endsection
