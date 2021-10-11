@extends('layouts.landing')

@section('content')

    <section>
        <div class="hero rounded-0 text-white hero-bg-image hero-bg-parallax vh-100"
             style="background-image: url('https://demo.getstisla.com/assets/img/unsplash/andre-benz-1214056-unsplash.jpg');">

            <div class="hero-inner text-center">
                <div>
                    <h1 class="display-1 mb-5">My Nearest Car</h1>
                    <p class="lead mb-5" style="font-size: 1.5rem">You almost arrived, register a new account or log into your account renting a car.</p>

                    <a href="{{ route('home') }}" class="btn btn-primary shadow-none rounded-pill btn-lg px-5 py-3">
                        GET STARTED
                    </a>
                </div>

                <div class="pt-5">
                    <a href="{{ route('login') }}" class="btn btn-outline-white btn-lg btn-icon icon-left">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>

                    <span class="mx-3 text-white-50"> | </span>

                    <a href="{{ route('register') }}" class="btn btn-outline-white btn-lg btn-icon icon-left">
                        <i class="far fa-user"></i> Register
                    </a>
                </div>
            </div>

        </div>
    </section>

@endsection
