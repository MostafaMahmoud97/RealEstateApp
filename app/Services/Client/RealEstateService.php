<?php


namespace App\Services\Client;


use App\Http\Resources\Client\RealEstate\editRealEstateResource;
use App\Http\Resources\Client\RealEstate\ListAllMyPropertiesResource;
use App\Http\Resources\Client\RealEstate\ShowMyPropertyResource;
use App\Models\BuildingType;
use App\Models\BuildingTypeUse;
use App\Models\CommercialInfo;
use App\Models\Media;
use App\Models\PurposeProperty;
use App\Models\RealEstate;
use App\Models\Unit;
use App\Models\User;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RealEstateService
{
    use GeneralFileService;

    public function getHelpData(){
        $BuildingTypes = BuildingType::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();
        $BuildingTypeUses = BuildingTypeUse::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();
        $PurposeProperties = PurposeProperty::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();

        return Response::successResponse(["building_types" => $BuildingTypes,"building_type_uses" => $BuildingTypeUses,"purpose_properties" => $PurposeProperties],__("real_estate_client.Help data has been fetched success"));
    }

    public function store($request){
        $User = Auth::user();

        $request->merge(["user_id" => $User->id]);

        //store real estate
        $RealEstate = RealEstate::create($request->all());

        if ($request->cover_real_estate){
            $path = "RealEstateCover/";
            $file_name = $this->SaveFile($request->cover_real_estate,$path);
            $type = $this->getFileType($request->cover_real_estate);
            Media::create([
                'mediable_type' => $RealEstate->getMorphClass(),
                'mediable_id' => $RealEstate->id,
                'title' => "Real Estate",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        // add units
        $UnitsArray = [];
        if ($request->units){
            foreach ($request->units as $unit){
                $unit['real_estate_id'] = $RealEstate->id;

                $UnitX = Unit::create($unit);
                $unit['unit_id'] = $UnitX->id;
                array_push($UnitsArray,$unit);
                if ($unit['media']){
                    $path = "Unit_Media/";
                    foreach ($unit['media'] as $media){
                        $file_name = $this->SaveFile($media,$path);
                        $type = $this->getFileType($media);
                        Media::create([
                            'mediable_type' => $UnitX->getMorphClass(),
                            'mediable_id' => $UnitX->id,
                            'title' => "Unit",
                            'type' => $type,
                            'directory' => $path,
                            'filename' => $file_name
                        ]);
                    }
                }
            }
        }


        // add commercial data
        if($request->building_type_use_id == 1){
            if($request->units){
                foreach ($UnitsArray as $unit){
                    $commercialInfo = CommercialInfo::create($unit);
                }

            }
        }

        return Response::successResponse($RealEstate,__("real_estate_client.Real estate has been added success"));
    }

    public function listAllMyProperties(){
        $User_id = Auth::id();

        $Units = Unit::select('id','real_estate_id','unit_number','unit_area','unit_status_id','price')->with(["RealEstate" => function($q) use ($User_id){
            $q->with(["BuildingType" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            },"BuildingTypeUse" =>  function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            },"media"])->select('id','building_type_id','building_type_use_id','user_id','national_address');
        }])->whereHas("RealEstate",function ($q) use ($User_id){
            $q->where("user_id",$User_id);
        })->whereIn("unit_status_id",[1,2])->get();

        return Response::successResponse(ListAllMyPropertiesResource::collection($Units),__("real_estate_client.Properties have been fetched"));
    }

    public function showMyProperty($unit_id){
        $user_id = Auth::id();

        $Unit = Unit::with(["RealEstate" => function($q){
            $q->with(["Media","BuildingType" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            },"BuildingTypeUse" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            }]);
        },"CommercialInfo","PurposeProperty" => function($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        },"Media"])->whereHas("RealEstate",function ($q) use ($user_id){
            $q->where("user_id",$user_id);
        })->whereIn("unit_status_id",[1,2])->find($unit_id);

        if (!$Unit){
            return Response::errorResponse(__("real_estate_client.please select valid property"));
        }

        return Response::successResponse(ShowMyPropertyResource::make($Unit),__("real_estate_client.property has been fetched"));
    }

    public function editRealEstate($unit_id){
        $Unit = Unit::find($unit_id);
        if (!$Unit){
            return Response::errorResponse(__("real_estate_client.please select valid unit"));
        }
        $RealEstate_id = $Unit->RealEstate->id;
        $user_id = Auth::id();

        $RealEstate = RealEstate::with(["BuildingType" => function ($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        },"BuildingTypeUse" => function ($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        },"Units" => function ($q){
            $q->with(["PurposeProperty" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            },"CommercialInfo","media"]);
        },"media"])->where("user_id",$user_id)->find($RealEstate_id);

        return Response::successResponse(new editRealEstateResource($RealEstate),__("real_estate_client.Real Estate has been fetched success for update"));
    }

    public function updateRealEstate($real_estate_id,$request){
        $user_id = Auth::id();
        $RealEstate = RealEstate::where("user_id",$user_id)->find($real_estate_id);
        if (!$RealEstate){
            return Response::errorResponse(__("real_estate_client.No reel estate by this id"));
        }


        $RealEstate = $RealEstate->update($request->all());

        if($request->units){
            foreach ($request->units as $unit){
                $Unit = Unit::whereIn("unit_status_id",[1,2])->where("real_estate_id",$real_estate_id)->find($unit["id"]);
                if (!$unit){
                    return Response::errorResponse(__("real_estate_client.No unit by this id"));
                }
                $Unit->Update($unit);



                //update commercial info
                if ($request->building_type_use_id == 1){
                    $CommercialInfo_data = $Unit->only("unit_length","unit_direction","number_parking_lots","sign_area","sign_location","special_sign_specification","insurance_policy_number","mezzanine","unit_finishing");
                    $CommercialInfo = $Unit->CommercialInfo;
                    $CommercialInfo->update($CommercialInfo_data);
                }

            }
        }

        // add units
        $UnitsArray = [];
        if ($request->new_units){
            foreach ($request->new_units as $unit){
                $unit['real_estate_id'] = $real_estate_id;

                $UnitX = Unit::create($unit);
                $unit['unit_id'] = $UnitX->id;
                array_push($UnitsArray,$unit);
                if ($unit['media']){
                    $path = "Unit_Media/";
                    foreach ($unit['media'] as $media){
                        $file_name = $this->SaveFile($media,$path);
                        $type = $this->getFileType($media);
                        Media::create([
                            'mediable_type' => $UnitX->getMorphClass(),
                            'mediable_id' => $UnitX->id,
                            'title' => "Unit",
                            'type' => $type,
                            'directory' => $path,
                            'filename' => $file_name
                        ]);
                    }
                }
            }
        }


        // add commercial data
        if($request->building_type_use_id == 1){
            if($request->new_units){
                foreach ($UnitsArray as $unit){
                    $commercialInfo = CommercialInfo::create($unit);
                }

            }
        }

        return Response::successResponse($RealEstate,__("real_estate_client.Real estate has been updated success"));
    }

    public function deleteRealEstate($real_estate_id){
        $user_id = Auth::id();
        $RealEstate = RealEstate::where("user_id",$user_id)->find($real_estate_id);
        if (!$RealEstate){
            return Response::errorResponse(__("real_estate_client.No reel estate by this id"));
        }

        $Units = $RealEstate->Units;
        foreach ($Units as $unit){
            if ($unit->unit_status_id != 1 && $unit->unit_status_id != 2){
                return Response::errorResponse(__("real_estate_client.You can't delete this real estate because unit is not new or pending"));
            }

            $unit->delete();
        }

        $RealEstate->delete();
        return Response::successResponse([],__("real_estate_client.Real estate has been deleted success"));
    }

    public function deleteUnit($unit_id){
        $user_id = Auth::id();
        $Unit = Unit::whereHas("RealEstate",function ($q) use ($user_id){
            $q->where("user_id",$user_id);
        })->WhereIn("unit_status_id",[1,2])->find($unit_id);
        if (!$Unit){
            return Response::errorResponse(__("real_estate_client.please select valid unit"));
        }

        $Units = Unit::where("real_estate_id",$Unit->real_estate_id)->get()->count();
        if ($Units == 1){
            return Response::errorResponse(__("real_estate_client.you can't delete this unit you can delete the real estate"));
        }

        $Unit->delete();
        return Response::successResponse([],__("real_estate_client.Unit has been deleted success"));
    }

    public function updateCoverRealEstate($request){
        $user_id = Auth::id();
        $RealEstate = RealEstate::where("user_id",$user_id)->find($request->real_estate_id);
        if (!$RealEstate){
            return Response::errorResponse(__("real_estate_client.No reel estate by this id"));
        }
        $CoverImages = $RealEstate->Media;

        foreach ($CoverImages as $coverImage){
            $coverImage->delete();
        }

        if ($request->cover){
            $path = "RealEstateCover/";
            $file_name = $this->SaveFile($request->cover,$path);
            $type = $this->getFileType($request->cover);
            Media::create([
                'mediable_type' => $RealEstate->getMorphClass(),
                'mediable_id' => $RealEstate->id,
                'title' => "Real Estate",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }
        $CoverImages = $RealEstate->Media;

        return Response::successResponse($RealEstate,__("real_estate_client.cover real estate image has been updated success"));
    }

    public function updateMediaUnit($request)
    {
        $user_id = Auth::id();
        $Unit = Unit::whereHas("RealEstate",function ($q) use ($user_id){
            $q->where("user_id",$user_id);
        })->find($request->unit_id);
        if (!$Unit) {
            return Response::errorResponse(__("real_estate_client.please select valid unit"));
        }
        $UnitImages = $Unit->Media;

        foreach ($UnitImages as $image) {
            $image->delete();
        }

        if ($request->media) {
            $path = "Unit_Media/";
            foreach ($request->media as $media) {
                $file_name = $this->SaveFile($media, $path);
                $type = $this->getFileType($media);
                Media::create([
                    'mediable_type' => $Unit->getMorphClass(),
                    'mediable_id' => $Unit->id,
                    'title' => "Unit",
                    'type' => $type,
                    'directory' => $path,
                    'filename' => $file_name
                ]);
            }
            $UnitImages = $Unit->Media;

            return Response::successResponse($Unit, __("real_estate_client.media unit has been updated success"));
        }
    }
}
