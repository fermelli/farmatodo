<?php

namespace App\Models;

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
}
