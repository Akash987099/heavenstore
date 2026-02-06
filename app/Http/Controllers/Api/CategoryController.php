<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected $category;
    protected $subcategory;
    protected $brand;

    public function __construct()
    {
        $this->category = new Category();
        $this->subcategory = new SubCategory();
        $this->brand = new Brand();
    }

    public function category()
    {
        $category = $this->category->select('id', 'name', 'image')->get();

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'No record found!.'
            ], 403);
        }

        return response()->json([
            'status' => true,
            'data' => $category
        ], 200);
    }

    public function categorySubcategory()
    {
        // echo '1111';exit();
        $categories = Category::with('subCategories:id,category_id,name,image')
            ->select('id','name','image')
            // ->orderBy('position','ASC')
            ->get();
    
        $data = $categories->map(function ($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'image' => $cat->image,
                'subCategories' => $cat->subCategories->map(function ($sub) {
                    return [
                        'id' => $sub->id,
                        'category_id' => Str::slug($sub->name) . '-' . $sub->category_id,
                        'name' => $sub->name,
                        'image' => $sub->image,
                    ];
                })->values(),
            ];
        })->values();
        
        // dd($data);
    
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    public function subCategory($id = null)
    {
        $subcategory = $this->subcategory
            ->select('id', 'category_id', 'name', 'image');

        if ($id) {
            $subcategory->where('category_id', $id);
        }

        $subcategory = $subcategory->get();

        if ($subcategory->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No record found!'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $subcategory
        ], 200);
    }

    public function brands()
    {
        $brands = $this->brand->select('id', 'name', 'image')->get();

        if (!$brands) {
            return response()->json([
                'status' => false,
                'message' => 'No record found!.'
            ], 403);
        }

        return response()->json([
            'status' => true,
            'data' => $brands
        ], 200);
    }
}
