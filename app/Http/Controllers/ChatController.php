<?php

namespace App\Http\Controllers;

use App\User;
use App\Events\ChatMessage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     * Based on a tutorial @ https://www.cloudways.com/blog/realtime-chatroom-with-laravel-vuejs-pusher/
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sendMessage(Request $request)
    {
        $message = [
            "id" => $request->userid,
            "sourceuserid" => Auth::user()->id,
            "name" => Auth::user()->alias,
            "message" => $request->message];

        event(new ChatMessage($message));
        return "true";
    }

    public function index()
    {
        //TODO : Seulement les amis ?
        $users = User::take(10)->get();
        return view('chat', compact('users'));
    }
}
