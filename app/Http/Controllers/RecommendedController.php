<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Recommended;

class RecommendedController extends Controller
{
    protected $product;
    protected $recommended;

    public function __construct(Product $product, Recommended $recommended)
    {
        $this->product = $product;
        $this->recommended = $recommended;
    }

    public function index()
    {
        $recommended = $this->recommended->join('products', 'recommended_products.product_id', 'products.id')->select('recommended_products.*', 'products.name')->orderBy('id', 'desc')->paginate(config('pagination_limit'));
        return view('recommended.index', compact('recommended'));
    }

    public function add()
    {
        $products = $this->product->select('id','name')->get();
        return view('recommended.add', compact('products'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'recommended_products' => 'required|array'
        ]);

        $this->recommended
            ->where('product_id', $request->product_id)
            ->delete();

        foreach ($request->recommended_products as $recId) {

            if ($recId == $request->product_id) {
                continue;
            }

            $this->recommended->create([
                'product_id' => $request->product_id,
                'recommended_product_id' => $recId
            ]);
        }

        return redirect()->back()->with('success', 'Recommended products added successfully');
    }
}
