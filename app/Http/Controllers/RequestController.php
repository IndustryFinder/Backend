<?php

namespace App\Http\Controllers;


use App\Http\Requests\Request\AddRequest;
use App\Models\Ad;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Request as RequestModel;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

class RequestController extends Controller
{
     public function makeRequest(AddRequest $request) {
        $validated = $request->validated();
        $instance=RequestModel::create($validated);
        return response($instance, $instance ? 201 : 500);
    }

    public function Accept(RequestModel $request) {
        if ($request->ad->Sender->id == auth('sanctum')->user()->id) {
            RequestModel::query()->where('ad_id',$request->ad->id)->update(['status'=>'rejected']);
            $request->update(['status'=>'accepted']);
            return response($request,201);
        }
        return response(['message' => 'unauthorized'], 401);
    }

    public function Reject(RequestModel $request) {
        if ($request->ad->Sender->id == auth('sanctum')->user()->id) {
            $request->status = 'rejected';
            $request->save();
            return response($request, 201);
        }
        return response(['message' => 'unauthorized'], 401);
    }

	public function Destroy(RequestModel $request) {
        if ($request->company->User->id == auth('sanctum')->user()->id) {
            $request->delete();
            return response($request,201);
        }
        return response(['message' => 'unauthorized'], 401);
	}

    public function RequestsByAd(Ad $ad){
        $result = $ad->Requests;
        foreach ($result as $res){
            $res['company'] = Company::find($res->company_id);
        }
        return response($result, 200);
    }

    public function RequestsByCompany($id){
        $requests = RequestModel::with('ad')
            ->where('company_id', $id)
            ->get();

        return response($requests, 200);
    }

    public  function RequestsByUser(User $user){
         $result= $user->Ad;
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
