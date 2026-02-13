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
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Str;

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
                            'products.slug',
                            'discounts.name as discount',
                            'brands.name as brand'
                        );
                }])
                ->select('id', 'name', 'position', 'image as banner')
                ->whereNotNull('position')
                ->orderBy('position', 'ASC')
                ->get();

            $data->each(function ($summer) {
                $summer->products->each(function ($product) {
                    $product->url = Str::slug($product->name) . '-' . $product->url;
                    unset($product->id);
                });
            });

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
                    'products.id',
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

            $products->each(function ($product) {
                $product->url = Str::slug($product->name) . '-' . $product->id;
                unset($product->id);
            });

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
                    'products.id',
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

            $products->each(function ($product) {
                $product->url = Str::slug($product->name) . '-' . $product->id;
                unset($product->id);
            });

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

    public function categoryProducts($name)
    {

        preg_match_all('/\d+/', $name, $matches);

        $id = !empty($matches[0]) ? end($matches[0]) : null;
        try {
            $products = Product::leftJoin('discounts', 'discounts.id', '=', 'products.discount')
                ->leftJoin('brands', 'brands.id', '=', 'products.brands')
                ->where('products.category', $id)
                ->select(
                    'products.id',
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

            $products->each(function ($product) {
                $product->url = Str::slug($product->name) . '-' . $product->id;
                unset($product->id);
            });

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

    // Product Details 
    public function productsDetails($name)
    {
        preg_match_all('/\d+/', $name, $matches);

        $id = !empty($matches[0]) ? end($matches[0]) : null;

        $product = Product::where('id', $id)->select('id', 'name', 'brand_name', 'image', 'price', 'ac_price', 'sku_code as sku', 'hsn_code as hsn', 'tags', 'meta_tag', 'category', 'sub_category', 'stock', 'in_stock', 'barcode_base as barcode', 'description')->first();

        if (!$product) {
            return response()->json([
                'status' => false,
                'data'   => []
            ], 404);
        }

        $similar = $product->similar;

        if (empty($similar) && $similar == null) {
            $similarProducts = $this->categorySubcategoryProducts($product->category, $product->sub_category, $id);
        } else {
            $similarProducts = $this->similarProducts($similar, $id);
        }

        $category = Category::find($product->category);
        $product->category = $category ? Str::slug($category->name) : null;
        $product->category_url = $category
            ? Str::slug($category->name) . '-' . $category->id
            : null;

        $sub_category = SubCategory::find($product->sub_category);
        $product->sub_category = $sub_category ? Str::slug($sub_category->name) : null;
        $product->sub_category_url = $sub_category
            ? Str::slug($sub_category->name) . '-' . $sub_category->id
            : null;

        $gallery = Gallery::where('product_id', $id)->select('image')->get();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data'   => $product,
            'gallery' => $gallery,
            'similar_products' => $similarProducts
        ], 200);
    }

    private function similarProducts($ids, $id)
    {
        $idsArray = json_decode($ids, true);

        if (empty($idsArray) || !is_array($idsArray)) {
            return collect();
        }

        $products = Product::whereIn('id', $idsArray)
            ->where('id', '!=', $id)
            ->select(
                'id',
                'name',
                'sku_code as sku',
                'brand_name',
                'image',
                'price',
                'ac_price',
                'hsn_code as hsn',
                'description'
            )
            ->get();

        $products->each(function ($product) {
            $product->url = Str::slug($product->name) . '-' . $product->id;
            unset($product->id);
        });

        return $products;
    }

    private function categorySubcategoryProducts($category, $subcategory, $id)
    {
        $products = Product::where('id', '!=', $id)
            ->where(function ($query) use ($category, $subcategory) {
                $query->where('category', $category)
                    ->orWhere('sub_category', $subcategory);
            })
            ->select(
                'id',
                'name',
                'sku_code as sku',
                'brand_name',
                'image',
                'price',
                'ac_price',
                'hsn_code as hsn',
                'description'
            )
            ->get();

        $products->each(function ($product) {
            $product->url = Str::slug($product->name) . '-' . $product->id;
            unset($product->id);
        });

        return $products;
    }
}
