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

    public function index(Request $request): View
    {
        $to_user = User::where('restaurant_id', $request->id)->first()->id;

        $messages = Message::where(function ($query) use ($to_user) {
            $query->where('from_user', Auth::user()->id)
                ->where('to_user', $to_user);
        })
            ->orWhere(function ($query) use ($to_user) {
                $query->where('from_user', $to_user)->where('to_user', Auth::user()->id);
            })->orderBy('created_at', 'ASC')->get();

        return view('home.restaurant.chat', compact('messages'));
    }

    public function getMessages(Request $request)
    {
        $from_user = $request->user_id;

        $to_user = auth()->id();

        $messages = Message::where(function ($query) use ($to_user,$from_user) {
            $query->where('from_user', $from_user)
                ->where('to_user', $to_user);
        })
            ->orWhere(function ($query) use ($to_user,$from_user) {
                $query->where('from_user', $to_user)->where('to_user',$from_user);
            })->orderBy('created_at', 'ASC')->get();

        $user = User::where('id', $from_user)->get()->first();

        $result = [];

        foreach ($messages as $message) {
            $result[] = $message;
        }

        return response()->json(['messages' => $result]);

    }

    public function respondToUserChat(Request $request): View
    {

        $to_user = $request->query('id');

        $messages = Message::where(function ($query) use ($to_user) {
            $query->where('from_user', Auth::user()->id)
                ->where('to_user', $to_user);
        })
            ->orWhere(function ($query) use ($to_user) {
                $query->where('from_user', $to_user)->where('to_user', Auth::user()->id);
            })->orderBy('created_at', 'ASC')->get();

        return view('dashboard.chat', compact('messages'));

    }

    public function respondToUser($id, Request $request)
    {
        $from_user = auth()->id();
        $to_user = $request->id;

        $message = Message::create([
            'from_user' => $from_user,
            'to_user' => $to_user,
            'message' => $request->message
        ]);

        event(new NewMessageNotification($message));

        return response()->json(['data' => $message, 'message' => 'Message Successfully sent.']);
    }

    public function fetchMessages(Request $request): \Illuminate\Http\JsonResponse
    {

        $from_user = User::where('restaurant_id', $request->data['from_user'])->first()->id;
        $to_user = \auth()->id();

        $messages = Message::where(function ($query) use ($to_user) {
            $query->where('to_user', $to_user);
        })->orderBy('created_at', 'ASC')->get();

        $user = User::where('id', $from_user)->get()->first();

        $result = [];

        foreach ($messages as $message) {
            $result[] = $message;
        }

        return response()->json(['state' => 1, 'messages' => $result, 'user' => $user]);

    }

    public function fetchOldMessages(Request $request): \Illuminate\Http\JsonResponse
    {
        $to_user = auth()->id();

        $messages = Message::where(function ($query) use ($to_user) {
            $query->where('to_user', $to_user);
        })->orderBy('created_at', 'ASC')->get();

        $result = [];

        foreach ($messages as $message) {
            $result['message'] = $message;
            $result['user'] = User::where('id', $message->from_user)->get()->first();
        }

        return response()->json(['state' => 1, 'messages' => $result['message'], 'user' => $result['user']]);

    }

    public function sendMessage($id, Request $request)
    {
        $from_user = auth()->id();

        $to_user = User::where('restaurant_id', $id)->whereHas('roles', function ($query) {
            $query->where('name', "Admin");
        })->first()->id;

        $message = Message::create([
            'from_user' => $from_user,
            'to_user' => $to_user,
            'message' => $request->message
        ]);

//        event(new NewMessageNotification($message));
        NewMessageNotification::dispatch($message);

        return response()->json(['data' => $message, 'message' => 'Message Successfully sent.']);
    }


}
