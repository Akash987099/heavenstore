<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPosition extends Model
{
    use HasFactory;
    protected $table = "product_position";
    protected $fillable = ['id', 'position_id', 'type', 'product_id', 'order', 'created_at', 'updated_at'];
}
