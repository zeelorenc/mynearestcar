@extends('layouts.app')

@section('content')

    <div class="container py-3">
        <br>
        <h1 class="display4">Profile Page</h1>
        
        <ul class="list-group">
            <li class="list-group-item">{{ __('Name') }}: {{ $user->name }}</li>
            <li class="list-group-item">{{ __('E-Mail Address') }}: {{ $user->email }}</li>
        </ul>
    </div>

    <!--
        TODO:

        show all admin profile details here
    -->


@endsection
