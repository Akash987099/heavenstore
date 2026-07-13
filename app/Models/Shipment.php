<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;
    protected $table = 'shipments';
    protected $fillable = [
        'order_id',
        'courier_id',
        'courier_code',
        'tracking_number',
        'status',
        'shipment_response',
        'barcode_url',
        'created_at',
        'updated_at'    
    ];
}
