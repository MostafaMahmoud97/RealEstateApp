<?php

namespace App\Http\Controllers;

use App\Traits\FireBaseServiceTrait;
use Illuminate\Http\Request;

class NotificationTestController extends Controller
{
    use FireBaseServiceTrait;

    public function sendPushNotification(){


        return $this->pushNotification("ePpREZoKTeOM64vBoMzo_p:APA91bFyTtZH4FWEeuF74QS9hujY0ASh2HnadNNLy2X_iCeb2N9NQonT16UMmCwnx_BUD51TUfnumuS_LB2WewO-Ioxr0VniliRoDVTWSprpFWjuGyiai8rZ4qicXI_ZzFU4N8YVIAXk","welcome","hello user");
    }
}
