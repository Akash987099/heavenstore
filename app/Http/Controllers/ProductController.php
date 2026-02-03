<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Discount;
use App\Models\Product;
use Milon\Barcode\DNS1D;
use App\Models\Gallery;
use App\Models\Summer;

class ProductController extends Controller
{
    protected $category;
    protected $sub_category;
    protected $brand;
    protected $discount;
    protected $product;
    protected $gallery;
    protected $summer;

    public function __construct()
    {
        $this->category = new Category();
        $this->sub_category = new SubCategory();
        $this->brand = new Brand();
        $this->discount = new Discount();
        $this->product = new Product();
        $this->gallery = new Gallery();
        $this->summer = new Summer();
    }


    public function index()
    {
        $summer = $this->summer->all();
        $products = $this->product->orderBy('id', 'desc')->paginate(config('constants.pagination_limit'));
        return view('product.index', compact('products', 'summer'));
    }

    public function add()
    {
        $category = $this->category->all();
        $sub_category = $this->sub_category->all();
        $brand = $this->brand->all();
        $discount = $this->discount->all();
        return view('product.add', compact('category', 'sub_category', 'brand', 'discount'));
    }

    private function generateUniqueAwb()
    {
        do {
            $awb = random_int(10000000, 99999999);
        } while (Product::where('sku_product_id', $awb)->exists());

        return $awb;
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

    public function save(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image',
        ]);

        $awbNumber = $this->generateUniqueAwb();
        $barcodeBase64 = $this->generateBarcode($awbNumber);

        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('product'), $imageName);

        $product = $this->product;
        $product->name = $request->name;
        $product->sku_product_id = $awbNumber;
        $product->brand_name = $request->brand_name;
        $product->status = $request->status;
        $product->price = $request->price;
        $product->slug = $request->slug;
        $product->ac_price = $request->ac_price;
        $product->sku_code = $request->sku_code;
        $product->hsn_code = $request->hsn_code;
        $product->tags = $request->tags;
        $product->meta_tag = $request->meta_tag;
        $product->category = $request->category;
        $product->sub_category = $request->sub_category;
        $product->discount = $request->discount;
        $product->brands = $request->brand;
        $product->description = $request->description;
        $product->image = 'product/' . $imageName;
        $product->barcode_base = $barcodeBase64;
        $save = $product->save();

        if ($save) {
            return redirect()->back()->with('success', 'Successfully!');
        }
        return redirect()->back()->with('error', 'Failed!');
    }

    public function edit($id)
    {
        // dd($id);
        if (!$id) {
            return redirect()->back()->with('error', 'id not found!');
        }

        $product = $this->product->find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        $category = $this->category->all();
        $sub_category = $this->sub_category->all();
        $discount = $this->discount->all();
        $brand = $this->brand->all();
        return view('product.edit', compact('product', 'category', 'sub_category', 'discount', 'brand'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'    => 'required|exists:products,id',
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $product = $this->product->find($request->id);

        if (!$product) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        $product->name = $request->name;
        $product->status = $request->status;
        $product->price = $request->price;
        $product->ac_price = $request->ac_price;
        $product->sku_code = $request->sku_code;
        $product->hsn_code = $request->hsn_code;
        $product->tags = $request->tags;
        $product->meta_tag = $request->meta_tag;
        $product->category = $request->category;
        $product->sub_category = $request->sub_category;
        $product->discount = $request->discount;
        $product->brands = $request->brand;
        $product->slug = $request->slug;
        $product->description = $request->description;

        if ($request->hasFile('image')) {

            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('product'), $imageName);

            $product->image = 'product/' . $imageName;
        }

        if ($product->save()) {
            return redirect()->back()->with('success', 'Updated successfully!');
        }

        return redirect()->back()->with('error', 'Update failed!');
    }

    public function status(Request $request)
    {
        $status = $request->value;
        $id = $request->id;

        if (empty($id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'ID not found'
            ], 400);
        }

        $product = $this->product->find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found'
            ], 404);
        }

        $product->status = $product->status == 'active' ? 'inactive' : 'active';
        $product->save();

        return response()->json([
            'status'    => 'success',
        ], 200);
    }

    // Gallery

    public function gallery($id)
    {
        if (!$id) {
            return redirect()->back()->with('error', 'id not found!');
        }

        $product = $this->product->find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        $gallery = $this->gallery->where('product_id', $id)->get();

        return view('product.gallery', compact('product', 'gallery'));
    }

    public function gallery_save(Request $request)
    {
        $request->validate([
            'image'   => 'required',
            'id'      => 'required',
            'image.*' => 'image|mimes:jpg,jpeg,png,webp',
        ]);

        if ($request->hasFile('image')) {

            foreach ($request->file('image') as $file) {

                $gallery = new Gallery();

                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('gallery'), $imageName);

                $gallery->product_id = $request->id;
                $gallery->image = 'gallery/' . $imageName;
                $gallery->save();
            }

            return redirect()->back()->with('success', 'Images uploaded successfully!');
        }

        return redirect()->back()->with('error', 'No images found!');
    }

    public function gallery_delete($id)
    {

        if (!$id) {
            return response()->json(['status' => 'error', 'message' => "id not found!"]);
        }

        $gallery = $this->gallery->where('id', $id)->first();

        if (!$gallery) {
            return response()->json(['status' => 'error', 'message' => "Record not found!"]);
        }

        if ($gallery->image && file_exists(public_path($gallery->image))) {
            unlink(public_path($gallery->image));
        }

        $gallery = $this->gallery->where('id', $id)->delete();

        if (!$gallery) {
            return response()->json(['status' => 'error', 'message' => "Failed!"]);
        }

        return response()->json(['status' => 'success', 'message' => "Success!"]);
    }

    // Stock

    public function stock($id)
    {
        if (!$id) {
            return redirect()->back()->with('error', 'id not found!');
        }

        $product = $this->product->find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        return view('product.stock', compact('product'));
    }

    public function stockSave(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        if (!$id) {
            return redirect()->back()->with('error', 'id not found!');
        }

        $product = $this->product->where('id', $id)->update(['stock' => $request->stock]);

        if (!$product) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        return redirect()->back()->with('success', 'Success!');
    }

    public function selectStock(Request $request)
    {
        $status = $request->value;
        $id = $request->id;

        if (empty($id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'ID not found'
            ], 400);
        }

        $product = $this->product->find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found'
            ], 404);
        }

        $product->in_stock = $product->in_stock == 1 ? 0 : 1;
        $product->save();

        return response()->json([
            'status'    => 'success',
        ], 200);
    }

    public function summerStatus(Request $request){
        $status = $request->value;
        $id = $request->id;

        if (empty($id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'ID not found'
            ], 400);
        }

        $product = $this->product->find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found'
            ], 404);
        }

        $product->summer_id = $request->status;
        $product->save();

        return response()->json([
            'status'    => 'success',
        ], 200);
    }
}
