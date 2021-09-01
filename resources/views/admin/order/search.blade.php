@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Search Order') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ __('Order') }}</a></div>
                <div class="breadcrumb-item">{{ __('Search') }}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.order.search') }}" method="POST">
                        <div class="form-group mb-0">
                            <div class="input-group">
                                @csrf
                                <input type="text" name="vehicle_id" class="form-control form-control-lg" placeholder="Enter the vehicle id you want to search">
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

            @if (count($orders))

            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Result') }}</h4>
                </div>
                <div class="card-body">
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
                                <th>Stripe charge id</th>
                                <th>User location (Lat, Long)</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th></th>
                            </tr>
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user_id }}</td>
                                <td>{{ $order->vehicle_id }}</td>
                                <td>{{ $order->from_date->toFormattedDateString() }}</td>
                                <td>{{ $order->to_date->toFormattedDateString() }}</td>
                                <td>{{ $order->uber_pickup }}</td>
                                <td>{{ $order->total }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->stripe_charge_id }}</td>
                                <td>{{ $order->user_location['lat'] }}, {{ $order->user_location['lng'] }}</td>
                                <td>{{ $order->created_at->toFormattedDateString() }}</td>
                                <td>{{ $order->updated_at->toFormattedDateString() }}</td>
                                <td>
                                    <form action="{{ route('admin.order.update', $order->id) }}" method="POST">
                                        @csrf
                                        {{ method_field('put') }}
                                        <button class="btn btn-primary">Returned</button>
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
    </section>

@endsection
