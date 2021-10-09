@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1 class="w-100 d-flex align-items-center justify-content-between">
                <span>{{ "Rental Booking Order #{$order->id}" }}</span>
                <small class="text-{{ \App\Schemas\OrderStatusSchema::asCssClass($order->status) }} font-weight-bold">
                    {{ strtoupper($order->status) }}
                </small>
            </h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4>Order information</h4>
                </div>
                <div class="card-body">
                    <form action="">
                        <table class="table table-striped">
                            <tr>
                                <td><i class="fas fa-map-pin mr-2"></i> Order Location</td>
                                <td>{!! $orderOrigin ?? '<i>Order origin unknown</i>' !!}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-parking mr-2"></i> Carpark</td>
                                <td>{{ $order->vehicle->carpark->name }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-car-side mr-2"></i> Vehicle</td>
                                <td>
                                    <div class="mt-3 d-flex justify-content-between">
                                        <p><i class="fas fa-car mr-1"></i> {{ $order->vehicle->name }}</p>
                                        <p class="text-muted"><i class="fas fa-user-friends mr-1"></i> {{ $order->vehicle->seats }} seats</p>
                                        <p class="text-muted"><i class="fas fa-vr-cardboard mr-1"></i> {{ ucwords($order->vehicle->type) }}</p>
                                        <p class="text-muted"><i class="fas fa-copyright mr-1"></i> {{ $order->vehicle->brand }}</p>
                                        <p class="text-muted"><i class="fas fa-car-side mr-1"></i> {{ $order->vehicle->model }}</p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-calendar-alt mr-2"></i> Pickup Date</td>
                                <td>{{ $order->from_date->toDayDateTimeString() }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-calendar-alt mr-2"></i> Drop-off Date</td>
                                <td>{{ $order->to_date->toDayDateTimeString() }}</td>
                            </tr>
                            @if ($order->uber)
                                <tr>
                                    <td><i class="fas fa-taxi mr-2"></i> Uber</td>
                                    <td style="padding: 20px">
                                        <div class="mb-2">
                                            <order-map
                                                :carpark='{!! $order->vehicle->carpark !!}'
                                                :vehicle='{!! $order->vehicle !!}'
                                                :route='{!! json_encode($order->uber->route_data) !!}'
                                                :start-location='{!! json_encode($order->user_location) !!}'
                                                :visible="true"
                                            />
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="m-0">Total ${{ number_format($order->uber->total, 2) }} for {{ number_format($order->uber->distance / 1000, 2) }} km trip</p>
                                                @if ($order->status !== \App\Schemas\OrderStatusSchema::PAID)
                                                    <p class="m-0"><i>Your uber will be called as soon as payment has been processed</i></p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td><i class="fas fa-file-invoice-dollar mr-2"></i> Cost</td>
                                <td>
                                    {{ $order->from_date->diffInDays($order->to_date) }} days
                                    @ ${{ $order->vehicle->price }} per day
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-file-contract mr-2"></i> Security Deposit</td>
                                <td>
                                    ${{ number_format($order->security_deposit, 2) }}
                                </td>
                            </tr>
                        </table>

                        <div class="row mt-5">
                            <div class="col-8 offset-4 text-right">
                                <div class="text-dark h5">
                                    Total: <b>${{ number_format($order->grand_total + $order->security_deposit, 2) }}</b>
                                </div>

                                @if ($order->paid()  && $order->vehicle->returned())
                                    <small class="text-info">Fully paid on {{ $order->updated_at->toDayDateTimeString() }}</small>
                                    <span>Waiting for confirmation.</span>
                                @elseif ($order->paid() && !$order->vehicle->returned())
                                    <small class="text-info d-block">Fully paid on {{ $order->updated_at->toDayDateTimeString() }}</small>
                                    <a href="{{ route('order.return', $order->id) }}" class="btn mt-3 btn-primary">Return Vehicle</a>
                                @else
                                    <order-payment :order="{{ $order }}"/>
                                @endif
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </section>

@endsection
