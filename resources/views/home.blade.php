@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Welcome back, {{ $currentUser->name }}</h1>
        </div>
        <div class="section-body">
        </div>
    </section>

@endsection
