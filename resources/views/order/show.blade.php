@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ "Confirm Order #{$order->id}" }}</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-body">
                    <div class="card-title">Order information</div>

                    <form action="">
                        <table class="table table-striped">
                            <tr>
                                <td><i class="fas fa-parking mr-2"></i> Carpark</td>
                                <td>{{ $order->vehicle->carpark->name }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-car-side mr-2"></i> Vehicle</td>
                                <td>{{ $order->vehicle->name }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-calendar-alt mr-2"></i> Pickup Date</td>
                                <td>{{ $order->from_date->toDayDateTimeString() }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-calendar-alt mr-2"></i> Drop-off Date</td>
                                <td>{{ $order->to_date->toDayDateTimeString() }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-taxi mr-2"></i> Uber</td>
                                <td>{{ $order->uber_pickup ? "UBER ORDERED" : "UBER NOT ORDERED" }}</td>
                            </tr>
                        </table>

                        <div class="row mt-5">
                            <div class="col-8 offset-4 text-right">
                                <div class="text-dark h5">
                                    Total: <b>${{ number_format($order->total, 2) }}</b>
                                </div>
                                <order-payment :order="{{ $order }}"/>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </section>

@endsection
