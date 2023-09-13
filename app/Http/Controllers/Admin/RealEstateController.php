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
use Illuminate\Support\Facades\Validator;

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

    public function listAllStatus(){
        return $this->service->listAllStatus();
    }

    public function listAllProperties($user_id,Request $request){
        return $this->service->listAllProperties($user_id,$request);
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
        //validate media
        if ($request->new_units){
            foreach ($request->new_units as $unit){
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

        return $this->service->updateRealEstate($real_estate_id,$request);
    }

    public function deleteRealEstate($real_estate_id){
        return $this->service->deleteRealEstate($real_estate_id);
    }

    public function deleteUnit($unit_id){
        return $this->service->deleteUnit($unit_id);
    }

    public function updateCoverRealEstate(Request $request){
        $Validator = Validator::make($request->all(),[
            "cover" => "required|mimes:jpg,png,jpeg|max:2048",
        ],[
            "cover.required" => __("real_estate.you must choose cover image"),
            "cover.mimes" => __("real_estate.you must choose cover image as jpg,png,jpeg"),
        ]);

        if ($Validator->fails()){
            return Response::errorResponse($Validator->errors()->first());
        }


        return $this->service->updateCoverRealEstate($request);
    }

    public function updateMediaUnit(Request $request){
        return $this->service->updateMediaUnit($request);
    }
}
