<?php

namespace App\Http\Controllers;


use App\Models\Ad;
use App\Models\User;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Request as RequestModel;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

class RequestController extends Controller
{

     public function makeRequest(Request $request) {
        $validated = $request->validate([
            'ad_id' => 'required|exists:ads,id',
            'company_id' => 'required|exists:companies,id',
	        'message' => 'required|string',
        ]);
		$user=User::find(auth('sanctum')->user()->id);
		if ($validated['company_id'] == $user->Company->id) {
			$instance=RequestModel::create($validated);
			return response($instance, $instance ? 201 : 500);
		}
		return response(['message' => 'unauthorized'], 401);

    }

    public function Accept($id) {
		$instance=RequestModel::find($id);
		if ($instance) {
			$otherReqs=RequestModel::all()->where('ad_id',$instance->id);
			foreach ($otherReqs as $req) {
				$req->update(['status'=>'rejected']);
			}
			$instance->update(['status'=>'accepted']);
			return response($instance,201);
		}
		return response(['message'=>'not found'],404);
    }

    public function Reject($id) {
		$instance=RequestModel::find($id);
        if ($instance) {
	        $instance->status='rejected';
	        $instance->save();
	        return response($instance,201);
        }
		return response(['message'=>'not found'],404);
    }

	public function Destroy($id) {
		$req = RequestModel::find($id);
		if ($req) {
			if ($req->company->User->id == auth('sanctum')->user()->id) {
				$req->delete();
				return response($req,201);
			}
			return response('unauthorized',401);
		}
		return response('not found',404);
	}

    public function RequestsByAd($id){
        $result = Ad::find($id)->Requests;
        foreach ($result as $res){
            $res['company'] = Company::find($res->company_id);
        }
        return response($result, 200);
    }

    public  function RequestsByUser($id){
         $result= User::find($id)->Ad;
         foreach ($result as $r){
             $r['requests']=$r->Requests;
         }
         foreach ($result as $r){
             foreach ($r['requests'] as $req){
                 $req['company'] = Company::find($req->company_id);
             }
         }
         return response($result,200);
    }    
}
