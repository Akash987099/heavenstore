<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['id', 'sku_product_id', 'name', 'brand_name', 'image', 'status', 'price', 'ac_price', 'sku_code', 'hsn_code', 'tags', 'meta_tag', 'category', 'sub_category', 'discount', 'brands', 'barcode_base', 'stock', 'in_stock', 'summer_id', 'slug', 'description', 'created_at', 'updated_at'];
}
