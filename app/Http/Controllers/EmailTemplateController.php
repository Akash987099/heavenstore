<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailTemplate;

class EmailTemplateController extends Controller
{
    protected $emailtemplate;

    public function __construct()
    {
        $this->emailtemplate = new EmailTemplate();
    }

    public function index(){
        $emails = $this->emailtemplate->orderBy('id', 'desc')->paginate(config('constants.pagination_limit'));
        return view('sms.email.index', compact('emails'));
    }

    public function add(){
        return view('sms.email.add');
    }

    public function save(Request $request){
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required',
        ]);

        $emailtemplate = $this->emailtemplate;
        $emailtemplate->name = $request->name;
        $emailtemplate->subject = $request->subject;
        $emailtemplate->description = $request->description;
        $save = $emailtemplate->save();

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

        $emailtemplate = $this->emailtemplate->find($id);

        if (!$emailtemplate) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        return view('sms.email.edit', compact('emailtemplate'));
    }

    public function update(Request $request){
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required',
        ]);

        $emailtemplate = $this->emailtemplate->find($request->id);
        $emailtemplate->name = $request->name;
        $emailtemplate->subject = $request->subject;
        $emailtemplate->description = $request->description;
        $save = $emailtemplate->save();

        if ($save) {
            return redirect()->back()->with('success', 'Successfully!');
        }
        return redirect()->back()->with('error', 'Failed!');
    }

}
