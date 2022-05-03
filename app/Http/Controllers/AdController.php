<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
	public function index(Request $request){
		$validated=$request->validate([
			'id'=>'integer',
			'category'=>'integer',
			'isCompany'=>'boolean',
			'sender'=>'integer',
			'receiver'=>'integer',
			'text'=>'string',
		]);
		if (isset($validated['id'])){
			$ad=Ad::find($validated['id']);
			if ($ad==null){
				return response()->json(['error'=>'Ad not found'],404);
			}
			return response()->json($ad);
		}
		$ads=Ad::all();
		if (isset($validated['category'])){
			$ads=$ads->where('category',$validated['category'])->get();
		}
		if (isset($validated['isCompany'])){
			if ($validated['isCompany']){
				$ads=$ads->where('isCompany',true)->get();
			}
		}
		if (isset($validated['sender'])){
			$ads=$ads->where('sender',$validated['sender']);
		}
		if (isset($validated['receiver'])){
			$ads=$ads->where('receiver',$validated['receiver']);
		}
		if (isset($validated['text'])){
			$ads=$ads->where('title','like','%'.$validated['text'].'%')
				->orWhere('description','like','%'.$validated['text'].'%');
		}
		$ads=$ads->where('is_active',true)->get();
		return response()->json($ads);
	}

    public function makeAd(Request $request) {
        $validated = $request->validate([
            'title' => 'required|min:5|max:50',
            'category_id' => 'required|exists:categories,id',
            'min_budget' => 'min:0',
            'max_budget' => 'number|min:1',
            'isCompany' => 'required',
            'description' => 'required|min:10'
        ]);
	    $validated['sender']=auth('sanctum')->user()->id;
        $ad = Ad::create($validated);
        return response($ad, $ad ? 201 : 500);
    }

    public function Accept(Request $request) {
        $validated = $request->validate([
            'ad_id' => 'required|exists:ads,id',
            'user_id' => 'required|exists:users,id'
        ]);
        $ad = Ad::find($request['ad_id']);
        $ad->receiver = $request['user_id'];
        $ad->save();
        return response($ad, 201);
    }

	public function destroy($id){
		$ad=Ad::find($id);
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
