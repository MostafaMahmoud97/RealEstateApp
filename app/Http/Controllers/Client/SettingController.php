<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $service;

    public function __construct(SettingService $service)
    {
        $this->service = $service;
    }

    public function get_all_help_data(){
        return $this->service->all_help_data();
    }
}
