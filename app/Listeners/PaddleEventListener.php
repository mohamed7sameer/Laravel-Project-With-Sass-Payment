<?php

namespace App\Listeners;

use App\Mail\SubscriptionCancelled;
use App\Mail\SubscriptionCreated;
use App\Mail\SubscriptionPaused;
use App\Mail\SubscriptionPaymentSucceeded;
use App\Mail\SubscriptionSwapped;
use App\Mail\SubscriptionUnPause;
use App\Models\Plan;
use App\Models\Revenue;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Laravel\Paddle\Events\WebhookReceived;

class PaddleEventListener implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param WebhookReceived $event
     * @return void
     */
    public function handle(WebhookReceived $event)
    {
        logger(json_encode($event->payload));
        $user = User::whereEmail($event->payload['email'])->first();
        $plan = Plan::wherePaddleId($event->payload['subscription_plan_id'])->first();


        if ($event->payload['alert_name'] === 'subscription_payment_succeeded') {
            // Save Revenue
            Revenue::firstOrCreate([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
                'payment_method' => $event->payload['payment_method'],
                'checkout_id' => $event->payload['checkout_id'] ?? '',
                'amount' => $event->payload['unit_price'],
                'currency' => $event->payload['balance_currency'],
            ]);

            Mail::to($user->email)->send(new SubscriptionPaymentSucceeded($user, $plan));
        }

        if ($event->payload['alert_name'] === 'subscription_created') {
            if (!Revenue::where([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'checkout_id' => $event->payload['checkout_id'],
            ])->exists()) {
                Mail::to($user->email)->send(new SubscriptionCreated($user, $plan));
            }
        }

        if ($event->payload['alert_name'] === 'subscription_cancelled') {
            Mail::to($user->email)->send(new SubscriptionCancelled($user, $plan));
        }

        if ($event->payload['alert_name'] === 'subscription_updated') {
            // swapping
            if ($event->payload['new_price'] != $event->payload['old_price']) {
                $oldPlan = Plan::wherePaddleId($event->payload['old_subscription_plan_id'])->value('name');
                Mail::to($user->email)->send(new SubscriptionSwapped($user, $plan, $oldPlan));
            } else {

                if (isset($event->payload['paused_at'])) {
                    // pause
                    Mail::to($user->email)->send(new SubscriptionPaused($user, $plan));
                } else {
                    // unpause
                    Mail::to($user->email)->send(new SubscriptionUnPause($user, $plan));
                }

            }
        }
    }
}
