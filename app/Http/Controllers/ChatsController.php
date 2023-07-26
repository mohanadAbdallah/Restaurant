<?php

namespace App\Http\Controllers;

use App\Events\NewMessageNotification;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChatsController extends Controller
{

    public function index(): View
    {
        return view('home.restaurant.chat');
    }

    public function fetchMessages(Request $request)
    {
        $messages = Message::where(function($query) use ($request) {
            $query->where('from_user', Auth::user()->id);
        })
            ->orWhere(function ($query) use ($request) {
            $query->where('from_user', $request->user_id)->where('to_user', Auth::user()->id);
        })->orderBy('created_at', 'ASC')->limit(10)->get();

        $result = [];
        foreach ($messages as $message){
            $result[] =  $message;
        }

        return response()->json(['state' => 1, 'messages' => $result]);

    }

    public function sendMessage($id , Request $request): array
    {
        $from_user = Auth::user()->id;
        $to_user = User::where('restaurant_id',$id)->whereHas('roles',function ($query){
            $query->where('name','Admin');
        })->first()->id;

        $message = Message::create([
            'from_user'=>$from_user,
            'to_user'=>$to_user,
            'message' => $request->input('message')
        ]);

        event(new NewMessageNotification($message));

        return ['status' => 'Message Sent!'];
    }



}
