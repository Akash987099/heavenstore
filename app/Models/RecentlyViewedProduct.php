<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentlyViewedProduct extends Model
{
    use HasFactory;

    protected $table = 'recently_viewed_products';

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
