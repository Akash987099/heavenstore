<?php

namespace App\Services\Couriers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use App\Models\Client;
use App\Models\Product;
use App\Models\Shipment;
use Milon\Barcode\DNS1D;

class AWC
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

        $barcode = $this->barcode($data->id);

        $insertdata = [
            'order_id' => $data->id,
            'courier_id' => 2,
            'courier_code' => 'AWC02',
            'tracking_number' => $data->order_no,
            'status' => 'created',
            'shipment_response' => json_encode($payload),
            'barcode_url' => $barcode
        ];

        $shipment = Shipment::create($insertdata);
        // dd($shipment);
        if (!$shipment) {
            return response()->json(['error' => 'Failed to create shipment record'], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Shipment created successfully',
            'data' => $shipment
        ], 201);
            
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while creating shipment with AWC'
            ], 500);
        }
    }

    public function barcode($id)
    {
        if (!$id) {
            return redirect()->back()->with('error', 'Order id not found!');
        }

        $order = Order::find($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found!');
        }

        $awbNumber = $order->order_no;
        $barcodeBase64 = $this->generateBarcode($awbNumber);

        return $barcodeBase64;
    }

    private function generateBarcode($awb)
    {
        $dns1d = new DNS1D();

        $barcodeBase64 = $dns1d->getBarcodePNG($awb, 'C128', 2, 60);
        $barcodeImage = imagecreatefromstring(base64_decode($barcodeBase64));

        $barcodeWidth  = imagesx($barcodeImage);
        $barcodeHeight = imagesy($barcodeImage);

        $finalHeight = $barcodeHeight + 30;
        $finalImage  = imagecreatetruecolor($barcodeWidth, $finalHeight);

        $white = imagecolorallocate($finalImage, 255, 255, 255);
        $black = imagecolorallocate($finalImage, 0, 0, 0);

        imagefill($finalImage, 0, 0, $white);

        imagecopy($finalImage, $barcodeImage, 0, 0, 0, 0, $barcodeWidth, $barcodeHeight);

        $fontSize = 5;
        $textWidth = imagefontwidth($fontSize) * strlen($awb);
        $textX = ($barcodeWidth - $textWidth) / 2;
        $textY = $barcodeHeight + 5;

        imagestring($finalImage, $fontSize, $textX, $textY, $awb, $black);

        ob_start();
        imagepng($finalImage);
        $imageData = ob_get_clean();

        imagedestroy($barcodeImage);
        imagedestroy($finalImage);

        return 'data:image/png;base64,' . base64_encode($imageData);
    }

}
