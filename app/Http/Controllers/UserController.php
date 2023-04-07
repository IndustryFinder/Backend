<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\facades;
use Intervention\Image\Facades\Image;


class UserController extends Controller
{

	public function loggedInUser(){
        $user=auth()->user()->id;
        $user=User::find($user);
        $user['company']=$user->company;
        return response()->json($user);
	}

	public function Register(Request $request)
	{
		$validated=$request->validate([
				'name'=>'required|min:3|string',
				'email'=>'required|email:rfc|unique:users,email|string',
				'password'=>'required|min:8|confirmed',
			]
		);

		$validated['password']=bcrypt($validated['password']);
		$validated['role']    ='user';
		$user                 =User::create($validated);
		$token                =$user->createToken('token')->plainTextToken;
		return response(['user'=>$user,'token'=>$token],201);
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

	public function ChangePass(Request $request){
		$validated=$request->validate([
			'password' => 'required',
			'new_password' => 'required|min:8|confirmed',
			]
		);
		$user=auth()->user();
		if (Hash::check($validated['password'],$user->password)) {
			$user->password=bcrypt($validated['new_password']);
			$user->save();
			return response(['message'=>'Password Changed']);
		}
		else{
			return response(['message'=>'Unauthorized'], 401);
		}
	}

	public function update(Request $request){
		$validated=$request->validate([

				'name' => 'min:3|string',
				'phone' => 'min:10|string',
				'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
				'email' => 'email:rfc|string|unique:users,email',

			]
		);
		$user=auth()->user();
		if (isset($validated['name'])) $user->name=$validated['name'];
		if (isset($validated['phone'])) $user->phone=$validated['phone'];
		if (isset($validated['email'])) $user->email=$validated['email'];
		if($request->hasFile('avatar')){
			$avatar=$request->file('avatar');
			$filename=uniqid().'.'.$avatar->getClientOriginalExtension();
			Image::make($avatar)->resize(300,300)->save(public_path('/storage/avatars/'.$filename));
			$user->avatar=$filename;
		}
		$user->save();
		return response(['user'=>$user]);
	}


    public  function  TodoUpdate(Request $request){
        $validated=$request->validate([
                'todo' => 'required|string',
            ]
        );
        $id=auth('sanctum')->user()->id;
        $user=User::find($id);
        $user->todo=$validated['todo'];
        $user->save();
        return response(['message'=>'Updated'],200);
    }

    public  function GetBalance(){
        $id=auth('sanctum')->user()->id;
        $user=User::find($id);
        return response(['Balance'=>$user->wallet,'adsUsed'=>$user->Ad->count()],200);
    }
    public function AddCash(Request $request){
        $validated=$request->validate([
                'cash' => 'required|numeric',
            ]
        );
        $id=auth('sanctum')->user()->id;
        $user=User::find($id);
        $user->wallet+=$validated['cash'];
        $user->save();
        return response(['message'=>'Updated','Balance'=>$user->wallet],200);
    }

    public function Withdraw(Request $request){
        $validated=$request->validate([
                'cash' => 'required|numeric',
            ]
        );
        $id=auth('sanctum')->user()->id;
        $user=User::find($id);
        if($user->wallet >= $validated['cash']){
            $user->wallet-=$validated['cash'];
            $user->save();
            return response(['message'=>'Updated','Balance'=>$user->wallet],200);}
        else
            return response(['message'=>'Not enough money','Balance'=>$user->wallet], 400);
    }

	public function Categories(){
		$categories=Category::all();
		return response(['categories'=>$categories]);
	}

	public function fakeAdder(){
		for ($i=1; $i<=123; $i++){
			$user=new User();
			$user->name='کاربر آزمایشی '. $i;
			$user->password=bcrypt('12345678');
			$user->email='testData'.$i.'@gmail.com';
			$user->role='user';
			$user->save();
			echo $i;
//			$company=new Company();
//			$company->name='شرکت آزمایشی'.$i;
//			$company->category_id=rand(9,20);
//			$company->user_id=$i;
//			$company->email='sample'.$i.'@outlook.com';
//			$company->phone='0'.(9123456700+$i);
//			$company->save();
		}
	}
}
