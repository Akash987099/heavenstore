<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Product;
use App\Models\PosOrder;
use App\Models\PosOrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    protected $product;

    public function __construct(){
        $this->product = new Product();
    }
    public function index(){
        $totalRecords = '1111';
        $todayRecords = '1111';
        $totalGames = '1111';
        return view('pos/index', compact('totalRecords', 'todayRecords', 'totalGames'));
    }

    public function order(){
        return view('pos/order');
    }

    public function search(Request $request)
    {
        $search = trim($request->sku_product_id ?? '');

        if ($search === '') {

            return response()->json([
                'success' => false,
                'products' => [],
                'message' => 'Search value is required.',
            ]);
        }


        $products = $this->product
            ->where('status', 'active')
            ->where(function ($query) use ($search) {

                $query->where(
                    'sku_product_id',
                    'LIKE',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'barcode_base',
                    'LIKE',
                    '%' . $search . '%'
                );

            })
            ->select([
                'id',
                'sku_product_id',
                'barcode_base',
                'name',
                'image',
                'price',
            ])
            ->limit(20)
            ->get();


        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }

public function save(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Get Products From URL
        |--------------------------------------------------------------------------
        */

        $cart = $request->input('cart');


        if (empty($cart)) {

            return redirect()
                ->route('pos.order')
                ->with('error', 'No products selected.');

        }


        /*
        |--------------------------------------------------------------------------
        | Decode Cart
        |--------------------------------------------------------------------------
        */

        $cart = json_decode(
            base64_decode($cart),
            true
        );


        if (!is_array($cart) || empty($cart)) {

            return redirect()
                ->route('pos.order')
                ->with('error', 'Invalid order data.');

        }


        /*
        |--------------------------------------------------------------------------
        | POS User
        |--------------------------------------------------------------------------
        */

        $posUser = Auth::guard('pos')->user();


        if (!$posUser) {

            return redirect()
                ->route('pos.login');

        }


        /*
        |--------------------------------------------------------------------------
        | Calculate Total
        |--------------------------------------------------------------------------
        */

        $subtotal = 0;


        foreach ($cart as $item) {

            $price = (float) ($item['price'] ?? 0);

            $quantity = (int) ($item['qty'] ?? 1);

            $subtotal += $price * $quantity;

        }


        $discount = 0;

        $grandTotal = $subtotal - $discount;


        /*
        |--------------------------------------------------------------------------
        | Save Order
        |--------------------------------------------------------------------------
        */

        DB::beginTransaction();


        try {

            /*
            |--------------------------------------------------------------------------
            | Generate Order Number
            |--------------------------------------------------------------------------
            */

            $orderNumber =
                'POS-' .
                date('YmdHis') .
                '-' .
                random_int(100, 999);


            /*
            |--------------------------------------------------------------------------
            | Main Order
            |--------------------------------------------------------------------------
            */

            $order = PosOrder::create([

                'pos_user_id' => $posUser->id,

                'order_number' => $orderNumber,

                'subtotal' => $subtotal,

                'discount' => $discount,

                'grand_total' => $grandTotal,

                'status' => 'completed',

            ]);


            /*
            |--------------------------------------------------------------------------
            | Order Details
            |--------------------------------------------------------------------------
            */

            foreach ($cart as $item) {

                $price = (float) ($item['price'] ?? 0);

                $quantity = (int) ($item['qty'] ?? 1);

                $total = $price * $quantity;


                PosOrderDetail::create([

                    'pos_order_id' => $order->id,

                    'product_id' => $item['id'],

                    'product_name' => $item['name'],

                    'price' => $price,

                    'quantity' => $quantity,

                    'total' => $total,

                ]);

            }


            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | Go To Order View
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('pos.order.view', [
                    'id' => $order->id
                ]);

        } catch (\Throwable $e) {

            DB::rollBack();


            return redirect()
                ->route('pos.order')
                ->with(
                    'error',
                    'Order save failed: ' . $e->getMessage()
                );
        }
    }

     public function orderView($id)
    {
        $order = PosOrder::with('details')
            ->where('id', $id)
            ->where(
                'pos_user_id',
                Auth::guard('pos')->id()
            )
            ->firstOrFail();


        return view(
            'pos.order-view',
            compact('order')
        );
    }

    public function payment(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Payment Data
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'customer_name' => [
                'required',
                'string',
                'max:255',
            ],

            'customer_email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'customer_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'payment_method' => [
                'required',
                'in:cash,card,upi',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Get Logged-in POS User
        |--------------------------------------------------------------------------
        */

        $posUserId = Auth::guard('pos')->id();

        if (!$posUserId) {

            return redirect()
                ->route('pos.login')
                ->with('error', 'POS session expired. Please login again.');
        }


        /*
        |--------------------------------------------------------------------------
        | Get Current Order
        |--------------------------------------------------------------------------
        |
        | Important:
        | Order sirf current logged-in POS user ka hi milega.
        |
        */

        $order = PosOrder::where('id', $id)
            ->where('pos_user_id', $posUserId)
            ->first();


        if (!$order) {

            return redirect()
                ->route('pos.order')
                ->with('error', 'Order not found.');
        }


        /*
        |--------------------------------------------------------------------------
        | Check Order Already Paid
        |--------------------------------------------------------------------------
        */

        if (
            isset($order->payment_status) &&
            $order->payment_status === 'paid'
        ) {

            return redirect()
                ->route('pos.order.view', $order->id)
                ->with('error', 'This order has already been paid.');
        }


        /*
        |--------------------------------------------------------------------------
        | Check Amount
        |--------------------------------------------------------------------------
        */

        $amount = (float) $validated['amount'];

        $grandTotal = (float) $order->grand_total;


        if (round($amount, 2) != round($grandTotal, 2)) {

            return back()
                ->withInput()
                ->withErrors([
                    'amount' => 'Payment amount must be ₹' .
                        number_format($grandTotal, 2),
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Update Order
        |--------------------------------------------------------------------------
        */

        $order->customer_name = $validated['customer_name'];

        $order->customer_email =
            $validated['customer_email'] ?? null;

        $order->customer_phone =
            $validated['customer_phone'] ?? null;

        $order->payment_method =
            $validated['payment_method'];

        $order->payment_status = 'paid';

        $order->status = 'completed';

        $order->save();


        /*
        |--------------------------------------------------------------------------
        | Redirect To Bill
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('pos.order', $order->id)
            ->with('success', 'Payment completed successfully.');
    }

}