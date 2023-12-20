<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $service;

    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    public function getContract(Request $request){
        return $this->service->getContracts($request);
    }

    public function getUsers(){
        return $this->service->getUsers();
    }

    public function getDeals(Request $request){
        return $this->service->getDeals($request);
    }

    public function getUnits(Request $request){
        return $this->service->getUnits($request);
    }
}
