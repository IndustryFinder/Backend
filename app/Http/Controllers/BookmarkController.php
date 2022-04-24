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
     * @return Response
     */
    public function index()
    {
        $id=auth('sanctum')->user()->id;
		$result = User::find($id)->BookMarks;
		foreach($result as $r){
			$r=$r->marked;
		}
        return response($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store($id)
    {
        $mark=new Bookmark();
        $mark->user_id=auth('sanctum')->user()->id;
        $mark->marked_id=$id;
        $mark->save();
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
        $result = Bookmark::find($id);
		$result?$result->delete():null;
        return response(['message' => $result?'success':'failed'], $result?200:404);
    }
}