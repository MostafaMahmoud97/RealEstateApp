<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CommercialActivity\CommercialActivityStoreRequest;
use App\Services\Admin\CommercialActivityService;
use Illuminate\Http\Request;

class CommercialActivitiesController extends Controller
{
    protected $service;
    public function __construct(CommercialActivityService $service)
    {
        $this->service = $service;
    }

    public function index($user_id){
        return $this->service->index($user_id);
    }

    public function store(CommercialActivityStoreRequest $request){
        return $this->service->store($request);
    }

    public function show($id){
        return $this->service->show($id);
    }

    public function update($id,Request $request){
        return $this->service->update($id, $request);
    }

    public function delete($id){
        return $this->service->delete($id);
    }
}
