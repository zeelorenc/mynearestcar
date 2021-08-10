@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Profile of "{{ $user->name }}"</h1>
        <a href="{{ route('admin.profile.edit', $user->id) }}" class="btn btn-primary">
            Update Profile
        </a>
    </div>

    <ul class="list-group">
        <li class="list-group-item">{{ __('Name') }}: {{ $user->name }}</li>
        <li class="list-group-item">{{ __('E-Mail Address') }}: {{ $user->email }}</li>
    </ul>


@endsection
