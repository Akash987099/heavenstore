<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = "user_address";
    protected $fillable = ['id', 'user_id', 'country', 'state', 'district', 'tehsil', 'block', 'village', 'address', 'pincode', 'is_default', 'person', 'contact', 'created_at', 'updated_at'];
}
