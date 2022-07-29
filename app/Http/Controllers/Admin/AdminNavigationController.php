<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminNavigationController extends Controller
{
    public function dashboard()
    {
        $users = User::where('type', '1')->orderBy('id', 'desc')->get();

        return view('admin.dashboard', compact(['users']));
    }
    
    public function edit_user($user_id)
    {
        $user = User::where('id', $user_id)->first();
        
        return view('admin.users.edit', compact('user'));
    }
    
    public function update_user(Request $request)
    {
        
        $user = User::where('id', $request->user_id)->first();
        
        if($request->has('stripe_id'))
        {
            $user->stripe_id = $request->stripe_id;
        }
        
        return back()->with('message', 'User Info Updated');
    }
}
