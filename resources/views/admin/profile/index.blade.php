@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Profile Page</h1>
        <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">Update My Profile</a>
    </div>

    <!--
        TODO:

        show all admin profile details here
    -->


@endsection
