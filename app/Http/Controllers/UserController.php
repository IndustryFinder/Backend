<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


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
        $validated['role']='user';
        $user = User::create($validated);
        $token = $user->createToken('token')->plainTextToken;
        return response(['user' => $user, 'token' => $token],201);
    }

    public function Login(Request $request){
        $validated=$request->validate([
                'email' => 'required|email:rfc|string',
                'password' => 'required|min:8|',
            ]
        );
        $user=User::where('email', $validated['email'])->first();
        if ($user && Hash::check($validated['password'],$user->password)) {
            $token =$user->createToken('theToken')->plainTextToken;
            return response(['user' => $user->get(), 'token' => $token]);
        }
        else{
            return response(['message'=>'Unauthorized'], 401);
        }
    }

    public function Logout(){
        auth()->user()->tokens()->delete();
        return response(['message'=>'Logged Out']);
    }
}
