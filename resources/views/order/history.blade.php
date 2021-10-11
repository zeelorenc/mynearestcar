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
                        <h4>{{ __('Your rental history') }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('order.export') }}" class="btn btn-primary">Download .CSV Export</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success mb-4">{{ session()->get('message') }}</div>
                        @elseif (session()->has('error'))
                            <div class="alert alert-warning mb-4">{{ session()->get('error') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>@sortablelink('vehicle.name', 'Vehicle')</th>
                                        <th>@sortablelink('from_date', 'Start Date')</th>
                                        <th>@sortablelink('to_date', 'Rental Due')</th>
                                        <th>@sortablelink('status', 'Status')</th>
                                        <th>@sortablelink('total', 'Total')</th>
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
