<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\ProductPosition;
use App\Models\Product;

class ProductPositionController extends Controller
{
    protected $category;
    protected $subcategory;
    protected $childcategory;
    protected $proposition;
    protected $product;

    public function __construct(){
        $this->category = new Category();
        $this->subcategory = new SubCategory();
        $this->childcategory = new ChildCategory();
        $this->proposition = new ProductPosition();
        $this->product = new Product();
    }

    public function index($id, $type)
    {
        if (!$id) {
            return redirect()->back()->with('error', 'Category ID not found.');
        }

        $products = $this->product
            ->leftJoin('product_position', function ($join) use ($id, $type) {
                $join->on('products.id', '=', 'product_position.product_id')
                    ->where('product_position.position_id', '=', $id);
                    // ->where('product_position.type', '=', $type);
            })
            ->where('products.category', $id)
            ->select(
                'products.*',
                'product_position.order'
            )
            ->orderByRaw('product_position.`order` IS NULL, product_position.`order` ASC')
            ->get();

        return view('product_position/index', compact('products', 'id', 'type'));
    }

    public function updatePosition(Request $request)
    {
        foreach ($request->positions as $index => $productId) {

            $this->proposition->updateOrCreate(
                [
                    'position_id' => $request->position_id,
                    'product_id'  => $productId,
                    'type'        => $request->cat_type,
                ],
                [
                    'order' => $index + 1,
                ]
            );
        }

        return response()->json([
            'status'  => true,
            'message' => 'Product position updated successfully.'
        ]);
    }
}
