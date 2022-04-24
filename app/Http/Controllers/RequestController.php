<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestController extends Controller
{
    function makeRequest(Request $request) {
        $validated = $request->validate([
            'ad_id' => 'required|exists:ads,id',
            'company_id' => 'required|exists:companies,id'
        ]);
        $instance = \App\Models\Request::create($validated);
        return response($instance, $instance ? 201 : 500);
    }

    function Accept(Request $request) {
        $validated = $request->validate([
            'id' => 'required|exists:requests,id'
        ]);

        $req = \App\Models\Request::find($request['id']);
        $otherReqs = \App\Models\Request::all()->where('ad_id', '=', $req->ad_id);
        foreach ($otherReqs as $x) {
            $x->status = 'rejected';
            $x->save();
        }
        $req->status = 'accepted';
        $req->save();
        return response($req, 201);
    }

    function Reject(Request $request) {
        $validated = $request->validate([
            'id' => 'required|exists:requests,id'
        ]);

        $req = \App\Models\Request::find($request['id']);
        $req->status = 'rejected';
        $req->save();
        return response($req, 201);
    }
}
