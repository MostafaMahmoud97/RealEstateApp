<?php


namespace App\Services\Admin;


use App\Http\Resources\Admin\RealEstate\editRealEstateResource;
use App\Http\Resources\Admin\RealEstate\PaginateIndexResource;
use App\Http\Resources\Admin\RealEstate\PaginateListAllUnitsResource;
use App\Http\Resources\Admin\RealEstate\ShowPropertyResource;
use App\Models\BuildingType;
use App\Models\BuildingTypeUse;
use App\Models\CommercialActivities;
use App\Models\CommercialInfo;
use App\Models\Media;
use App\Models\PurposeProperty;
use App\Models\RealEstate;
use App\Models\Unit;
use App\Models\UnitStatus;
use App\Models\User;
use App\Traits\GeneralFileService;
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

        return Response::successResponse(["building_types" => $BuildingTypes,"building_type_uses" => $BuildingTypeUses,"purpose_properties" => $PurposeProperties],__("real_estate.Help data has been fetched success"));
    }

    public function getCommercialActivity($user_id){
        $CommercialActivity = CommercialActivities::select("id","company_name","cr_number")->where("user_id",$user_id)->get();
        return Response::successResponse($CommercialActivity,__("commercial_activity_client.Commercial activities have been fetched success"));
    }

    public function store($request){
        $User = User::find($request->user_id);
        if(!$User){
            return Response::errorResponse(__("real_estate.You must choose valid user"));
        }

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
        if ($request->unit){

            $UnitX = Unit::create(array_merge($request->unit,['real_estate_id'=> $RealEstate->id]));

            array_push($UnitsArray,array_merge($request->unit,['unit_id'=>$UnitX->id]));
            if ($request->unit['media']){
                $path = "Unit_Media/";
                foreach ($request->unit['media'] as $media){
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


        // add commercial data
        if($request->building_type_use_id == 1){
            if($request->unit){
                foreach ($UnitsArray as $unit){

                    $commercialInfo = CommercialInfo::create($unit);
                }
            }
        }

        return Response::successResponse($RealEstate,__("real_estate.Real estate has been added success"));
    }

    public function listAllStatus(){
        $status = UnitStatus::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();
        return Response::successResponse($status,__("real_estate.Status has been fetched success"));
    }

    public function listAllProperties($request){
        $User = User::find($request->user_id);
        if(!$User){
            return Response::errorResponse(__("real_estate.You must choose valid user"));
        }

        $Units = Unit::select('id','real_estate_id','beneficiary_id','purpose_property_id','unit_status_id','beneficiary_status_id','price')->where(function ($q) use ($request){
            $q->where(function ($q) use ($request){
                $q->where("beneficiary_id",$request->user_id)->where(function ($q) use ($request){
                    $q->whereHas("RealEstate",function ($q) use ($request){
                        $q->where("national_address",'like','%'.$request->search.'%');
                    })->OrWhere("id",$request->search);
                })->whereIn("beneficiary_status_id",$request->status);
            })->OrWhere(function ($q) use ($request){
                $q->WhereHas("Beneficiary",function ($q) use ($request){
                    $q->where("name","like","%".$request->search."%");
                })->WhereHas("RealEstate",function ($q) use ($request){
                    $q->where("user_id",$request->user_id);
                })->whereIn("unit_status_id",$request->status);
            })->OrWhere(function ($q) use ($request){
                $q->where("id",$request->search)->whereHas("RealEstate",function ($q) use ($request){
                    $q->where("user_id",$request->user_id);
                })->whereIn("unit_status_id",$request->status);
            })->OrWhere(function ($q) use ($request){
                $q->whereHas("RealEstate",function ($q) use ($request){
                    $q->where("user_id",$request->user_id)->where("national_address",'like','%'.$request->search.'%');
                })->whereIn("unit_status_id",$request->status);
            });
        })->with(["RealEstate" => function($q){
            $q->with(["BuildingType" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            },"BuildingTypeUse" =>  function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            }])->select('id','building_type_id','building_type_use_id','national_address');
        },"Beneficiary" => function($q){
            $q->select('id','name');
        },"PurposeProperty" => function($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        },"UnitStatus" => function($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        },"BeneficiaryStatus" => function($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        }])->paginate(10);

        foreach ($Units->items() as $item){
            $item->user_id = $request->user_id;
        }

        return Response::successResponse(PaginateIndexResource::make($Units),__("real_estate.Properties have been fetched"));
    }

    public function showProperty($request){
        $Unit = Unit::with(["RealEstate" => function($q){
            $q->with(["User" => function($q){
                $q->select("id","name","nationality_id","phone","email","id_number")
                ->with(["Nationality" => function($q) {
                    $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
                }]);
            },"Media","BuildingType" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            },"BuildingTypeUse" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            }]);
        },"CommercialInfo","PurposeProperty" => function($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        },"Media"])->where(function ($q) use ($request){
            $q->where("beneficiary_id",$request->user_id)
                ->OrWhereHas("RealEstate",function ($q) use ($request){
                $q->where("user_id",$request->user_id);
            });
        })->find($request->unit_id);

        if (!$Unit){
            return Response::errorResponse(__("real_estate.please select valid property"));
        }

        return Response::successResponse(ShowPropertyResource::make($Unit),__("real_estate.property has been fetched"));
    }

    public function listAllUnits($request){

        $Units = Unit::with(["RealEstate" =>function($q){
            $q->select("id","lat","lon","building_type_id","building_type_use_id","national_address")
                ->with(["media","BuildingType" => function($q){
                    $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
                },"BuildingTypeUse" => function($q){
                    $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
                }]);
        },"PurposeProperty" => function($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        }]);

        if($request->lat && $request->lon){
            $Units = $Units->select(DB::raw("units.id,units.real_estate_id,units.purpose_property_id,units.price,units.unit_number,units.unit_area,SQRT(POWER(real_estates.lat - ".$request->lat.",2) + POWER(real_estates.lon - ".$request->lon.",2)) AS distance"))
                ->join('real_estates','units.real_estate_id' ,'=','real_estates.id')->orderBy('distance');
        }else{

            $Units = $Units->select("id","real_estate_id","purpose_property_id","price","unit_number","unit_area");
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
                $q->where("building_type_use_id",$request->property_usage_id);
            });
        }


        $Units = $Units->paginate(8);

        return Response::successResponse(PaginateListAllUnitsResource::make($Units),__("real_estate.Units have been fetched success"));
    }

    public function showUnit($unit_id){
        $Unit = Unit::with(["RealEstate" => function($q){
            $q->with(["User" => function($q){
                $q->select("id","name","nationality_id","phone","email","id_number")
                ->with(["Nationality" => function($q) {
                    $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
                }]);
            },"Media","BuildingType" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            },"BuildingTypeUse" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            }]);
        },"CommercialInfo","PurposeProperty" => function($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        },"Media"])->find($unit_id);

        if (!$Unit){
            return Response::errorResponse(__("real_estate.please select valid unit"));
        }

        return Response::successResponse(ShowPropertyResource::make($Unit),__("real_estate.Unit has been fetched"));
    }

    public function editRealEstate($unit_id){
        $Unit = Unit::find($unit_id);
        if (!$Unit){
            return Response::errorResponse(__("real_estate.please select valid unit"));
        }
        $RealEstate_id = $Unit->RealEstate->id;

        $RealEstate = RealEstate::with(["BuildingType" => function ($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        },"BuildingTypeUse" => function ($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        },"Units" => function ($q){
            $q->with(["PurposeProperty" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            },"CommercialInfo","CommercialActivity","media"]);
        },"media"])->find($RealEstate_id);

        return Response::successResponse(new editRealEstateResource($RealEstate),__("real_estate.Real Estate has been fetched success for update"));
    }

    public function updateRealEstate($real_estate_id,$request){
        $RealEstate = RealEstate::find($real_estate_id);
        if (!$RealEstate){
            return Response::errorResponse(__("real_estate.No reel estate by this id"));
        }

        $RealEstate = $RealEstate->update($request->all());

        return Response::successResponse($RealEstate,__("real_estate.Real estate has been updated success"));
    }

    public function AddNewUnit($request){
        $RealEstate = RealEstate::find($request->real_estate_id);
        if (!$RealEstate){
            return Response::errorResponse(__("real_estate.No reel estate by this id"));
        }

        $Unit = Unit::create($request->all());
        if ($request->media){
            $path = "Unit_Media/";
            foreach ($request->media as $media){
                $file_name = $this->SaveFile($media,$path);
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
        }

        // add commercial data
        if($request->building_type_use_id == 1){
            $commercialInfo = CommercialInfo::create(array_merge($request->all(),["unit_id" => $Unit->id]));
        }

        return Response::successResponse($Unit,__("real_estate.Unit has been added success"));

    }

    public function updateUnit($unit_id,$request){
        $Unit = Unit::find($unit_id);
        if (!$Unit){
            return Response::errorResponse(__("real_estate.please select valid unit"));
        }

        $Unit->update($request->all());
        //update commercial info
        if ($request->building_type_use_id == 1){
            $CommercialInfo = $Unit->CommercialInfo;
            $CommercialInfo->update($request->all());
        }

        return Response::successResponse($Unit,__("real_estate.Unit has been updated success"));
    }

    public function deleteRealEstate($real_estate_id){
        $RealEstate = RealEstate::find($real_estate_id);
        if (!$RealEstate){
            return Response::errorResponse(__("real_estate.No reel estate by this id"));
        }

        $Units = $RealEstate->Units;
        foreach ($Units as $unit){
            if ($unit->unit_status_id != 1 && $unit->unit_status_id != 2){
                return Response::errorResponse(__("real_estate.You can't delete this real estate because unit is not new or pending"));
            }

            $unit->delete();
        }

        $RealEstate->delete();
        return Response::successResponse([],__("real_estate.Real estate has been deleted success"));
    }

    public function deleteUnit($unit_id){
        $Unit = Unit::find($unit_id);
        if (!$Unit){
            return Response::errorResponse(__("real_estate.please select valid unit"));
        }

        $Units = Unit::where("real_estate_id",$Unit->real_estate_id)->get()->count();
        if ($Units == 1){
            return Response::errorResponse(__("real_estate.you can't delete this unit you can delete the real estate"));
        }

        $Unit->delete();
        return Response::successResponse([],__("real_estate.Unit has been deleted success"));
    }

    public function updateCoverRealEstate($request){
        $RealEstate = RealEstate::find($request->real_estate_id);
        if (!$RealEstate){
            return Response::errorResponse(__("real_estate.No reel estate by this id"));
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

        return Response::successResponse($RealEstate,__("real_estate.cover real estate image has been updated success"));
    }

        public function updateMediaUnit($request)
        {
            $Unit = Unit::find($request->unit_id);
            if (!$Unit) {
                return Response::errorResponse(__("real_estate.please select valid unit"));
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

                return Response::successResponse($Unit, __("real_estate.media unit has been updated success"));
            }
        }

}
