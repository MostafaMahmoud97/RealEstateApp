<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DealService;
use Illuminate\Http\Request;

class DealController extends Controller
{
    protected $service;

    public function __construct(DealService $service)
    {
        $this->service = $service;
    }

    public function getContractStatus(){
        return $this->service->getContractStatus();
    }

    public function index(Request $request){
        return $this->service->index($request);
    }
}
