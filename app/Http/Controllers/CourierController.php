<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Couriers\DelhiveryService;
use App\Services\Couriers\AWC;
use App\Models\Courier;
use App\Models\Order;

class CourierController extends Controller
{
    protected $courier;
    protected $order;

    public function __construct(Courier $courier, Order $order)
    {
        $this->courier = $courier;
        $this->order = $order;
    }

    public function index()
    {
        $couriers = $this->courier->orderBy('id', 'desc')->paginate(config('constants.pagination_limit'));
        return view('courier.index', compact('couriers'));
    }

    public function add()
    {
        return view('courier.add');
    }

    public function save(Request $request)
    {
        $request->validate([
            'courier_name' => 'required|max:100',
            'courier_code' => 'required|max:50|unique:courier_partners,courier_code',
            'logo' => 'nullable|image',
        ]);

        $courier = new Courier();

        $courier->courier_name = $request->courier_name;
        $courier->courier_code = $request->courier_code;
        $courier->contact_person = $request->contact_person;
        $courier->contact_email = $request->contact_email;
        $courier->contact_mobile = $request->contact_mobile;
        $courier->website_url = $request->website_url;
        $courier->tracking_url = $request->tracking_url;
        $courier->api_base_url = $request->api_base_url;
        $courier->api_key = $request->api_key;
        $courier->api_secret = $request->api_secret;

        $courier->supports_cod = $request->has('supports_cod') ? 1 : 0;
        $courier->supports_prepaid = $request->has('supports_prepaid') ? 1 : 0;
        $courier->supports_reverse_pickup = $request->has('supports_reverse_pickup') ? 1 : 0;

        $courier->status = $request->status ?? 1;

        if ($request->hasFile('logo')) {

            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/couriers'), $filename);

            $courier->logo = 'uploads/couriers/' . $filename;
        }

        $courier->save();

        return redirect()
            ->route('courier.index')
            ->with('success', 'Courier Partner Added Successfully.');
    }

    public function edit($id)
    {
        $courier = $this->courier->find($id);

        if (!$courier) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        return view('courier.edit', compact('courier'));
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $courier = $this->courier->find($id);

        if (!$courier) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        $data = $request->except('logo');

        $data['supports_cod'] = $request->has('supports_cod') ? 1 : 0;
        $data['supports_prepaid'] = $request->has('supports_prepaid') ? 1 : 0;
        $data['supports_reverse_pickup'] = $request->has('supports_reverse_pickup') ? 1 : 0;

        if ($request->hasFile('logo')) {

            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/couriers'), $filename);

            $data['logo'] = 'uploads/couriers/' . $filename;
        }

        $courier->update($data);

        return redirect()->route('courier.index')
            ->with('success', 'Courier Updated Successfully');
    }

    public function updateStatus(Request $request)
    {
        $status = $request->value;
        $id = $request->id;

        if (empty($id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'ID not found'
            ], 400);
        }

        $courier = $this->courier->find($id);

        if (!$courier) {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found'
            ], 404);
        }

        $courier->status = $courier->status == 1 ? 0 : 1;
        $courier->save();

        return response()->json([
            'status'    => 'success',
        ], 200);
    }

    public function courier(Request $request)
    {
        // dd($request->all());
        $response = false;
        $request->validate([
            'id' => 'required|exists:orders,id',
            'courier_code' => 'required|exists:courier_partners,courier_code'
        ]);

        try {

            $order = Order::findOrFail($request->id);

            if (!$order) {
                return response()->json([
                    'status' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            if ($request->courier_code == "DL01") {
                $delhivery = new DelhiveryService();
                $response = $delhivery->createShipment($order);
            }

            if ($request->courier_code == "AWC02") {
                $awc = new AWC();
                $response = $awc->createShipment($order);

                if ($response instanceof \Illuminate\Http\JsonResponse) {
                    $response = $response->getData(true);
                }
            }

            if (!empty($response['error']) || empty($response['success'])) {

                return response()->json([
                    'status' => false,
                    'message' => $response['rmk'] ?? 'Failed to create shipment'
                ], 500);
            }

            $order->courier_id = $request->courier_id;
            // $order->courier_code = $request->courier_code;
            $order->save();

            return response()->json([
                'status' => true,
                'message' => 'Courier assigned successfully'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
