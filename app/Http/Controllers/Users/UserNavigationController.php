<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserNavigationController extends Controller
{
    public function dashboard()
    {
        return view('users.dashboard');
    }
}
