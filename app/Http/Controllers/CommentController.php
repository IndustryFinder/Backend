<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Company;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function make(Request $request) {
        $validated = $request->validated();
        $result = Comment::create($validated);
        return response($result, $result ? 201 : 100);
    }


    public function delete(Comment $comment) {
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

    public  function update(Comment $comment){
        $validated = $comment->validate();
        $result = Comment::update($validated);
        return response($result, $result ? 201 : 100);
    }

    public  function response(Comment $comment, string $response){
        $comment->response .="/n".$response;
        $result = Comment::update($comment);
        return response($result, $result ? 201 : 100);
    }


}
