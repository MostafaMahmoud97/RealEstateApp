<?php

namespace App\Http\Controllers;

use App\Traits\FireBaseServiceTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TestNotification extends Controller
{
    use FireBaseServiceTrait;

    public function NotifyTest(){
        $Response = $this->PushNotificationPerformRequest("ft_-cgATQPCkx-j7TCyRnC:APA91bGe9zmalNlf3v9xPxzOknm87Ev8IwZOyGSJpx55kQTiRsklZd284viGiksifvgF5A1d-gxAsU0EeE_Bdt-O776yRGHJh0aZzKRHhmD0QvHBcLqbthpxDPdqQi9zVQDa-2kRfhhx","welcome","hello");
        return Response::successResponse($Response);
    }
}
