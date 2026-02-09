<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CartController extends Controller
{
    protected $cart;

    public function __construct()
    {
        $this->cart = new Cart();
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'    => 'required|integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $carts = $this->cart->join('products', 'carts.product_id', 'products.id')
            ->where('carts.user_id', $request->user_id)
            ->where('order_id', '=', null)
            ->select('carts.id as cart_id', 'carts.price', 'carts.qty', 'carts.product_id', 'products.name', 'products.image')
            ->get();

        $carts->each(function ($product) {
            $product->url = Str::slug($product->name) . '-' . $product->product_id;
        });

        if (!$carts) {
            return response()->json([
                'status' => false,
                'message' => 'no record  found!',
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success!',
            'data'   => $carts
        ]);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'    => 'required|integer|exists:users,id',
            'product_id' => 'required|integer|exists:products,id',
            'qty'        => 'required|integer|min:0',
            'price'      => 'required|numeric|min:0',
            'type'       => 'required|in:add,remove,custom',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $cart = Cart::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->whereNull('order_id')
            ->first();

        if ($request->type === 'add') {

            if ($cart) {
                $cart->qty   += $request->qty;
                $cart->price += ($request->price * $request->qty);
                $cart->save();
            } else {
                $cart = Cart::create([
                    'user_id'    => $request->user_id,
                    'product_id' => $request->product_id,
                    'qty'        => $request->qty,
                    'price'      => $request->price * $request->qty,
                ]);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Product quantity increased',
                'data'    => [
                    'cart_id' => $cart->id,
                    'qty'     => $cart->qty,
                    'price'   => $cart->price,
                ]
            ], 200);
        }

        if ($request->type === 'remove') {

            if (!$cart) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Cart item not found',
                ], 404);
            }

            $cart->qty   -= $request->qty;
            $cart->price -= ($request->price * $request->qty);

            if ($cart->qty <= 0) {
                $cart->delete();

                return response()->json([
                    'status'  => true,
                    'message' => 'Product removed from cart',
                    'data'    => [
                        'qty'   => 0,
                        'price' => 0,
                    ]
                ], 200);
            }

            $cart->save();

            return response()->json([
                'status'  => true,
                'message' => 'Product quantity decreased',
                'data'    => [
                    'cart_id' => $cart->id,
                    'qty'     => $cart->qty,
                    'price'   => $cart->price,
                ]
            ], 200);
        }

        if ($request->type === 'custom') {

            if ($request->qty == 0) {

                if ($cart) {
                    $cart->delete();
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Cart item removed',
                    'data'    => [
                        'qty'   => 0,
                        'price' => 0,
                    ]
                ], 200);
            }

            if ($cart) {
                $cart->qty   = $request->qty;
                $cart->price = $request->price * $request->qty;
                $cart->save();
            } else {
                $cart = Cart::create([
                    'user_id'    => $request->user_id,
                    'product_id' => $request->product_id,
                    'qty'        => $request->qty,
                    'price'      => $request->price * $request->qty,
                ]);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Cart updated',
                'data'    => [
                    'cart_id' => $cart->id,
                    'qty'     => $cart->qty,
                    'price'   => $cart->price,
                ]
            ], 200);
        }
    }

    public function remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'cart_id' => 'required|integer|exists:carts,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $cart = Cart::where('id', $request->cart_id)
            ->where('user_id', $request->user_id)
            ->whereNull('order_id')
            ->first();

        if (!$cart) {
            return response()->json([
                'status'  => false,
                'message' => 'Cart item not found',
            ], 404);
        }

        $cart->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Cart item removed successfully',
        ], 200);
    }
}