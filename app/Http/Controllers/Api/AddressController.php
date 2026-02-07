<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    protected $address;

    public function __construct()
    {
        $this->address = new Address();
    }

    public function addAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'     => 'required|integer',
            'country'     => 'required|string',
            'state'       => 'required|string',
            'district'    => 'required|string',
            'tehsil'      => 'required|string',
            'block'       => 'required|string',
            'village'     => 'required|string',
            'address'     => 'required|string',
            'pincode'     => 'required|digits:6',
            'person'      => 'required|string',
            'contact'     => 'required|digits_between:10,12',
            'is_default'  => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        if ($request->is_default == 1) {
            Address::where('user_id', $request->user_id)
                ->update(['is_default' => 0]);
        }

        $address = Address::create([
            'user_id'    => $request->user_id,
            'country'    => $request->country,
            'state'      => $request->state,
            'district'   => $request->district,
            'tehsil'     => $request->tehsil,
            'block'      => $request->block,
            'village'    => $request->village,
            'address'    => $request->address,
            'pincode'    => $request->pincode,
            'person'     => $request->person,
            'contact'    => $request->contact,
            'is_default' => $request->is_default,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Address added successfully',
            'data'    => $address,
        ], 200);
    }

    public function updateAddress(Request $request)
    {
        $id = $request->id;

        $validator = Validator::make($request->all(), [
            'id'          => 'required|integer',
            'user_id'     => 'required|integer',
            'country'     => 'required|string',
            'state'       => 'required|string',
            'district'    => 'required|string',
            'tehsil'      => 'required|string',
            'block'       => 'required|string',
            'village'     => 'required|string',
            'address'     => 'required|string',
            'pincode'     => 'required|digits:6',
            'person'      => 'required|string',
            'contact'     => 'required|digits_between:10,12',
            'is_default'  => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $address = Address::where('id', $id)
            ->where('user_id', $request->user_id)
            ->first();

        if (!$address) {
            return response()->json([
                'status'  => false,
                'message' => 'Address not found',
            ], 404);
        }

        if ($request->is_default == 1) {
            Address::where('user_id', $request->user_id)
                ->where('id', '!=', $id)
                ->update(['is_default' => 0]);
        }

        $address->update([
            'country'    => $request->country,
            'state'      => $request->state,
            'district'   => $request->district,
            'tehsil'     => $request->tehsil,
            'block'      => $request->block,
            'village'    => $request->village,
            'address'    => $request->address,
            'pincode'    => $request->pincode,
            'person'     => $request->person,
            'contact'    => $request->contact,
            'is_default' => $request->is_default,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Address updated successfully',
            'data'    => $address,
        ], 200);
    }

    public function deleteAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'      => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $address = Address::where('id', $request->id)
            ->where('user_id', $request->user_id)
            ->first();

        if (!$address) {
            return response()->json([
                'status'  => false,
                'message' => 'Address not found',
            ], 404);
        }

        if ($address->is_default == 1) {
            return response()->json([
                'status'  => false,
                'message' => 'Default address cannot be deleted',
            ], 403);
        }

        $address->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Address deleted successfully',
        ], 200);
    }

    public function userAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $address = $this->address->where('user_id', $request->user_id)->get();

        if(!$address){
            return response()->json([
                'statis' => false,
                'message' => 'no record found!'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success!',
            'data'   => $address
        ]);
    }
}
