<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Paddle\Billable;
use Laravel\Paddle\Subscription;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function invoices_sent(): HasMany
    {
        return $this->hasMany(InvoiceEmail::class);
    }

    public function invoices_uploads(): HasMany
    {
        return $this->hasMany(InvoiceUpload::class);
    }

    public function hasSubscription(): bool
    {
        return auth()->user()->subscribed('default');
    }

    public function subscriptionInfo()
    {
        if ($this->hasSubscription()) {
            return Plan::with('features')->where('paddle_id', Subscription::query()->active()->latest()->value('paddle_plan'))->first();
        }
        return 'Free';
    }

    public function canAddInvoice()
    {
        return $this->invoices()->withTrashed()->whereDate('created_at', '=', today())->count() < $this->subscriptionInfo()->features()->where('code', 'invoices_per_day')->value('value');
    }

    public function canSendInvoiceEmail()
    {
        return $this->invoices_sent()->whereDate('created_at', '=', today())->count() < $this->subscriptionInfo()->features()->where('code', 'sending_per_day')->value('value');
    }

    public function canUploadInvoice()
    {
        return $this->invoices_uploads()->whereDate('created_at', '=', today())->count() < $this->subscriptionInfo()->features()->where('code', 'upload_invoices')->value('value');
    }

}
