<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bookmark\StoreRequest;
use App\Models\Bookmark;
use App\Models\Company;
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

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
		$b=Bookmark::where('user_id',auth('sanctum')->user()->id)->where('marked_id',$validated['marked_id'])->get();
        if ($b->count()==0 ) {
	        $mark =new Bookmark();
	        $mark->user_id =auth('sanctum')->user()->id;
	        $mark->marked_id=$validated['marked_id'];
	        $mark->save();
            return response(['message' => 'success'], 201);
        }
        return response(['message' => 'already exist'], 201);
    }

    //delete bookmark with company id
    public function destroy($id)
    {
        $result = Bookmark::where('marked_id',$id)->get();
        if ($result->count() == 0)
            return response(['message' => 'There is no bookmarks to delete!'], 200);

        $user_id = auth('sanctum')->user()->id;
        $counter = 0;
        foreach ($result as $r){
            if($r->user->id == $user_id){
                $r->delete();
                $counter++;
            }
        }
        if($counter > 0)
            return response(['message' => 'success'], 200);
        return response(['message' => 'unauthorised'], 401);
	}

    public static function IsMarked(Company $company) {
        return Bookmark::all()->where('user_id', '=', auth('sanctum')->user()->id)
        ->where('marked_id', '=', $company['id'])->count() > 0;
    }
}
