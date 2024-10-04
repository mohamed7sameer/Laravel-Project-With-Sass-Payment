@extends('layouts.app')
@section('content')

    <div class="card">
        <div class="card-header">Subscriptions</div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    @include('partial.frontend.sidebar')
                </div>
                <div class="col-8">
                    <h2 class="h5 text-uppercase mb-4">Update your subscription to plan: {{ $plan->name }}</h2>

                    <x-paddle-checkout :override="$plan->payLink" class="w-full" />
                </div>
            </div>
        </div>
    </div>

@endsection
