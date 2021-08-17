@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Contact Us') }}</h1>
        </div>
        <div class="section-body">

            <div class="row">
                <div class="col-4">

                    <div class="jumbotron text-center">
                        <h2>{{ __('How can we help?') }}</h2>
                        <p class="lead text-muted mt-3">{{ __('Please fill out our contact form if you have any question.') }}</p>
                    </div>

                </div>

                <div class="col-8">

                    <div class="card">
                        <div class="card-header">
                            <h4>Contact Form</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="firstname">{{ __('First Name') }}</label>
                                    <input type="text" class="form-control" id="firstname" placeholder="First Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lastname">{{ __('Last Name') }}</label>
                                    <input type="text" class="form-control" id="lastname" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input type="email" class="form-control" id="email" placeholder="What's your email?">
                            </div>
                            <div class="form-group">
                                <label for="title">{{ __('Message Title') }}</label>
                                <input type="text" class="form-control" id="title" placeholder="What's your question about?">
                            </div>
                            <div class="form-group">
                                <label for="content">{{ __('Message Content') }}</label>
                                <textarea name="content" id="content" class="form-control h-25" placeholder="What's your question?"></textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary">{{ __('Send Message') }}</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

@endsection
