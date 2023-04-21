<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AddCashRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\TodoUpdateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\WithdrawRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;


class UserController extends Controller
{
	public function ChangePass(ChangePasswordRequest $request){
		$validated=$request->validated();
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

	public function update(UpdateRequest $request){
		$validated=$request->validated();
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


    public function TodoUpdate(TodoUpdateRequest $request){
        $validated=$request->validated();
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
    public function AddCash(AddCashRequest $request){
        $validated=$request->validated();
        $id=auth('sanctum')->user()->id;
        $user=User::find($id);
        $user->wallet+=$validated['cash'];
        $user->save();
        return response(['message'=>'Updated','Balance'=>$user->wallet],200);
    }

    public function Withdraw(WithdrawRequest $request){
        $validated=$request->validated();
        $id=auth('sanctum')->user()->id;
        $user=User::find($id);
        if($user->wallet >= $validated['cash']){
            $user->wallet-=$validated['cash'];
            $user->save();
            return response(['message'=>'Updated','Balance'=>$user->wallet],200);}
        else
            return response(['message'=>'Not enough money','Balance'=>$user->wallet], 400);
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
