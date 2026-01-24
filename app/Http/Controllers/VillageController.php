<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\village;
use App\Models\Block;

class VillageController extends Controller
{
    protected $block;
    protected $village;

    public function __construct()
    {
        $this->block = new Block();
        $this->village = new village();
    }

    public function index()
    {
        $villages = $this->village
            ->join('blocks', 'villages.block_id', '=', 'blocks.id')
            ->select('villages.*', 'blocks.name as block_name')
            ->orderBy('blocks.id', 'desc')
            ->paginate(config('constants.pagination_limit'));
            // dd($villages);

        return view('village.index', compact('villages'));
    }

    public function add()
    {
        $blocks = $this->block->all();
        return view('village.add', compact('blocks'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $village = $this->village;
        $village->name = $request->name;
        $village->block_id = $request->block;
        $save = $village->save();

        if ($save) {
            return redirect()->back()->with('success', 'Successfully!');
        }
        return redirect()->back()->with('error', 'Failed!');
    }

    public function edit($id)
    {
        $village = $this->village->find($id);
        $blocks = $this->block->all();
        return view('village.edit', compact('blocks', 'village'));
    }

    public function update(Request $request){
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $village = $this->village->find($request->id);
        $village->name = $request->name;
        $village->block_id = $request->block;
        $save = $village->save();

        if ($save) {
            return redirect()->back()->with('success', 'Successfully!');
        }
        return redirect()->back()->with('error', 'Failed!');
    }
}
