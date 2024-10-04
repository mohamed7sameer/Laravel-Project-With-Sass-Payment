@extends('layouts.app')
@section('content')

    <div class="card">
        <div class="card-header">Payment Method</div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    @include('partial.frontend.sidebar')
                </div>
                <div class="col-8">
                    <h2 class="h5 text-uppercase mb-4">Payment Method</h2>

                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Email <span>{{ $subscription->paddleEmail() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Payment Method <span>{{ $subscription->paymentMethod() }}</span>
                        </li>

                        @if ($subscription->paymentMethod() == 'card')
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Card brand <span>{{ $subscription->cardBrand() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Card last 4 digits <span>{{ $subscription->cardLastFour() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Card Expiration date <span>{{ $subscription->cardExpirationDate() }}</span>
                            </li>
                        @endif
                    </ul>

                    <div class="mt-4 text-center">
                        <a href="{{ $updateUrl }}" class="btn btn-primary">
                            Update Card
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
