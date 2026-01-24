<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tehsil;
use App\Models\Block;

class BlockController extends Controller
{
    protected $tehsil;
    protected $block;

    public function __construct()
    {
        $this->tehsil = new Tehsil();
        $this->block  = new Block();
    }

    public function index()
    {
        $blocks = $this->block
            ->join('tehsils', 'blocks.tehsil_id', '=', 'tehsils.id')
            ->select('blocks.*', 'tehsils.name as tehsil_name')
            ->orderBy('blocks.id', 'desc')
            ->paginate(config('constants.pagination_limit'));

        return view('block.index', compact('blocks'));
    }

    public function add()
    {
        $tehsils = $this->tehsil->all();
        return view('block.add', compact('tehsils'));
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $block = $this->block;
        $block->name = $request->name;
        $block->tehsil_id = $request->tehsil;
        $save = $block->save();

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

        $block = $this->block->find($id);

        if (!$block) {
            return redirect()->back()->with('error', 'Record not found!');
        }
        $tehsils = $this->tehsil->all();
        return view('block.edit', compact('block', 'tehsils'));
    }

    public function update(Request $request){
        // dd($request->all());

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $block = $this->block->find($request->id);
        $block->name = $request->name;
        $block->tehsil_id = $request->tehsil;
        $save = $block->save();

        if ($save) {
            return redirect()->back()->with('success', 'Successfully!');
        }
        return redirect()->back()->with('error', 'Failed!');
    }

}
