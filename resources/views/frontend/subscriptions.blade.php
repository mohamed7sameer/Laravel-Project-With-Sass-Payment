@extends('layouts.app')
@section('style')
    <style>
        .radio-tile-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .input-container {
            display: inline-table;
            position: relative;
            /* height: 7rem; */
            width: 35%;
            margin: 0.5rem;
        }
        .input-container .radio-button {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            margin: 0;
            cursor: pointer;
        }
        .input-container .radio-tile {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            border: 2px solid #079ad9;
            border-radius: 5px;
            padding: 1rem;
            transition: transform 300ms ease;
        }
        .input-container .icon svg {
            fill: #079ad9;
            width: 3rem;
            height: 3rem;
        }
        .input-container .radio-tile-label {
            text-align: center;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #079ad9;
        }
        .input-container .radio-button:checked + .radio-tile {
            background-color: #079ad9;
            border: 2px solid #079ad9;
            color: white;
            transform: scale(1.1, 1.1);
        }
        .input-container .radio-button:checked + .radio-tile .icon svg {
            fill: white;
            background-color: #079ad9;
        }
        .input-container .radio-button:checked + .radio-tile .radio-tile-label {
            color: white;
            background-color: #079ad9;
        }
        .input-container ul, .input-container li {
            margin: 0;
            padding: 0;
        }
        .input-container ul {
            list-style: none;
            text-align: center;
        }
        .input-container li {
            text-align: left;
            width: 100%;
        }
    </style>
@endsection
@section('content')

    <div class="card">
        <div class="card-header">Subscriptions</div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    @include('partial.frontend.sidebar')
                </div>
                <div class="col-8">
                    <h2 class="h5 text-uppercase mb-4">Your subscription plan is: {{ $userPlanName }}</h2>

                    @if($userNextPaymentDate != '')
                        <p>Your next payment will be on: {{ $userNextPaymentDate }} with amount: $ {{ $userNextPaymentAmount }}</p>
                    @endif

                    @if($userPlanTrail != '')
                        <p>Your trial subscription will end on: {{ $userPlanTrail }}</p>
                    @endif

                    <h3 class="h5 text-uppercase mb-4">Personal plans:</h3>

                    <div class="text-center mb-4">
                        <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                            <a href="{{ route('subscriptions', ['interval' => 'month']) }}" class="btn {{ !request('interval') || request('interval') == 'month' ? 'btn-primary' : 'btn-secondary' }}">Monthly</a>
                            <a href="{{ route('subscriptions', ['interval' => 'year']) }}" class="btn {{ request('interval') == 'year' ? 'btn-primary' : 'btn-secondary' }}">Yearly</a>
                        </div>
                    </div>

                    <form action="{{ route('subscribe') }}" method="post">
                        @csrf
                        <div class="radio-tile-group mb-5">
                            @foreach($plans as $plan)
                                <div class="input-container">
                                    <input type="radio" name="plan" id="plan_{{ \Illuminate\Support\Str::snake($plan->name) }}" @checked($plan->id == $userPlanId) class="radio-button" value="{{ $plan->id }}" />
                                    <div class="radio-tile">
                                        <div class="icon walk-icon">
                                            {{ $plan->id . ' - ' . $plan->name }}
                                        </div>
                                        <label for="plan_{{ \Illuminate\Support\Str::snake($plan->name) }}" class="radio-tile-label">${{ (int)$plan->price }}</label>
                                    </div>

                                    <ul class="mt-2">
                                        @foreach($plan->features as $feature)
                                            <li>{{ $feature->value == 100000 ? 'Unlimited' : $feature->value }} {{ $feature->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>

                        <div class="row">
                            <div class="col-12">
                                @error('plan')<span class="text-danger">{{ $message }}</span>@enderror
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $userPlanName == 'Free' ? 'Subscribe' : 'Update your subscription' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
