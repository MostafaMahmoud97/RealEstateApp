<?php


namespace App\Services\Client;


use App\Http\Resources\Client\Notification\IndexResource;
use Illuminate\Support\Facades\Response;

class NotificationService
{
    public function index(){
        $notifications = auth()->user()->unreadNotifications;
        return Response::successResponse(IndexResource::collection($notifications),"success");
    }

    public function markNotificationAsRead($request){
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return Response::successResponse([],"success");
    }

    public function markAllNotificationAsRead(){
        auth()->user()->unreadNotifications->markAsRead();

        return Response::successResponse([],"success");
    }
}
