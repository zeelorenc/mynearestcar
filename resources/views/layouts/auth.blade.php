<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; Stisla</title>

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-md-6 mx-auto">
                    <div class="login-brand">
                        {{ config('app.name') }}
                    </div>

                    @if(session()->has('info'))
                        <div class="alert alert-primary">
                            {{ session()->get('info') }}
                        </div>
                    @endif

                    @if(session()->has('status'))
                        <div class="alert alert-info">
                            {{ session()->get('status') }}
                        </div>
                    @endif

                    @yield('content')

                    <div class="simple-footer">
                        Copyright &copy; {{ env('APP_NAME') }} {{ date('Y') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
