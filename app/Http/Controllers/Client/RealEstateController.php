<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\RealEstate\DisoverRequest;
use App\Http\Requests\Client\RealEstate\HomeRequest;
use App\Http\Requests\Client\RealEstate\StoreRequest;
use App\Http\Requests\Client\RealEstate\UpdateRequest;
use App\Services\Client\RealEstateService;
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

    public function store(StoreRequest $request){
        //validate media
        if ($request->units){
            foreach ($request->units as $unit){
                if ($unit['media']){
                    foreach ($unit['media'] as $media){
                        $check = $this->getValidateFile($media);
                        if (!$check){
                            return Response::errorResponse(__("real_estate_client.You must add image or video in media"));
                        }
                    }
                }
            }
        }

        return $this->service->store($request);
    }

    public function listAllMyProperties(Request $request){
        $Validator = Validator::make($request->all(),[
            "selected" => "required|numeric|in:1,2,3",
        ],[
            "selected.required" => __("real_estate_client.you must choose selected param"),
            "selected.numeric" => __("real_estate_client.you must choose selected param as number"),
            "selected.in" => __("real_estate_client.you must choose selected param from 1 to 3"),
        ]);

        if ($Validator->fails()){
            return Request::errorResponse($Validator->errors());
        }

        return $this->service->listAllMyProperties($request);
    }

    public function showMyProperty($unit_id){
        return $this->service->showMyProperty($unit_id);
    }

    public function editRealEstate($unit_id){
        return $this->service->editRealEstate($unit_id);
    }

    public function updateRealEstate($real_estate_id,UpdateRequest $request){
        //validate media
        if ($request->new_units){
            foreach ($request->new_units as $unit){
                if ($unit['media']){
                    foreach ($unit['media'] as $media){
                        $check = $this->getValidateFile($media);
                        if (!$check){
                            return Response::errorResponse(__("real_estate_client.You must add image or video in media"));
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
            "cover.required" => __("real_estate_client.you must choose cover image"),
            "cover.mimes" => __("real_estate_client.you must choose cover image as jpg,png,jpeg"),
        ]);

        if ($Validator->fails()){
            return Response::errorResponse($Validator->errors()->first());
        }

        return $this->service->updateCoverRealEstate($request);
    }

    public function updateMediaUnit(Request $request){
        $Validator = Validator::make($request->all(),[
            "media" => "required|array|min:1",
            "media.*" => "max:2048",
        ],[
            "media.required" => __("real_estate_client.you must choose unit media"),
            "media.array" => __("real_estate_client.you must choose unit media as array"),
        ]);

        if ($Validator->fails()){
            return Response::errorResponse($Validator->errors()->first());
        }

        //validate media
        foreach ($request->media as $media){
            $check = $this->getValidateFile($media);
            if (!$check){
                return Response::errorResponse(__("real_estate_client.You must add image or video in media"));
            }
        }

        return $this->service->updateMediaUnit($request);
    }

    public function DiscoverUnit(DisoverRequest $request){
        return $this->service->DiscoverUnit($request);
    }

    public function HomeUnit(HomeRequest $request){
        return $this->service->HomeUnit($request);
    }

    public function showUnit($unit_id){
        return $this->service->showUnit($unit_id);
    }
}
