<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;
    protected $table = 'courier_partners';
    protected $fillable = [
        'courier_name',
        'courier_code',
        'logo',
        'contact_person',
        'contact_email',
        'contact_mobile',
        'website_url',
        'tracking_url',
        'api_base_url',
        'api_key',
        'api_secret',
        'supports_cod',
        'supports_prepaid',
        'supports_reverse_pickup',
        'status',
    ];
}
