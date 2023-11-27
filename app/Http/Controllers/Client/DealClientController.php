<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\DealClientService;
use Illuminate\Http\Request;

class DealClientController extends Controller
{
    protected $service;
    public function __construct(DealClientService $service)
    {
        $this->service = $service;
    }

    public function DealStatusList(){
        return $this->service->DealStatusList();
    }

    public function index(Request $request){
        return $this->service->index($request);
    }
}
