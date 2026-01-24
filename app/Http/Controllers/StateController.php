<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Countries;

class StateController extends Controller
{
    protected $state;
    protected $country;

    public function __construct()
    {
        $this->state = new State();
        $this->country = new Countries();
    }
    public function index()
    {
        $state = $this->state->join('countries', 'state.country_id', 'Countries.id')->orderBy('state.id', 'desc')->paginate(config('constants.pagination_limit'));
        // dd($state);
        return view('state.index', compact('state'));
    }
    public function add()
    {
        $country = $this->country->all();
        return view('state.add', compact('country'));
    }
    public function store(Request $request)
    {
        $data = [
            'country_id' => $request->country,
            'name'       => $request->name,
            'short_name' => $request->short_name
        ];

        $this->state->create($data);
        return redirect()->back()->with('success', 'Success!');
    }
    public function edit($id)
    {
        $state = $this->state->find($id);
        $country = $this->country->all();
        return view('state.edit', compact('state', 'country'));
    }
    public function update(Request $request)
    {
        $state = $this->state->find($request->id);
        $data = [
            'country_id' => $request->country,
            'name'       => $request->name,
            'short_name' => $request->short_name
        ];

        $state->save($data);
        return redirect()->back()->with('success', 'Success!');
    }
    
}
