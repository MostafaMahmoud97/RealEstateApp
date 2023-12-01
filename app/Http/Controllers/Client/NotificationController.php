<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $service;

    public function __construct(NotificationService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return $this->service->index();
    }

    public function markSingleNotiAsRead(Request $request){
        return $this->service->markNotificationAsRead($request);
    }

    public function markAllNotiAsRead(){
        return $this->service->markAllNotificationAsRead();
    }

}
