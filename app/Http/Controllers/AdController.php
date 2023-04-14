<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class AdController extends Controller
{
	public function index(Request $request){
		$validated=$request->validate();
		if (isset($validated['isCompany'])){
			if (isset($ads))
				$ads=$ads->where('isCompany',$validated['isCompany']);
			else
				$ads=Ad::where('isCompany',$validated['isCompany']);
		}
		if (isset($validated['sender'])){
			if (isset($ads))
				$ads=$ads->where('sender',$validated['sender']);
			else
				$ads=Ad::where('sender',$validated['sender']);
		}
		if (isset($validated['text'])){
			if (isset($ads))
				$ads=$ads->where('title',"like",'%'.$validated['text'].'%');
			else
				$ads=Ad::where('title','like','%'.$validated['text'].'%');
		}
		if (isset($ads))
			$ads=$ads->where('is_active',true)->paginate(24);
		else
			$ads=Ad::where('is_active',true)->paginate(24);

		if ($ads!=null){
			foreach ($ads as $ad){
				$ad->sender=$ad->Sender;
				$ad->sender['company']=$ad->sender->Company;
			}
			return response($ads);
		}
		return response()->json(['error'=>'Ad not found'],404);
	}

    public function a(Request $request){
        $validated=$request->validate();
        if (isset($validated['receiver'])){
            $ads=Ad::where('receiver',$validated['receiver'])->get();
            if ($ads==null){
                return response()->json(['error'=>'Ad not found'],404);
            }
            $ads = Ad::with('company')->get();

            return response()->json($ads);
        }
    }

    public function addview(Ad $ad){
            if ($ad==null){
                return response()->json(['error'=>'Ad not found'],404);
            }
            $ad->ViewCount++;
            $ad->save();
            $ad->sender=$ad->Sender;
            $ad->sender['company']=$ad->sender->Company;
            return response()->json($ad);
    }

    public function findbycategory(string $category){
      $val=Category::whereName($category);
      $ads=Ad::where('category_id',$val['id'])->array();
        return response()->json($ads);
    }

    public function makeAd(Request $request) {
        $validated = $request->validate([
            'title' => 'required|min:5|max:50',
            'category_id' => 'required|exists:categories,id',
            'min_budget' => 'min:0',
            'max_budget' => 'number|min:1',
            'isCompany' => 'required',
            'description' => 'required|min:10',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
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
