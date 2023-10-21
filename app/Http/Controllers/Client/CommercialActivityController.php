<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CommercailAcivity\StoreRequest;
use App\Services\Client\CommercialActivityService;
use Illuminate\Http\Request;

class CommercialActivityController extends Controller
{
    protected $service;
    public function __construct(CommercialActivityService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return $this->service->index();
    }

    public function store(StoreRequest $request){
        return $this->service->store($request);
    }

    public function show($id){
        return $this->service->show($id);
    }

    public function update($id,StoreRequest $request){
        return $this->service->update($id,$request);
    }

    public function delete($id){
        return $this->service->delete($id);
    }
}
