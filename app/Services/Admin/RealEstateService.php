<?php


namespace App\Services\Admin;


use App\Http\Resources\Admin\RealEstate\ListAllPropertiesResource;
use App\Http\Resources\Admin\RealEstate\PaginateIndexResource;
use App\Http\Resources\Admin\RealEstate\PaginateListAllUnitsResource;
use App\Http\Resources\Admin\RealEstate\ShowPropertyResource;
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

        return Response::successResponse(["building_types" => $BuildingTypes,"building_type_uses" => $BuildingTypeUses,"purpose_properties" => $PurposeProperties],__("real_estate.Help data has been fetched success"));
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

        return Response::successResponse($RealEstate,__("real_estate.Real estate has been added success"));
    }

    public function listAllProperties($user_id){
        $User = User::find($user_id);
        if(!$User){
            return Response::errorResponse(__("real_estate.You must choose valid user"));
        }

        $Units = Unit::select('id','real_estate_id','beneficiary_id','purpose_property_id','unit_status_id','price')->where(function ($q) use ($user_id){
            $q->where("beneficiary_id",$user_id)->OrWhereHas("RealEstate",function ($q) use ($user_id){
                $q->where("user_id",$user_id);
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
        }])->paginate(10);

        return Response::successResponse(PaginateIndexResource::make($Units),__("real_estate.Properties have been fetched"));
    }

    public function showProperty($request){
        $Unit = Unit::with(["RealEstate" => function($q){
            $q->with(["User" => function($q){
                $q->select("id","name","nationality","phone","email","id_number");
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

    public function listAllUnits(){
        $Units = Unit::select("id","real_estate_id","purpose_property_id","price","unit_number","unit_area")->with(["RealEstate" =>function($q){
            $q->select("id","building_type_id","building_type_use_id","national_address")
                ->with(["media","BuildingType" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            },"BuildingTypeUse" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            }]);
        },"PurposeProperty" => function($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        }])->paginate(10);

        return Response::successResponse(PaginateListAllUnitsResource::make($Units),__("real_estate.Units have been fetched success"));
    }

    public function showUnit($unit_id){
        $Unit = Unit::with(["RealEstate" => function($q){
            $q->with(["User" => function($q){
                $q->select("id","name","nationality","phone","email","id_number");
            },"Media","BuildingType" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            },"BuildingTypeUse" => function($q){
                $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
            }]);
        },"CommercialInfo","PurposeProperty" => function($q){
            $q->select('id','title_'.LaravelLocalization::getCurrentLocale()." as title");
        },"Media"])->find($unit_id);

        if (!$Unit){
            return Response::errorResponse(__("real_estate.please select valid property"));
        }

        return Response::successResponse(ShowPropertyResource::make($Unit),__("real_estate.Unit has been fetched"));

    }
}
