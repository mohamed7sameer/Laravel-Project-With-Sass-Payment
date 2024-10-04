@extends('layouts.emails')
@section('content')

    <h3>Dear: {{ $user->name }}</h3>

    <p>Your swapped subscription for plan: {{ $plan->name }} from {{ $oldPlan }}.</p>

@endsection
