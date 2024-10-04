@extends('layouts.emails')
@section('content')

    <h3>Dear: {{ $user->name }}</h3>

    <p>Thank you for payment on subscription for plan: {{ $plan->name }}.</p>

@endsection
