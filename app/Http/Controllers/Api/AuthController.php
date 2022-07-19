<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    //Signup
    public function signup(Request $request)
    {
        try{
            if(!$request->has('name') && $request->name != "")
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Name is Required',
                ], 200);
            }

            if(!$request->has('email') && $request->email != "")
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Email is Required',
                ], 200);
            }

            $already = User::where('email', $request->email)->first('id');

            if(!empty($already))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Email has already been Taken',
                ], 200);
            }

            if(!$request->has('password') && $request->password != "")
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Password is Required',
                ], 200);
            }

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => "Glad You've Joined Us",
                'data' => $user
            ], 200);
        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'There is some trouble to proceed your action',
            ], 200);
        }
    }

    //Login
    public function login(Request $request)
    {
        // try{
            $loginData = $request->validate([
                'email' => 'string|required',
                'password' => 'required|max:255'
            ]);
            
            if(!auth()->attempt($loginData))
            {
                if($request->expectsJson())
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Invalid Credentials',
                    ], 200);
                }           
            } 
                    
            if($request->has('token'))
            {
                $user = User::where('email', $request->email)->first();
                $user->token = $request->token;
                $user->save();
            } 
        
            return response()->json([
                'status' => true,
                'message' => "Glad You've Joined Us",
                'data' => auth()->user()->makeHidden(['created_at', 'updated_at']),
            ], 200);                   
            
        // }catch(\Exception $e)
        // {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'There is some trouble to proceed your action',
        //     ], 200);
        // }        
    }   
}