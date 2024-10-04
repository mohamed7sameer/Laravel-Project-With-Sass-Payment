<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function features(): HasMany
    {
        return $this->hasMany(PlanFeature::class);
    }
}