<?php


namespace App\Services\Client;


use App\Http\Resources\Client\Chat\IndexResource;
use App\Models\ChatUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ChatService
{
    public function startChat($request){
        $user_id = Auth::id();
        $ChatUser_one = ChatUser::where(["user_one_id"=>$user_id,"user_two_id"=>$request->user_id])->first();
        $ChatUser_two = ChatUser::where(["user_one_id"=>$request->user_id,"user_two_id"=>$user_id])->first();


        if ($ChatUser_one || $ChatUser_two){
            return Response::successResponse([],__("chat.client save success"));
        }

        $user = Auth::user();
        $user->ChatUser()->syncWithoutDetaching([$request->user_id]);
        return Response::successResponse([],__("chat.client save success"));
    }

    public function getMyChats(){
        $user = Auth::user();
        $Chats = $user->ChatUser;
        $ChatsTwo = $user->ChatUserTwo;

        $data = [];

        foreach ($Chats as $chat){
            array_push($data,$chat);
        }

        foreach ($ChatsTwo as $chat){
            array_push($data,$chat);
        }

        return Response::successResponse(IndexResource::collection($data),__("chat.chats have been fetched success"));

    }
}
