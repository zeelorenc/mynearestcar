@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Contact Us') }}</h1>
        </div>
        <div class="section-body">

            <div class="jumbotron text-center">
                <h2>{{ __('How can we help?') }}</h2>
                <p class="lead text-muted mt-3">{{ __('To contact us, using the following information if you have any question.') }}</p>

                <ul class="nav mx-auto row mt-5">
                    <li class="col-12 col-md-4">
                        <i class="fas fa-map-pin mb-3" style="font-size: 2.5rem;"></i>
                        <p>124 La Trobe St, Melbourne VIC 3000</p>
                    </li>
                    <li class="col-12 col-md-4">
                        <i class="fas fa-phone mb-3" style="font-size: 2.5rem;"></i>
                        <p>+61 412 345 678</p>
                    </li>
                    <li class="col-12 col-md-4">
                        <i class="fas fa-envelope mb-3" style="font-size: 2.5rem;"></i>
                        <p>info@mynearestcar.com/</p>
                    </li>
                </ul>
            </div>

        </div>
    </section>

@endsection
