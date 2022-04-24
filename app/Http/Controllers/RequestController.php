<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestController extends Controller
{
    /**
     * @OA\Post(
     *     path="/Request/Add",
     *     tags={"Request"},
     *     operationId="11",
     *     summary="create a new request",
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
     public function makeRequest(Request $request) {
        $validated = $request->validate([
            'ad_id' => 'required|exists:ads,id',
            'company_id' => 'required|exists:companies,id'
        ]);
        $instance = \App\Models\Request::create($validated);
        return response($instance, $instance ? 201 : 500);
    }
    /**
     * @OA\Put (
     *     path="/Request/Accept",
     *     tags={"Request"},
     *     operationId="12",
     *     summary="Accept the fucking request and Reject other fucking requests",
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
    public function Accept(Request $request) {
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
    /**
     * @OA\Put (
     *     path="/Request/Reject",
     *     tags={"Request"},
     *     operationId="13",
     *     summary="Reject the fucking request",
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
    public function Reject(Request $request) {
        $validated = $request->validate([
            'id' => 'required|exists:requests,id'
        ]);

        $req = \App\Models\Request::find($request['id']);
        $req->status = 'rejected';
        $req->save();
        return response($req, 201);
    }

}
