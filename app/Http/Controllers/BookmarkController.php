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
    public function destroy($id)
    {
        $result = Bookmark::find($id)->delete();
        return response(['message' => $result?'success':'failed', $result?200:404]);
    }
}