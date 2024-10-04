@extends('layouts.app')
@section('content')

    <div class="card">
        <div class="card-header">Cancel Account</div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    @include('partial.frontend.sidebar')
                </div>
                <div class="col-8">
                    <h2 class="h5 text-uppercase mb-4">Pause Account</h2>
                    <form action="{{ route('do_pause_account') }}" method="post">
                        @csrf
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">
                                {{ $subscription->onPausedGracePeriod() ? 'Continue my account' : 'Pause my account' }}
                            </button>
                        </div>
                    </form>

                    <br>
                    <hr>
                    <br>
                    <h2 class="h5 text-uppercase mb-4">Terminate my account permanently</h2>
                    <form action="{{ route('do_terminate_account') }}" method="post">
                        @csrf
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">
                                Yes, sure! Terminate my account now
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
