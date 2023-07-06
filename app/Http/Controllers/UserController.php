<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AddCashRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\TodoUpdateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\WithdrawRequest;
use App\Models\Request;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;


class UserController extends Controller
{
    public function ResetPass(HttpRequest $request){
        $request->validate(['email' => 'required|email']);

        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response(['status' => __($status)])
            : response(['email' => __($status)]);
    }

    public function RecoverPass(HttpRequest $request){
        return redirect(env("FRONTEND_URL").'/reset-password/'.$request->token);
    }

    public function SubmitNewPass(HttpRequest $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

//                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response(['status', __($status)], 200)
            : response(['email' => [__($status)]], 401);
    }

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
            $location = 'avatar';
            $validated['avatar'] = Storage::put($location, $avatar);
            $user['avatar'] = $validated['avatar'];
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
        if($validated['cash'] < 0)
            return response(['message'=>'Invalid input'],422);
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

    public function BuyPlan($id){
        $userId=auth('sanctum')->user()->id;
        $user=User::find($userId);
        $currentDateTime = Carbon::now();
        if($user->AdsRemaining > 0 && $currentDateTime < $user->PlanExpireDate){
            return response(['message'=>'Already has active plan','PlanName'=>$user->activePlan,'AdsRemaining'=>$user->AdsRemaining,'PlanExpireDate'=>$user->PlanExpireDate], 409);
        }
        switch ($id) {
            case 1:
                if($user->wallet >= 25000){
                    $user->wallet -= 25000;
                    $user->AdsRemaining = 10;
                    $user->PlanExpireDate = Carbon::now()->addDays(30);
                    $user->activePlan = 'classic';
                    $user->save();
                    return response(['message'=>'Successfully bought','Balance'=>$user->wallet, 'activePlan'=>$user->activePlan,'AdsRemaining'=>$user->AdsRemaining,'PlanExpireDate'=>$user->PlanExpireDate],200);
                }
                break;
            case 2:
                if($user->wallet >= 50000){
                    $user->wallet -= 50000;
                    $user->AdsRemaining = 15;
                    $user->PlanExpireDate = Carbon::now()->addDays(60);
                    $user->activePlan = 'pro';
                    $user->save();
                    return response(['message'=>'Successfully bought','Balance'=>$user->wallet, 'activePlan'=>$user->activePlan,'AdsRemaining'=>$user->AdsRemaining,'PlanExpireDate'=>$user->PlanExpireDate],200);
                }
                break;
            case 3:
                if($user->wallet >= 75000){
                    $user->wallet -= 75000;
                    $user->AdsRemaining = 30;
                    $user->PlanExpireDate = Carbon::now()->addDays(90);
                    $user->activePlan = 'deluxe';
                    $user->save();
                    return response(['message'=>'Successfully bought','Balance'=>$user->wallet, 'activePlan'=>$user->activePlan,'AdsRemaining'=>$user->AdsRemaining,'PlanExpireDate'=>$user->PlanExpireDate],200);
                }
                break;
            case 4:
                if($user->wallet >= 100000){
                    $user->wallet -= 100000;
                    $user->AdsRemaining = 45;
                    $user->PlanExpireDate = Carbon::now()->addDays(120);
                    $user->activePlan = 'max';
                    $user->save();
                    return response(['message'=>'Successfully bought','Balance'=>$user->wallet, 'activePlan'=>$user->activePlan,'AdsRemaining'=>$user->AdsRemaining,'PlanExpireDate'=>$user->PlanExpireDate],200);
                }
                break;
            default:
                return response(['message'=>'request for valid plan','Balance'=>$user->wallet], 400);
        }
        return response(['message'=>'operation failed','Balance'=>$user->wallet], 400);
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
