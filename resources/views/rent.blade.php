@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Rent a Car</h1>
        </div>
        <div class="section-body">
            <map-component
                :vehicle-models='{!! $vehicleModels !!}'
            />
        </div>
    </section>

@endsection
