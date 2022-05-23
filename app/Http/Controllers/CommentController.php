<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Company;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function make(Request $request) {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'rating' => 'required|min:0|max:5',
            'comment' => 'max:250'
        ]);
        $validated['user_id'] = auth('sanctum')->user()->id;
        $result = Comment::create($validated);
        return response($result, $result ? 201 : 100);
    }

    public function delete($id) {
        $comment = Comment::find($id);
        if ($comment == null){
            return response()->json(['error'=>'comment not found'],404);
        }
        if ($comment->User->id != auth('sanctum')->user()->id)
            return response()->json(['error'=>'Unauthorized'],401);
        $result = $comment->delete();
        return response(['message' => $result ? 'success' : 'failed', $result ? 200 : 404]);
    }

    public function getByCompany($id) {
        $comments = Comment::where('company_id', '=', $id);
        return response($comments->get(), 200);
    }

    public function getByUser($id) {
        $comments = Comment::where('user_id', '=', $id);
        return response($comments->get(), 200);
    }

    public function avgRating($id) {
        $comments = Comment::all()->where('company_id', '=', $id);
        $res = 0;
        foreach ($comments as $comment) {
            $res += $comment->rating;
        }
        return response(['avg' => $res / $comments->count()]);
    }
}
