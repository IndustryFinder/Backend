<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookmarkController extends Controller
{

    public function index()
    {
        $id=auth('sanctum')->user()->id;
		$result = User::find($id)->BookMarks;
		foreach($result as $r){
			$r=$r->marked;
		}
        return response($result, 200);
    }

    public function store($id)
    {
		$b=Bookmark::where('user_id',auth('sanctum')->user()->id)->where('marked_id',$id);
        $c=Bookmark::where('marked_id',$id);
        if ($b->count()==0 and $c->count()!=0) {
	        $mark           =new Bookmark();
	        $mark->user_id  =auth('sanctum')->user()->id;
	        $mark->marked_id=$id;
	        $mark->save();
            return response(['message' => 'success'], 201);
        }
        elseif ($b->count()==0 and $c->count()==0){
            return response(404);
        }
        return response(['message' => 'already exist'], 201);
    }

    public function destroy($id)
    {
        $result = Bookmark::find($id);
		if ($result->user->id == auth('sanctum')->user()->id) {
			$result->delete();
			return response(['message' => 'success'], 200);
		}
		return response(['message' => 'unauthorised'], 401);
	}

    //check if is necessary
    public static function IsMarked($id) {
        return Bookmark::all()->where('user_id', '=', auth('sanctum')->user()->id)
        ->where('marked_id', '=', $id)->count() > 0;
    }
}
