<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    protected $store;

    public function __construct()
    {
        $this->store = new Store();
    }

    public function index()
    {
        $store = $this->store->orderBy('id', 'desc')->paginate(config('constants.pagination_limit'));
        return view('store.index', compact('store'));
    }

    public function add()
    {
        return view('store.add');
    }

    public function save(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'zipcode'  => 'required',
            'city'  => 'required|string|max:255',
            'address'  => 'required|string|max:255',
            'description'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('store'), $imageName);

        $store = $this->store;
        $store->name = $request->name;
        $store->zipcode = $request->zipcode;
        $store->city = $request->city;
        $store->address = $request->address;
        $store->description = $request->description;
        $store->image = 'srore/' . $imageName;
        $save = $store->save();

        if ($save) {
            return redirect()->back()->with('success', 'Successfully!');
        }
        return redirect()->back()->with('error', 'Failed!');
    }

    public function edit($id){
        if (!$id) {
            return redirect()->back()->with('error', 'id not found!');
        }

        $store = $this->store->find($id);

        if (!$store) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        return view('store.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'zipcode'  => 'required',
            'city'  => 'required|string|max:255',
            'address'  => 'required|string|max:255',
            'description'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $store = $this->store->find($request->id);

        if (!$store) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        $store->name = $request->name;
        $store->zipcode = $request->zipcode;
        $store->city = $request->city;
        $store->address = $request->address;
        $store->description = $request->description;

        if ($request->hasFile('image')) {

            if ($store->image && file_exists(public_path($store->image))) {
                unlink(public_path($store->image));
            }

            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('store'), $imageName);

            $store->image = 'store/' . $imageName;
        }

        if ($store->save()) {
            return redirect()->back()->with('success', 'Updated successfully!');
        }

        return redirect()->back()->with('error', 'Update failed!');
    }

}
