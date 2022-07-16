<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'name', 'type', 'brand', 'price', 'quantity', 'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function purchases()
    {
        return $this->belongsToMany(Purchase::class)
            ->as('detail')
            ->withPivot([
                'quantity',
                'price',
                'discount_id',
            ])
            ->withTimestamps();
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class);
    }

    public function scopeSearchBy(Builder $query, $q)
    {
        return $query->where('name', 'LIKE', "%$q%")
            ->orWhere('type', 'LIKE', "%$q%")
            ->orWhere('brand', 'LIKE', "%$q%");
    }
}
