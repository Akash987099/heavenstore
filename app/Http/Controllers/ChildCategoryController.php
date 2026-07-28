<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;

class ChildCategoryController extends Controller
{
    protected $category;
    protected $subcategory;
    protected $childcategory;

    public function __construct()
    {
        $this->category = new Category();
        $this->subcategory = new SubCategory();
        $this->childcategory = new ChildCategory();
    }

    public function index($id)
    {
        if (!$id) {
            return redirect()->back()->with('error', 'Sub Category ID not found.');
        }

        $subcategory = $this->subcategory->find($id);

        if (!$subcategory) {
            return redirect()->back()->with('error', 'Sub Category not found.');
        }

        $childcategory =   $childcategory = $this->childcategory
                            ->with('subCategory.category')
                            ->where('sub_category_id', $id)
                            ->paginate(config('constants.pagination_limit'));

        return view('child_category/index', compact('childcategory', 'id'));
    }

    public function add($id){
        if (!$id) {
            return redirect()->back()->with('error', 'Sub Category ID not found.');
        }

        $subcategory = $this->subcategory->find($id);

        if (!$subcategory) {
            return redirect()->back()->with('error', 'Sub Category not found.');
        }
        
        return view('child_category/add', compact('id'));
    }

    public function save(Request $request, $id){

        if (!$id) {
            return redirect()->back()->with('error', 'Sub Category ID not found.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required',
        ]);

        $childcategory = $this->childcategory;
        $childcategory->name = $request->name;
        $childcategory->sub_category_id = $id;
        $childcategory->description = $request->description;

        if ($request->hasFile('image')) {

            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('category'), $imageName);

            $childcategory->image = 'category/' . $imageName;
        }

        $save = $childcategory->save();

        if ($save) {
            return redirect()->back()->with('success', 'Successfully!');
        }
        return redirect()->back()->with('error', 'Failed!');
    }
}