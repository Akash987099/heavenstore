<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;

class UserController extends Controller
{
    protected $user;
    protected $address;

    public function __construct()
    {
        $this->user = new User();
        $this->address = new Address();
    }
    
    public function addAddress(Request $request){
        dd($request->all());
    }
    
}
