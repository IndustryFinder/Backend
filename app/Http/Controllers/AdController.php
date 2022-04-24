<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    /**
     * @OA\Post    (
     *     path="/Ad/makeAd",
     *     tags={"Ad"},
     *     operationId="1",
     *     summary="create new advertisement",
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
    public function makeAd(Request $request) {
        $validated = $request->validate([
            'title' => 'required|min:5|max:50',
            'category_id' => 'required|exists:categories,id',
            'min_budget' => 'required|min:0',
            'max_budget' => 'required',
            'sender' => 'required|exists:Users,id',
            'isCompany' => 'required',
            'description' => 'required|min:10'
        ]);

        $ad = Ad::create($validated);
        return response($ad, $ad ? 201 : 500);
    }
    /**
     * @OA\Put     (
     *     path="/Ad/Accept",
     *     tags={"Ad"},
     *     operationId="2",
     *     summary="Accepting advertisement",
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
            'ad_id' => 'required|exists:ads,id',
            'user_id' => 'required|exists:users,id'
        ]);
        $ad = Ad::find($request['ad_id']);
        $ad->receiver = $request['user_id'];
        $ad->save();
        return response($ad, 201);
    }
}
