<?php

namespace App\Mail;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionSwapped extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $plan;
    public $oldPlan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Plan $plan, $oldPlan)
    {
        $this->user = $user;
        $this->plan = $plan;
        $this->oldPlan = $oldPlan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Subscription swapped')
            ->view('emails.subscription_swapped')
            ->with([
                'user' => $this->user,
                'plan' => $this->plan,
                'oldPlan' => $this->oldPlan
            ]);
    }
}
