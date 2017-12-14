<?php

namespace App\Http\Controllers;

use App\Repositories\MessageRepository;
use Auth;

class MessageController extends Controller
{
    protected $message;

    public function __construct(MessageRepository $message)
    {
        $this->message = $message;
    }

    public function store()
    {

        $message = $this->message->store([
                'from_user_id' => user('api')->id,
                'to_user_id' => request('user'),
                'body' => request('body'),
                'dialog_id' => time().Auth::id()
        ]);

        if($message){
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }
}
