<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plateform;

class PlateformController extends Controller
{
    protected $plateform;

    public function __construct()
    {
        $this->plateform = new Plateform();
    }

    public function index()
    {
        $plateform = $this->plateform->orderBy('id', 'desc')->paginate(config('constants.pagination_limit'));
        return view('plateform.index', compact('plateform'));
    }

    public function add()
    {
        return view('plateform.add');
    }

    public function save(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required',
        ]);

        $plateform = $this->plateform;
        $plateform->name = $request->name;
        $plateform->slug = $request->slug;
        $plateform->website_url = $request->website;

        if ($request->hasFile('image')) {

            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('category'), $imageName);

            $plateform->logo = 'category/' . $imageName;
        }

        $save = $plateform->save();

        if ($save) {
            return redirect()->back()->with('success', 'Successfully!');
        }
        return redirect()->back()->with('error', 'Failed!');
    }

    public function edit($id)
    {
        if (!$id) {
            return redirect()->back()->with('error', 'id not found!');
        }

        $plateform = $this->plateform->find($id);

        if (!$plateform) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        return view('plateform.edit', compact('plateform'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'    => 'required|exists:category,id',
            'name'  => 'required|string|max:255',
            'image' => 'nullable',
        ]);

        $plateform = $this->plateform->find($request->id);

        if (!$plateform) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        $plateform->name = $request->name;
        $plateform->slug = $request->slug;
        $plateform->website_url = $request->website;

        if ($request->hasFile('image')) {

            if ($plateform->logo && file_exists(public_path($plateform->logo))) {
                unlink(public_path($plateform->logo));
            }

            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('category'), $imageName);

            $plateform->logo = 'category/' . $imageName;
        }

        if ($plateform->save()) {
            return redirect()->back()->with('success', 'Platform updated successfully!');
        }

        return redirect()->back()->with('error', 'Update failed!');
    }

}
