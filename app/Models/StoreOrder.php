<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreOrder extends Model
{
    protected $table = 'store_orders';

    protected $fillable = [
        'store_id',
        'pos_user_id',
        'order_number',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(StoreOrderItem::class, 'store_order_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function posUser()
    {
        return $this->belongsTo(Pos::class, 'pos_user_id');
    }
}
