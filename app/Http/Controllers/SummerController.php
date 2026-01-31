<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Summer;

class SummerController extends Controller
{
    protected $summer;

    public function __construct()
    {
        $this->summer = new Summer();
    }

    public function index(){
        $summer = $this->summer->orderBy('id', 'desc')->paginate(config('pagination_limit'));
        return view('summer.index', compact('summer'));
    }

    public function add(){
        return view('summer.add');
    }

    public function save(Request $request){
        // dd($request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required'
        ]);

        $summer = $this->summer;
        $summer->name = $request->name;
        $summer->sub_name = $request->title;
        $summer->time = $request->time;
        $save = $summer->save();

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

        $summer = $this->summer->find($id);

        if (!$summer) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        return view('summer.edit', compact('summer'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required'
        ]);

        $summer = $this->summer->find($request->id);

        if (!$summer) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        $summer->name = $request->name;
        $summer->sub_name = $request->title;
        $summer->time = $request->time;

        if ($summer->save()) {
            return redirect()->back()->with('success', 'Updated successfully!');
        }

        return redirect()->back()->with('error', 'Update failed!');
    }

}
