<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index(){
        $users = $this->user->paginate(config('constants.pagination_limit'));
        return view('wholesale.index', compact('users'));
    }
}
