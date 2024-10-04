<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function unitText()
    {
        if ($this->unit == 'piece') {
            $text = 'Piece';
        } elseif ($this->unit == 'g') {
            $text = 'Gram';
        } elseif ($this->unit == 'kg') {
            $text = 'Kilo Gram';
        }

        return $text;
    }

}
