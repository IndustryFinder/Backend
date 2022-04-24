<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    /**
     * @OA\Get   (
     *     path="/user/bookmarks",
     *     tags={"Bookmark"},
     *     operationId="3",
     *     summary="Find Bookmark By id",
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
    public function index(Request $request)
    {
        $id=auth('sanctum')->user()->id;
        return User::find($id)->BookMarks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    /**
     * @OA\Post   (
     *     path="/user/bookmarks/add",
     *     tags={"Bookmark"},
     *     operationId="4",
     *     summary="Add new Bookmark",
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
    public function store(Request $request)
    {

//        $validated=$request->validate([
//            'company' => 'required|exists:companies,id'
//        ]);
//        die();
        $mark=new Bookmark();
        $mark->user_id=auth('sanctum')->user()->id;
        $mark->marked_id=$request['company'];
        $mark->save();
//        var_dump($mark);
//        die();
        return response(['message' => 'success'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    /**
     * @OA\Delete    (
     *     path="/user/bookmarks/del",
     *     tags={"Bookmark"},
     *     operationId="5",
     *     summary="Delete Bookmark",
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
    public function destroy($id)
    {
        $result = Bookmark::find($id)->delete();
        return response(['message' => $result?'success':'failed', $result?200:404]);
    }
}
