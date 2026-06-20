<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Customer;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function logins(Request $request)
    {
        // dd($request->all());
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error', 'message' => 'Invalid username or password.']);
    }
    public function loginForm(){
        return view('auth.user-login');
    }
    public function loginPost(Request $request){
        $credentials = $request->only('username', 'password');

        if (Auth::guard('user')->attempt($credentials)) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error', 'message' => 'Invalid username or password.']);
    }
    public function loginClient(Request $request){
        return view('auth.client-login');
    }
    public function loginsClient(Request $request){
        $credentials = $request->only('email', 'password');

        if (Auth::guard('client')->attempt($credentials)) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error', 'message' => 'Invalid username or password.']);
    }

    public function userlogin(){
        return view('auth.user-login');
    }

    public function userlogins(Request $request){
        // echo '1111';
        // exit();
        $credentials = $request->only('email', 'password');

        if (Auth::guard('user')->attempt($credentials)) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error', 'message' => 'Invalid username or password.']);
    }
}
