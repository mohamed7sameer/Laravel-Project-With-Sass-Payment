<div class="card border-0 rounded-0 p-lg-4 bg-light">
    <div class="card-body">
        <h5 class="text-uppercase mb-4">Navigation</h5>
        <div class="py-2 px-4 mb-3 {{ Route::currentRouteName() == 'account' ? 'bg-primary' : '' }}">
            <a href="{{ route('account') }}" class="{{ Route::currentRouteName() == 'account' ? 'text-white' : '' }}">
                <strong class="small text-uppercase font-weight-bold">Account</strong>
            </a>
        </div>

        <div class="py-2 px-4 mb-3 {{ Route::currentRouteName() == 'subscriptions' ? 'bg-primary' : '' }}">
            <a href="{{ route('subscriptions') }}" class="{{ Route::currentRouteName() == 'subscriptions' ? 'text-white' : '' }}">
                <strong class="small text-uppercase font-weight-bold">Subscription</strong>
            </a>
        </div>

        @if (auth()->user()->hasSubscription())
            <div class="py-2 px-4 mb-3 {{ Route::currentRouteName() == 'payment_method' ? 'bg-primary' : '' }}">
                <a href="{{ route('payment_method') }}" class="{{ Route::currentRouteName() == 'payment_method' ? 'text-white' : '' }}">
                    <strong class="small text-uppercase font-weight-bold">Payment Method</strong>
                </a>
            </div>

            <div class="py-2 px-4 mb-3 {{ Route::currentRouteName() == 'receipts' ? 'bg-primary' : '' }}">
                <a href="{{ route('receipts') }}" class="{{ Route::currentRouteName() == 'receipts' ? 'text-white' : '' }}">
                    <strong class="small text-uppercase font-weight-bold">Receipts</strong>
                </a>
            </div>

            <div class="py-2 px-4 mb-3 {{ Route::currentRouteName() == 'cancel_account' ? 'bg-primary' : '' }}">
                <a href="{{ route('cancel_account') }}" class="{{ Route::currentRouteName() == 'cancel_account' ? 'text-white' : '' }}">
                    <strong class="small text-uppercase font-weight-bold">Cancel Account</strong>
                </a>
            </div>
        @endif
    </div>

</div>











