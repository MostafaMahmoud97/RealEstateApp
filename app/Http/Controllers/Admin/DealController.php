<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Deals\UploadContractRequest;
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

    public function showDeal($deal_id){
        return $this->service->showDeal($deal_id);
    }

    public function uploadContract(UploadContractRequest $request){
        return $this->service->uploadContract($request);
    }
}
