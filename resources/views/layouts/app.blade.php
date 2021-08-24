<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Global frontend variables -->
    <script>window.currentUser = {!! $currentUser !!};</script>
</head>

<body>
<div id="app">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>

        <nav class="navbar navbar-expand-lg main-navbar">
            @include('partials.topnav')
        </nav>

        <div class="main-sidebar">
            @include('partials.sidebar')
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>

        <footer class="main-footer">
            @include('partials.footer')
        </footer>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>
