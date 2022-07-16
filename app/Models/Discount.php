<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'percentage', 'start_date', 'end_date', 'is_active',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopeActiveAndInForce(Builder $query)
    {
        return $query->whereNull('deleted_at')
            ->whereDate('start_date', '<=', now()->format('Y-m-d'))
            ->whereDate('end_date', '>=', now()->format('Y-m-d'));
    }
}
