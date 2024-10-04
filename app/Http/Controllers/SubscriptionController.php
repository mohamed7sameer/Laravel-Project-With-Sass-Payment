<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeRequest;
use App\Models\Plan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function subscriptions()
    {
        $user = auth()->user();
        $interval = \request('interval') ?? 'month';
        $plans = Plan::with('features')->where('interval', $interval)->get();

        $userPlanId = $user->hasSubscription() ? $user->subscriptionInfo()->id : '';
        $userPlanName = $user->hasSubscription() ? $user->subscriptionInfo()->name : 'Free';
        $userNextPaymentDate = $user->hasSubscription() ? $user->subscription('default')->nextPayment()->date()->format('d/m/Y') : '';
        $userNextPaymentAmount = $user->hasSubscription() ? $user->subscription('default')->nextPayment()->amount : '';
        $userPlanTrail = $user->hasSubscription() && $user->onTrial('default') ? $user->trialEndsAt('default') : '';

        return view('frontend.subscriptions', compact('user', 'plans', 'userPlanId', 'userPlanName', 'userNextPaymentDate', 'userNextPaymentAmount', 'userPlanTrail'));
    }

    public function subscribe(SubscribeRequest $request)
    {
        $user = auth()->user();
        $plan = Plan::whereId($request->plan)->first();

        if (!$user->hasSubscription()) {
            // new Subscription
            $plan->payLink = auth()->user()->newSubscription('default', $plan->paddle_id)
                ->returnTo(route('subscriptions', ['interval' => $plan->interval]))
                ->create();

            return view('frontend.subscribe', compact('user', 'plan'));
        } else {
            // swap between plans
            $user->subscription('default')->swap($plan->paddle_id);

            return back()->with([
                'message' => 'Your subscription is updated successfully',
                'alert-type' => 'success'
            ]);
        }

    }

    public function payment_method()
    {
        $subscription = auth()->user()->subscription('default');
        $updateUrl = $subscription->updateUrl();
        return view('frontend.payment_method', compact('subscription', 'updateUrl'));
    }

    public function receipts()
    {
        $receipts = auth()->user()->receipts;
        return view('frontend.receipts', compact('receipts'));
    }

    public function cancel_account()
    {
        $subscription = auth()->user()->subscription('default');
        return view('frontend.cancel_account', compact('subscription'));
    }

    public function do_pause_account(Request $request)
    {
        $subscription = auth()->user()->subscription('default');

        if ($subscription->onPausedGracePeriod()) {
            $subscription->unpause();
        } else {
            $subscription->pause();
        }
        return back()->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function do_terminate_account(Request $request)
    {
        $subscription = auth()->user()->subscription('default');
        $subscription->cancelNow();

        return back()->with([
            'message' => 'Your account id terminated successfully',
            'alert-type' => 'success'
        ]);

    }


}
