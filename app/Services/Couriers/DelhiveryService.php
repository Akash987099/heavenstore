<?php

namespace App\Services\Couriers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use App\Models\Client;
use App\Models\Product;

class DelhiveryService
{
    protected $token;
    protected $baseUrl;

    public function __construct()
    {
        $this->token = "14fda0cd592a0614d06576920d0c2819b97d0884";
        $this->baseUrl = "https://staging-express.delhivery.com";
    }

    public function createShipment($data)
    {
        $userID = $data->user_id;
        $user = User::find($userID);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $address_id = $data->address_id;
        $address = Address::find($address_id);

        if (!$address) {
            return response()->json(['error' => 'Address not found'], 404);
        }

        $client = Client::where('client_id', 'CLT-IYYHBWTM')->first();

        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        $product = Product::find($data->product_id);

        $payment_mode = strtolower($data->payment_method) == 'cod'
            ? 'COD'
            : 'Prepaid';

        $payload = [
            'pickup_location' => [
                'name'    => $client->name,
                'add'     => $client->pickup_address,
                'pin'     => $client->pickup_pincode,
                'city'    => $client->pickup_city,
                'state'   => $client->pickup_state,
                'country' => 'India',
                'phone'   => $client->phone,
            ],

            'shipments' => [
                [
                    'name'          => $address->person ?? $user->name,
                    'add'           => $address->address,
                    'pin'           => $address->pincode,
                    'city'          => $address->district,
                    'state'         => $address->state,
                    'country'       => 'India',
                    'phone'         => $address->contact,
                    'order'         => $data->contact ?? $address->id,
                    'payment_mode'  => $payment_mode, // COD / Prepaid
                    'products_desc' => $product->name ?? 'test product',
                    'cod_amount'    => $payment_mode == 'COD' ? $data->total_discount : 0,
                    'weight'        => 0.5,
                ]
            ]
        ];

        try {

            $response = Http::timeout(60)
                ->withHeaders([
                    'Authorization' => 'Token ' . $this->token,
                    'Content-Type'  => 'application/json',
                ])
                ->post(
                    $this->baseUrl . '/api/cmu/create.json',
                    $payload
                );
            return $response->json();
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
