<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pos;
use App\Models\Store;
use Illuminate\Validation\Rule;
use App\Models\PosOrder;
use App\Models\PosOrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class PosUserController extends Controller
{
    protected $pos;
    protected $store;
    protected $product;
    protected $order;
    protected $orderdetails;

    public function __construct(){
        $this->pos = new Pos();
        $this->store = new Store();
        $this->product = new Product();
        $this->order   = new PosOrder();
        $this->orderdetails = new PosOrderDetail();
    }

    public function index(){
        $posuser = $this->pos
        ->with('store')
        ->where('role', 1)
        ->orderBy('id', 'desc')
        ->paginate(config('constants.pagination_limit'));
        return view('posuser.index', compact('posuser'));
    }

    public function add(){
        $store = $this->store->all();
        return view('posuser.add', compact('store'));
    }

    public function save(Request $request){
        $request->validate([
            'name'   => 'required|string|max:255',
            'mobile' => 'required|digits:10|unique:pos,mobile',
            'email'  => 'required|email|max:255|unique:pos,email',
            'store'  => 'required',
            'password' => 'required|string|min:6',
        ]);

        $pos = $this->pos;
        $pos->name = $request->name;
        $pos->mobile = $request->mobile;
        $pos->email = $request->email;
        $pos->store_id = $request->store;
        $pos->role = 1;
        $pos->staff_id = generateStaffId();
        $pos->password = Hash::make($request->password);

        $save = $pos->save();

        if ($save) {
            return redirect()->back()->with('success', 'Successfully!');
        }
        return redirect()->back()->with('error', 'Failed!');
    }

    public function edit($id){
        if (!$id) {
            return redirect()->back()->with('error', 'id not found!');
        }

        $pos = $this->pos->find($id);

        if (!$pos) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        $store = $this->store->all();

        return view('posuser.edit', compact('pos', 'store'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'     => 'required|exists:pos,id',
            'name'   => 'required|string|max:255',

            'mobile' => [
                'required',
                'digits:10',
                Rule::unique('pos', 'mobile')->ignore($request->id),
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('pos', 'email')->ignore($request->id),
            ],

            'store'  => 'required|exists:store,id',
        ]);

        $pos = $this->pos->find($request->id);

        if (!$pos) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        $pos->name = $request->name;
        $pos->mobile = $request->mobile;
        $pos->email = $request->email;
        $pos->store_id = $request->store;
        $pos->role = 1;


        if ($pos->save()) {
            return redirect()->back()->with('success', 'Category updated successfully!');
        }

        return redirect()->back()->with('error', 'Update failed!');
    }

    public function orders(){
        $orders = PosOrder::with('details')
                ->orderBy('id', 'desc')
                ->paginate(config('constants.pagination_limit'));

        return view('posuser.orders', compact('orders'));
    }

    public function orderView($id){
        $order = PosOrder::with('details')
            ->where('id', $id)
            ->firstOrFail();


        return view(
            'posuser.order-bill',
            compact('order')
        );
    }
}