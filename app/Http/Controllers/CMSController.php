<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CMS;

class CMSController extends Controller
{
    protected $cms;

    public function __construct()
    {
        $this->cms = new CMS();
    }
    public function index()
    {
        $cms = $this->cms->orderBy('id', 'desc')->paginate(config('constants.pagination_limit'));
        return view('cms.index', compact('cms'));
    }

    public function add()
    {
        return view('cms.add');
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
        ]);

        $cms = $this->cms;
        $cms->name = $request->name;
        $cms->url = $request->url;
        $cms->name = 1;
        $cms->description = $request->description;
        $save = $cms->save();

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

        $cms = $this->cms->find($id);

        if (!$cms) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        return view('cms.edit', compact('cms'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'    => 'required|exists:cms,id',
            'name'  => 'required|string|max:255',
        ]);

        $cms = $this->cms->find($request->id);

        if (!$cms) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        $cms->name = $request->name;
        $cms->url = $request->url;
        $cms->description = $request->description;


        if ($cms->save()) {
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

        $cms = $this->cms->find($id);

        if (!$cms) {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found'
            ], 404);
        }

        $cms->status = $cms->status == '1' ? '0' : '1';
        $cms->save();

        return response()->json([
            'status'    => 'success',
        ], 200);
    }

    public function delete($id)
    {
        try {
            $cms = $this->cms->findOrFail($id);
            $cms->delete();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'exceptionError',
                'error'  => $e->getMessage()
            ], 500);
        }
    }
}
