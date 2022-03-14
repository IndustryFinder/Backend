<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function Register(Request $request){
        $validated=$request->validate([
                'name' => 'required|min:5|string',
                'email' => 'required|email:rfc|unique:users,email|string',
                'password' => 'required|min:8|confirmed',
            ]
        );
        $validated['password']=bcrypt($validated['password']);
        $user = User::create($validated);
        $token = $user->createToken('token')->plainTextToken;
        return response(['user' => $user, 'token' => $token],201);
    }



    public function Logout(){
        auth()->user()->tokens()->delete();
        return response('Logged Out');
    }
}
