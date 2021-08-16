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
</head>

<body>
<div id="app">

    <!--  Main Content  -->
    @yield('content')

</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" {{uniqid()}}></script>
@yield('scripts')
</body>
</html>
