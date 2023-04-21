<?php

namespace App\Http\Controllers;

use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\SignupRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loggedInUser(){
        $user=auth()->user()->id;
        $user=User::find($user);
        $user['company']=$user->company;
        return response()->json($user);
    }

    public function Register(SignupRequest $request)
    {
        $validated=$request->validated();

        $validated['password']=bcrypt($validated['password']);
        $validated['role']    ='user';
        $user                 =User::create($validated);
        $token                =$user->createToken('token')->plainTextToken;
        return response(['user'=>$user,'token'=>$token],201);
    }
    public function Login(LoginRequest $request){
        $validated=$request->validated();
        $user=User::where('email', $validated['email'])->first();
        if ($user && Hash::check($validated['password'],$user->password)) {
            $token =$user->createToken('theToken')->plainTextToken;
            return response(['user' => $user, 'token' => $token]);
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
