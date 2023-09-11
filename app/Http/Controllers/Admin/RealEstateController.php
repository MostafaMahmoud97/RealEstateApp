<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RealEstate\RealEstateStoreRequest;
use App\Http\Requests\Admin\RealEstate\RealEstateUpdateRequest;
use App\Models\Media;
use App\Models\Unit;
use App\Services\Admin\RealEstateService;
use App\Traits\GeneralFileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RealEstateController extends Controller
{
    use GeneralFileService;
    protected $service;
    public function __construct(RealEstateService $service)
    {
        $this->service = $service;
    }

    public function getHelpData(){
        return $this->service->getHelpData();
    }

    public function store(RealEstateStoreRequest $request){

        //validate media
        if ($request->units){
            foreach ($request->units as $unit){
                if ($unit['media']){
                    foreach ($unit['media'] as $media){
                        $check = $this->getValidateFile($media);
                        if (!$check){
                            return Response::errorResponse(__("real_estate.You must add image or video in media"));
                        }
                    }
                }
            }
        }

        return $this->service->store($request);
    }

    public function listAllProperties($user_id){
        return $this->service->listAllProperties($user_id);
    }

    public function showProperty(Request $request){
        return $this->service->showProperty($request);
    }

    public function listAllUnits(Request $request){
        return $this->service->listAllUnits($request);
    }

    public function showUnit($unit_id){
        return $this->service->showUnit($unit_id);
    }

    public function editRealEstate($unit_id){
        return $this->service->editRealEstate($unit_id);
    }

    public function updateRealEstate($real_estate_id,RealEstateUpdateRequest $request){
        return $this->service->updateRealEstate($real_estate_id,$request);
    }

    public function deleteRealEstate($real_estate_id){
        return $this->service->deleteRealEstate($real_estate_id);
    }

    public function deleteUnit($unit_id){
        return $this->service->deleteUnit($unit_id);
    }
}
