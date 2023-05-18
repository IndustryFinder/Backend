<?php

namespace App\Http\Controllers;

use App\Models\chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function ChatList(){
        $sender=auth('sanctum')->user()->id;
        $result=chat::where('sender',$sender)->with('receiver')->get();
        return response()->json($result);
    }

    public function ChatIndex($request){//request is receiver
        $validated=$request->validated();
        $sender=auth('sanctum')->user()->id;
        $result=chat::where('sender',$sender)->where('receiver',$validated['receiver'])->sort()->get();
        //halat motefavet
        return response()->json($result);
    }

    public function NewMassage($request){ //massage and receiver
        $validated=$request->validated();
        $validated['sender']=auth('sanctum')->user()->id;
        $validated['status']='send';
        $chat = Chat::create($validated);
        return response($chat, $chat ? 201 : 500);
    }

    //find unseen

    //make seen

    //delete massage
}
