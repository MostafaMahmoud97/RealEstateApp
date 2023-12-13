<?php


namespace App\Services\Client;


use App\Http\Resources\Client\RealEstate\Discover\DiscoverPagigateResource;
use App\Http\Resources\Client\RealEstate\editRealEstateResource;
use App\Http\Resources\Client\RealEstate\Home\HomePagigateResource;
use App\Http\Resources\Client\RealEstate\ListAllMyPropertiesResource;
use App\Http\Resources\Client\RealEstate\ShowMyPropertyResource;
use App\Http\Resources\Client\RealEstate\ShowUnitResource;
use App\Models\BuildingType;
use App\Models\BuildingTypeUse;
use App\Models\CommercialActivities;
use App\Models\CommercialInfo;
use App\Models\Media;
use App\Models\PurposeProperty;
use App\Models\RealEstate;
use App\Models\Unit;
use App\Models\User;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function getCommercialActivity(){
        $user_id = Auth::id();
        $CommercialActivity = CommercialActivities::select("id","company_name","cr_number")->where("user_id",$user_id)->get();
        return Response::successResponse($CommercialActivity,__("commercial_activity_client.Commercial activities have been fetched success"));
    }

    public function store($request){
        $User = Auth::user();

        $request->merge(["user_id" => $User->id]);

        //store real estate
        $RealEstate = RealEstate::create($request->all());

        if ($request->cover_real_estate){
            $path = "RealEstateCover/";
            $file_name = $this->SaveBase64Image($request->cover_real_estate,$request->cover_real_estate_extention,$path);
            $type = $this->getFileTypeByBase64($request->cover_real_estate_extention);
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
        if ($request->unit){
            $UnitX = Unit::create(array_merge($request->unit,["real_estate_id"=>$RealEstate->id]));
            array_push($UnitsArray,array_merge($request->unit,['unit_id'=>$UnitX->id]));
            if ($request->unit['media']){
                $path = "Unit_Media/";
                foreach ($request->unit['media'] as $media){
                    $file_name = $this->SaveBase64Image($media['media'],$media["extention"],$path);
                    $type = $this->getFileTypeByBase64($media["extention"]);
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

    public function listAllMyProperties($request){
        $User_id = Auth::id();


        $Units = Unit::select('id','purpose_property_id','real_estate_id','beneficiary_id','unit_number','unit_area','beneficiary_status_id','unit_status_id','price')->with(["RealEstate" => function($q) use ($User_id){
            $q->with(["BuildingType" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            },"BuildingTypeUse" =>  function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            },"media"])->select('id','building_type_id','building_type_use_id','user_id','national_address');
        },"PurposeProperty" => function($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        }]);

        // filter
        if ($request->check_building_use && $request->check_building_use == "commercial"){
            $Units->whereHas("RealEstate",function ($q) use ($request){
                $q->where("building_type_use_id" , 1);
            });
        }elseif ($request->check_building_use && $request->check_building_use == "residential"){
            $Units->whereHas("RealEstate",function ($q) use ($request){
                $q->where("building_type_use_id" , 2);
            });
        }
// -----------------------------end filter

        if ($request->selected == 1 || $request->selected == 2 || $request->selected == 3 || $request->selected == 5){ // for my new, pending , Seller , Lessor
            $Units = $Units->whereHas("RealEstate",function ($q) use ($User_id){
                $q->where("user_id",$User_id);
            })->where("unit_status_id",$request->selected)->get();
        }elseif ($request->selected == 4 || $request->selected == 6){ // Buyer, Lessee
            $Units = $Units->where("beneficiary_id" ,$User_id)->where("beneficiary_status_id",$request->selected)->get();
        }


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
        },"Media"])
            ->where(function ($q) use ($user_id,$unit_id){
            $q->whereHas("RealEstate",function ($q) use ($user_id){
                $q->where("user_id",$user_id);
            })->whereIn("unit_status_id",[1,2,3,5])->where("id",$unit_id);
        })->OrWhere(function ($q) use ($user_id,$unit_id){
            $q->where("beneficiary_id",$user_id)->whereIn("beneficiary_status_id",[4,6])->where("id",$unit_id);
        })->find($unit_id);

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
            },"CommercialInfo","CommercialActivity","media"]);
        },"media"])->where("user_id",$user_id)->find($RealEstate_id);

        return Response::successResponse(new editRealEstateResource($RealEstate),__("real_estate_client.Real Estate has been fetched success for update"));
    }

    public function editRealEstateNew($realEstate_id){

        $user_id = Auth::id();

        $RealEstate = RealEstate::with(["BuildingType" => function ($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        },"BuildingTypeUse" => function ($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        },"media"])->where("user_id",$user_id)->find($realEstate_id);

        if (!$RealEstate){
            return Response::errorResponse(__("real_estate_client.no real estate by this id"));
        }


        return Response::successResponse($RealEstate,__("real_estate_client.Real estate fetched success"));
    }

    public function editUnitNew($unit_id){
        $user_id = Auth::id();

        $Unit = Unit::with(["RealEstate" => function($q){
            $q->select("id","building_type_use_id")->with(["BuildingTypeUse"=>function($q){
                $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
            }]);
        },"CommercialActivity","PurposeProperty" => function($q){
            $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
        },"CommercialInfo","media"])
            ->where("beneficiary_id",0)->whereHas("RealEstate",function ($q) use ($user_id){
            $q->where("user_id",$user_id);
        })->find($unit_id);

        if (!$Unit){
            return Response::errorResponse("real_estate_client.please select valid unit");
        }

        return Response::successResponse($Unit,__("real_estate_client.unit has been fetched success"));
    }


    public function updateRealEstate($real_estate_id,$request){
        $user_id = Auth::id();
        $RealEstate = RealEstate::where("user_id",$user_id)->find($real_estate_id);
        if (!$RealEstate){
            return Response::errorResponse(__("real_estate_client.No reel estate by this id"));
        }

        $RealEstate = $RealEstate->update($request->all());

        return Response::successResponse($RealEstate,__("real_estate_client.Real estate has been updated success"));
    }

    public function AddNewUnit($request){
        $user_id = Auth::id();

        $RealEstate = RealEstate::where("user_id",$user_id)->find($request->real_estate_id);
        if (!$RealEstate){
            return Response::errorResponse(__("real_estate_client.No reel estate by this id"));
        }

        $Unit = Unit::create($request->all());
        if ($request->media){
            $path = "Unit_Media/";
            foreach ($request->media as $media){
                $file_name = $this->SaveBase64Image($media["media"],$media["extention"],$path);
                $type = $this->getFileTypeByBase64($media["extention"]);
                Media::create([
                    'mediable_type' => $Unit->getMorphClass(),
                    'mediable_id' => $Unit->id,
                    'title' => "Unit",
                    'type' => $type,
                    'directory' => $path,
                    'filename' => $file_name
                ]);
            }
        }

        // add commercial data
        if($request->building_type_use_id == 1){
            $commercialInfo = CommercialInfo::create(array_merge($request->all(),["unit_id" => $Unit->id]));
        }

        return Response::successResponse($Unit,__("real_estate_client.Unit has been added success"));

    }

    public function updateUnit($unit_id,$request){
        $user_id = Auth::id();
        $Unit = Unit::whereHas("RealEstate",function ($q) use ($user_id){
            $q->where("user_id",$user_id);
        })->find($unit_id);

        if (!$Unit){
            return Response::errorResponse(__("real_estate_client.please select valid unit"));
        }

        $Unit->update($request->all());
        //update commercial info
        if ($request->building_type_use_id == 1){
            $CommercialInfo = $Unit->CommercialInfo;
            if ($CommercialInfo){
                $CommercialInfo->update($request->all());
            }else{
                $data = $request->all();
                $data["unit_id"] = $unit_id;
                $CommercialInfo = CommercialInfo::create($data);
            }

        }

        return Response::successResponse($Unit,__("real_estate_client.Unit has been updated success"));
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
            $file_name = $this->SaveBase64Image($request->cover,$request->extention,$path);
            $type = $this->getFileTypeByBase64($request->extention);
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
                $file_name = $this->SaveBase64Image($media["media"],$media["extention"], $path);
                $type = $this->getFileTypeByBase64($media["extention"]);
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

    public function DiscoverUnit($request){
        $Units = Unit::with(["RealEstate" =>function($q){
            $q->select("id","lat","lon","building_type_id","building_type_use_id","national_address")
                ->with(["media","BuildingType" => function($q){
                    $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
                },"BuildingTypeUse" => function($q){
                    $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
                }]);
        },"PurposeProperty" => function($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        }])->whereIn("unit_status_id",[1,2]);

        if($request->location['lat'] && $request->location['lon']){
            $Units = $Units->select(DB::raw("units.id,units.real_estate_id,units.purpose_property_id,units.price,units.unit_number,units.unit_area,SQRT(POWER(real_estates.lat - ".$request->location['lat'].",2) + POWER(real_estates.lon - ".$request->location['lon'].",2)) AS distance"))
                ->join('real_estates','units.real_estate_id' ,'=','real_estates.id')->orderBy('distance');
        }

        if ($request->purpose_id){
            $Units = $Units->whereHas("PurposeProperty",function ($q) use ($request){
                $q->where("id",$request->purpose_id);
            });
        }

        if ($request->price && $request->price['min'] && $request->price['max']){
            $Units = $Units->whereBetween("price",[$request->price['min'],$request->price['max']]);
        }

        if ($request->area && $request->area['min'] && $request->area['max']){
            $Units = $Units->whereBetween("unit_area",[$request->area['min'],$request->area['max']]);
        }

        if ($request->lots && $request->lots['min'] && $request->lots['max']){
            $Units = $Units->whereHas("RealEstate",function ($q) use ($request){
                $q->whereBetween("number_parking_lots",[$request->lots['min'],$request->lots['max']]);
            });
        }

        if ($request->property_type_id){
            $Units = $Units->whereHas("RealEstate",function ($q) use ($request){
                $q->whereIn("building_type_id",$request->property_type_id);
            });
        }

        if ($request->property_usage_id){
            $Units = $Units->whereHas("RealEstate",function ($q) use ($request){
                $q->whereIn("building_type_use_id",$request->property_usage_id);
            });
        }


        $Units = $Units->paginate(50);

        return Response::successResponse(DiscoverPagigateResource::make($Units),__("real_estate.Units have been fetched success"));
    }

    public function HomeUnit($request){
        $Units = Unit::with(["RealEstate" =>function($q){
            $q->select("id","lat","lon","building_type_id","building_type_use_id","national_address")
                ->with(["media","BuildingType" => function($q){
                    $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
                },"BuildingTypeUse" => function($q){
                    $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
                }]);
        },"PurposeProperty" => function($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        }])->whereIn("unit_status_id",[1,2]);

        if($request->location['lat'] && $request->location['lon']){
            $Units = $Units->select(DB::raw("units.id,units.real_estate_id,units.purpose_property_id,units.price,units.unit_number,units.unit_area,SQRT(POWER(real_estates.lat - ".$request->location['lat'].",2) + POWER(real_estates.lon - ".$request->location['lon'].",2)) AS distance"))
                ->join('real_estates','units.real_estate_id' ,'=','real_estates.id')->orderBy('distance');
        }

        if ($request->purpose_id){
            $Units = $Units->whereHas("PurposeProperty",function ($q) use ($request){
                $q->where("id",$request->purpose_id);
            });
        }

        if ($request->price && $request->price['min'] && $request->price['max']){
            $Units = $Units->whereBetween("price",[$request->price['min'],$request->price['max']]);
        }

        if ($request->area && $request->area['min'] && $request->area['max']){
            $Units = $Units->whereBetween("unit_area",[$request->area['min'],$request->area['max']]);
        }

        if ($request->lots && $request->lots['min'] && $request->lots['max']){
            $Units = $Units->whereHas("RealEstate",function ($q) use ($request){
                $q->whereBetween("number_parking_lots",[$request->lots['min'],$request->lots['max']]);
            });
        }

        if ($request->property_type_id){
            $Units = $Units->whereHas("RealEstate",function ($q) use ($request){
                $q->where("building_type_id",$request->property_type_id);
            });
        }

        if ($request->property_usage_id && $request->property_usage_id != null && $request->property_usage_id != "" ){
            $Units = $Units->whereHas("RealEstate",function ($q) use ($request){
                $q->whereIn("building_type_use_id",$request->property_usage_id);
            });
        }


        $Units = $Units->paginate(50);

        return Response::successResponse(HomePagigateResource::make($Units),__("real_estate.Units have been fetched success"));
    }

    public function showUnit($unit_id){
        $Unit = Unit::with(["RealEstate" => function($q){
            $q->with(["User" => function($q){
                $q->select("id","name","phone","email");

            },"Media","BuildingType" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            },"BuildingTypeUse" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            }]);
        },"CommercialInfo","PurposeProperty" => function($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        },"Media"])->whereHas("RealEstate")->find($unit_id);

        if (!$Unit){
            return Response::errorResponse(__("real_estate_client.please select valid unit"));
        }

        return Response::successResponse(ShowUnitResource::make($Unit),__("real_estate_client.Unit has been fetched"));
    }
}
