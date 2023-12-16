<?php

namespace App\Http\Controllers;

use App\Traits\FireBaseServiceTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TestNotification extends Controller
{
    use FireBaseServiceTrait;

    public function NotifyTest(){
        $Response = $this->PushNotificationPerformRequest("fPVnFA3OTIeghMhf3zWIbz:APA91bG0M31ypE9--U_l7D6Q4ikD9zFoXUnj4oXcAbOdJrVIP2cOxR5z7xoi5i_Pho3V9PsW2ASJUK6z-CU7TrhOZbOBTu0_pj1N1x8Lakf9wjMCdyR2uHu0gjuvwogZ1tULxZcC1Eg_","welcome","hello");
        return Response::successResponse($Response);
    }
}
