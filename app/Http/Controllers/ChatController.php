<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Chat;
use App\Events\ChatPosted;
use LRedis;

class ChatController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function getUser($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user, 200);
    }

    public function postMsg(Request $request, $id)
    {
        $this->validate($request, array(
        	'body' => 'required|string|max:1000'
        ));

        $sender = Auth::id();
        $chat = new Chat;
        $chat->sender_id = 2;
        $chat->receiver_id = $request->receiver;
        $chat->message = $request->body;
        $chat->save();

        $redis = LRedis::connection();

        $redis->publish('message', $chat);
        //event(new ChatPosted($chat));

        return response()->json($chat, 200);
    }

    public function fetchChat(Request $request, $id)
    {	
    	$me = Auth::id();

    	$chats = Chat::where(['sender_id' => $me, 'receiver_id' => $id])
                        ->orwhere(function($q) use($me, $id){
                            $q->where(['sender_id' => $id, 'receiver_id' => $me]);
                        })
                        ->orderBy('created_at', 'ASC')
                        // ->groupBy('Messages')
                        ->get();

    	return response()->json($chats, 200);
    }
}
