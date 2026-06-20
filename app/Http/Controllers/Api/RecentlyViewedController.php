<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\RecentlyViewedProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RecentlyViewedController extends Controller
{
    protected $recentlyViewed;

    public function __construct()
    {
        $this->recentlyViewed = new RecentlyViewedProduct();
    }

    public function index()
    {
        $userId = auth()->id();

        $recentlyViewed = $this->recentlyViewed
            ->join('products', 'recently_viewed_products.product_id', '=', 'products.id')
            ->leftJoin('discounts', 'discounts.id', '=', 'products.discount')
            ->leftJoin('brands', 'brands.id', '=', 'products.brands')
            ->where('recently_viewed_products.user_id', $userId)
            ->orderBy('recently_viewed_products.updated_at', 'desc')
            ->select(
                'recently_viewed_products.id as recently_viewed_id',
                'recently_viewed_products.product_id',
                'recently_viewed_products.updated_at as viewed_at',
                'products.name',
                'products.image',
                'products.price',
                'products.ac_price',
                'products.stock',
                'products.in_stock',
                'products.short_description',
                'products.product_type',
                'products.type',
                'products.type_value',
                'products.brand_name',
                'discounts.name as discount',
                'brands.name as brand'
            )
            ->limit(20)
            ->get();

        $recentlyViewed->each(function ($product) {
            $product->url = Str::slug($product->name) . '-' . $product->product_id;
            $product->viewed_at = $product->viewed_at
                ? date('Y-m-d H:i:s', strtotime($product->viewed_at))
                : null;
        });

        return response()->json([
            'status' => true,
            'message' => 'Recently viewed products',
            'data' => $recentlyViewed,
        ], 200);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $userId = auth()->id();
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ], 404);
        }

        $recentlyViewed = RecentlyViewedProduct::updateOrCreate(
            [
                'user_id' => $userId,
                'product_id' => $request->product_id,
            ],
            []
        );

        $recentlyViewed->touch();

        return response()->json([
            'status' => true,
            'message' => 'Product added to recently viewed',
            'data' => [
                'recently_viewed_id' => $recentlyViewed->id,
                'product_id' => $product->id,
                'name' => $product->name,
                'url' => Str::slug($product->name) . '-' . $product->id,
            ],
        ], 200);
    }

    public function remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $deleted = $this->recentlyViewed
            ->where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->delete();

        if (!$deleted) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found in recently viewed',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product removed from recently viewed',
        ], 200);
    }

    public function clear()
    {
        $this->recentlyViewed
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Recently viewed products cleared',
        ], 200);
    }
}
