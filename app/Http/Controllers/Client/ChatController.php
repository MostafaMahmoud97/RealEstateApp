<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    protected $service;
    public function __construct(ChatService $service)
    {
        $this->service = $service;
    }

    public function startChat(Request $request){
        $Validator = Validator::make($request->all(),[
            "user_id" => "required|exists:users,id"
        ],[
            "user_id.required" => __("chat.you must enter user id"),
            "user_id.exists" => __("chat.no user by this id"),
        ]);

        if ($Validator->fails()){
            return Response::errorResponse($Validator->errors());
        }

        return $this->service->startChat($request);
    }

    public function getMyChat(){
        return $this->service->getMyChats();
    }
}
