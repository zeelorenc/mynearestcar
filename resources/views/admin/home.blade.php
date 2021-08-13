@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <div class="section-body">
            <div class="hero text-white hero-bg-image hero-bg-parallax mb-4"
                 data-background="{{ asset('assets/img/unsplash/andre-benz-1214056-unsplash.jpg') }}"
                 style="background-image: url({{ asset('assets/img/unsplash/andre-benz-1214056-unsplash.jpg') }});">

                <div class="hero-inner">
                    <h1>Welcome!</h1>
                    <p class="lead">How is your day going?</p>
                </div>
            </div>

            <!-- Use the .card class for wrapping the content if you want add some content here -->
            <!--
            <div class="card">
                <div class="card-body">
                </div>
            </div>
            -->
        </div>
    </section>

@endsection
