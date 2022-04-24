<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/user/register",
     *     tags={"User"},
     *     operationId="14",
     *     summary="Register new user",
     *     description="",
     *     @OA\RequestBody(
     *         description="Pet object that needs to be added to the store",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     * )
     */
    public function Register(Request $request){
        $validated=$request->validate([
                'name' => 'required|min:3|string',
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

    /**
     * @OA\Post(
     *     path="/user/login",
     *     tags={"User"},
     *     operationId="15",
     *     summary="Register new user",
     *     description="",
     *     @OA\RequestBody(
     *         description="Pet object that needs to be added to the store",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     * )
     */
    public function Login(Request $request){
        $validated=$request->validate([
                'email' => 'required|email:rfc|string',
                'password' => 'required|min:8|',
            ]
        );
        $user=User::where('email', $validated['email'])->first();
        if ($user && Hash::check($validated['password'],$user->password)) {
            $token =$user->createToken('theToken')->plainTextToken;
            return response(['user' => $user, 'token' => $token]);
        }
        else{
            return response(['message'=>'Unauthorized'], 401);
        }
    }
    /**
     * @OA\Get(
     *     path="/user/logout",
     *     tags={"User"},
     *     operationId="16",
     *     summary="Logout from account",
     *     description="",
     *     @OA\RequestBody(
     *         description="Pet object that needs to be added to the store",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     * )
     */
    public function Logout(){
        auth()->user()->tokens()->delete();
        return response(['message'=>'Logged Out']);
    }
    public function ChangePass(Request $request){
		$validated=$request->validate([
				'password' => 'required|min:8|confirmed',
			]
		);
		$user=auth()->user();
		$user->password=bcrypt($validated['password']);
		$user->save();
		return response(['message'=>'Password Changed']);
	}
}
