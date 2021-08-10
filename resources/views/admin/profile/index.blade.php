@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Profile of "{{ $user->name }}"</h1>
        <a href="{{ route('admin.profile.edit', $user->id) }}" class="btn btn-primary">
            Update Profile
        </a>
    </div>

    <!--
        show all the profile details here
    -->


@endsection
