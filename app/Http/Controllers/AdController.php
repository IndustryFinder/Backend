<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ad\AcceptRequest;
use App\Http\Requests\Ad\IndexRequest;
use App\Http\Requests\Ad\MakeAdRequest;
use App\Http\Requests\Ad\UpdateRequest;
use App\Models\Ad;
use Intervention\Image\Facades\Image;

class AdController extends Controller
{
	public function index(IndexRequest $request){
		$validated=$request->validated();
		if (isset($validated['isCompany'])){
				$ads=Ad::where('isCompany',$validated['isCompany']);
		}
		if (isset($validated['text'])){
			if (isset($ads))
				$ads=$ads->where('title',"like",'%'.$validated['text'].'%');
			else
				$ads=Ad::where('title','like','%'.$validated['text'].'%');
		}
        if (isset($validated['category'])){
            if (isset($ads))
                $ads=$ads->where('category_id',$validated['category']);
            else
                $ads=Ad::where('category_id',$validated['category']);
        }
		if (isset($ads)){
            $ads=$ads->with('Sender')->get();
		}
        else{
            $ads=Ad::all()->with('Sender')->get();
        }
        return response($ads);
	}

    public function IndexByReceiver(){

        $user= auth()->user()->id;
        $ads=Ad::where('receiver',$user)->get();
        return response()->json($ads);
    }

    public function IndexBySender(){

        $user= auth()->user()->id;
            $ads=Ad::where('sender',$user)->get();
            return response()->json($ads);
    }

    public function show(Ad $ad){

            $ad->ViewCount++;
            $ad->save();
            $ad->sender=$ad->Sender;
            $ad->sender['company']=$ad->sender->Company;
            return response()->json($ad);
    }


    public function makeAd(MakeAdRequest $request) {
        $validated = $request->validated();
        $validated['sender']=auth('sanctum')->user()->id;
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename=uniqid() . '.' . $image->getClientOriginalExtension();
            $location=public_path('storage/AdPhoto'.$filename);
            Image::make($image)->resize(300,300)->save($location);
            $validated['photo']=$filename;
        }
        $ad = Ad::create($validated);
        return response($ad, $ad ? 201 : 500);
    }

    public function update(UpdateRequest $request,Ad $ad) {
        $validated = $request->validated();
        if ($ad==null){
            return response()->json(['error'=>'Ad not found'],404);
        }
        if(!($ad['sender']==auth('sanctum')->user()->id)){
            return response()->json(['error'=>'Unauthorized'],401);
        }
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename=uniqid() . '.' . $image->getClientOriginalExtension();
            $location=public_path('storage/AdPhoto'.$filename);
            Image::make($image)->resize(300,300)->save($location);
            $validated['photo']=$filename;
        }
        $validated['sender']=auth('sanctum')->user()->id;
        $ad=$ad->update($validated);
        return response($ad, $ad ? 201 : 500);
    }

    public function Accept(AcceptRequest $request) {
        $validated = $request->validated();
        $ad = Ad::find($validated['ad_id']);
        $ad->receiver = $validated['user_id'];
        $ad->save();
        return response($ad, 201);
    }


	public function destroy(Ad $ad){

		if ($ad==null){
			return response()->json(['error'=>'Ad not found'],404);
		}
		if ($ad->sender!=auth('sanctum')->user()->id){
			return response()->json(['error'=>'Unauthorized'],401);
		}
		$ad->update(['is_active'=>0]);
		return response()->json(['success'=>'Ad deleted'],200);
	}
}
