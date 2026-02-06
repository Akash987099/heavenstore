<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Discount;
use App\Models\Product;
use Milon\Barcode\DNS1D;
use App\Models\Gallery;
use App\Models\Summer;

class ProductController extends Controller
{
    public function products()
    {
        try {
            $data = Summer::whereNotNull('position')
            ->whereHas('products')->with(['products' => function ($query) {
                $query
                    ->leftJoin('discounts', 'discounts.id', '=', 'products.discount')
                    ->leftJoin('brands', 'brands.id', '=', 'products.brands')
                    ->select(
                        'products.id as url',
                        'products.name',
                        'products.image',
                        'products.price',
                        'products.ac_price',
                        'products.stock',
                        'products.in_stock',
                        'products.summer_id',
                        'products.slug',
                        'discounts.name as discount',
                        'brands.name as brand'
                    );
            }])
                ->select('id', 'name', 'position', 'banner')
                ->whereNotNull('position')
                ->orderBy('position', 'ASC')
                ->get();

            return response()->json([
                'status' => true,
                'data'   => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'data'   => [],
                'error'  => $e->getMessage()
            ], 500);
        }
    }

    public function summerProducts($id)
    {
        try {
            $products = Product::leftJoin('discounts', 'discounts.id', '=', 'products.discount')
                ->leftJoin('brands', 'brands.id', '=', 'products.brands')
                ->where('products.summer_id', $id)
                ->select(
                    'products.id as url',
                    'products.name',
                    'products.image',
                    'products.price',
                    'products.ac_price',
                    'products.stock',
                    'products.in_stock',
                    'products.slug',
                    'discounts.name as discount',
                    'brands.name as brand'
                )
                ->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'data'   => []
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data'   => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'data'   => [],
                'error'  => $e->getMessage()
            ], 500);
        }
    }

    public function allProducts()
    {
        try {
            $products = Product::leftJoin('discounts', 'discounts.id', '=', 'products.discount')
                ->leftJoin('brands', 'brands.id', '=', 'products.brands')
                ->select(
                    'products.id as url',
                    'products.name',
                    'products.image',
                    'products.price',
                    'products.ac_price',
                    'products.stock',
                    'products.in_stock',
                    'products.slug',
                    'discounts.name as discount',
                    'brands.name as brand'
                )
                ->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'data'   => []
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data'   => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'data'   => [],
                'error'  => $e->getMessage()
            ], 500);
        }
    }

    public function categoryProducts($id)
    {
        try {
            $products = Product::leftJoin('discounts', 'discounts.id', '=', 'products.discount')
                ->leftJoin('brands', 'brands.id', '=', 'products.brands')
                ->where('products.category', $id)
                ->select(
                    'products.id as url',
                    'products.name',
                    'products.image',
                    'products.price',
                    'products.ac_price',
                    'products.stock',
                    'products.in_stock',
                    'products.slug',
                    'discounts.name as discount',
                    'brands.name as brand'
                )
                ->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'data'   => []
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data'   => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'data'   => [],
                'error'  => $e->getMessage()
            ], 500);
        }
    }
}
