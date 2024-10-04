@extends('layouts.emails')
@section('content')

    <h3>Dear: {{ $user->name }}</h3>

    <p>Your subscription for plan: {{ $plan->name }} is paused.</p>

@endsection
