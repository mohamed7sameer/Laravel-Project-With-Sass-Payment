<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function discountResult()
    {
        return $this->discount_type == 'fixed' ? $this->discount_value : $this->discount_value.'%';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    public function invoices_sent(): HasMany
    {
        return $this->hasMany(InvoiceEmail::class);
    }

    public function invoices_uploads(): HasMany
    {
        return $this->hasMany(InvoiceUpload::class);
    }

    public function invoices_pdf($invoice)
    {
        return $this->invoices_uploads()->whereInvoiceId($invoice)->first();
    }

}
