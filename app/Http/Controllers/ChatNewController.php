<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Chat;
use App\Events\NewChatPosted;
use Redis;
use Illuminate\Broadcasting\InteractsWithSockets;


class ChatNewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function sendChat(Request $request)
    {
    	$this->validate($request, array(
        	'body' => 'required|string|max:1000'
        ));

        $sender = Auth::id();
        $chat = new Chat;
        $chat->sender_id = $sender;
        $chat->receiver_id = $request->receiver;
        $chat->message = $request->body;
        $chat->save();

        $rooms = [$chat->sender_id, $chat->receiver_id];
        $smallest = min($rooms);
        $highest = max($rooms);
        $room = $smallest.'-'.$highest;
        //dd($room);
        broadcast(new NewChatPosted($chat, $room))->toOthers();

        return response()->json($chat, 200);
    }
}
