<?php


namespace App\Services\Admin;


use App\Http\Resources\Admin\Deal\IndexPaginate;
use App\Http\Resources\Admin\Deal\ShowResource;
use App\Models\Contract;
use App\Models\ContractStatus;
use App\Models\Media;
use App\Models\Request;
use App\Notifications\ClientNotification;
use App\Traits\FireBaseServiceTrait;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DealService
{
    use GeneralFileService;
    use FireBaseServiceTrait;

    public function getContractStatus(){
        $ContractStatus = ContractStatus::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();
        return Response::successResponse($ContractStatus,__("deals.status has been fetched success"));
    }

    public function index($request){
        $Contracts = Contract::with(["Request" => function ($q){
            $q->with(["User","Unit" => function($q){
                $q->with(["RealEstate" => function($q){
                    $q->with(["User","BuildingTypeUse" => function($q){
                        $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
                    }]);
                },"PurposeProperty" => function($q){
                    $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
                }]);
            },"DepositInvoice" => function($q){
                $q->with(["InvoiceStatus" => function($q){
                    $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
                }]);
            }]);
        },"ContractStatus" => function($q){
            $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
        }])->whereHas("Request" ,function ($q) use ($request){
            $q->whereHas("User",function ($q) use ($request){
                $q->where("name","like","%".$request->search."%");
            })->OrWhereHas("Unit",function ($q) use ($request){
                $q->whereHas("RealEstate",function ($q) use ($request){
                    $q->whereHas("User",function ($q) use ($request){
                        $q->where("name","like","%".$request->search."%");
                    });
                });
            });
        })->OrWhere("id",$request->search);

        if ($request->status != 0){
            $Contracts = $Contracts->where("contract_status_id" , $request->status);
        }

        $Contracts = $Contracts->paginate(10);

        return Response::successResponse(IndexPaginate::make($Contracts),__("deals.Deals have been fetched success"));
    }

    public function showDeal($deal_id){
        $Contract = Contract::with(["Request" =>function($q){
            $q->with(["Unit" => function($q){
                $q->with(["RealEstate" => function($q){
                    $q->with(["User" => function($q){
                        $q->with(["TypeIdentity" => function($q){
                            $q->select("id",LaravelLocalization::getCurrentLocale()."_title as title");
                        },"Nationality" => function($q){
                            $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
                        }]);
                    },"BuildingType" => function($q){
                        $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
                    },"BuildingTypeUse" => function($q){
                        $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
                    }]);
                },"CommercialInfo","CommercialActivity"]);
            },"User" => function($q){
                $q->with(["TypeIdentity" => function($q){
                    $q->select("id",LaravelLocalization::getCurrentLocale()."_title as title");
                },"Nationality" => function($q){
                    $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
                }]);
            },"RentPaymentCycle" => function($q){
                $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
            }]);
        }])->whereNotIn("contract_status_id",[1,4])->find($deal_id);

        if (!$Contract){
            return Response::errorResponse(__("deals.No deal by this id"));
        }

        if ($Contract["Request"]["Unit"]->purpose_property_id == 1){
            return Response::successResponse(ShowResource::make($Contract),__("deals.deal has been fetched success"));
        }else{
            return Response::successResponse([],"coming soon");
        }

    }

    public function uploadContract($request){
        $Contract = Contract::whereNotIn("contract_status_id",[1,4])->find($request->deal_id);
        if(!$Contract){
            return Response::errorResponse(__("deals.No deal by this id"));
        }

        if ($request->contract_file){
            $path = "Contracts/";
            $file_name = $this->SaveFile($request->contract_file,$path);
            $type = $this->getFileType($request->contract_file);

            $ContractMedia = $Contract->media;
            if ($ContractMedia){
                $ContractMedia->update([
                    'type' => $type,
                    'directory' => $path,
                    'filename' => $file_name
                ]);
            }else{
                Media::create([
                    'mediable_type' => $Contract->getMorphClass(),
                    'mediable_id' => $Contract->id,
                    'title' => "Contract",
                    'type' => $type,
                    'directory' => $path,
                    'filename' => $file_name
                ]);
            }

            $Contract->contract_status_id = 3;
            $Contract->save();

            $user = $Contract->Request->User;

            $unit = $Contract->Request->Unit;

            $unit->update([
                "unit_status_id" => $unit->purpose_property_id == 1 ? 5 : 3,
                "beneficiary_id" => $user->id,
                "beneficiary_status_id" => $unit->purpose_property_id == 1 ? 6 : 4
            ]);

            //Send Notification
            $UserOne = $Contract->Request->Unit->RealEstate->User;
            $UserTwo = $Contract->Request->User;

            $data = [
                "title_ar" => "توثيق العقد",
                "title_en" => "Documentation of the contract",
                "content_ar" => "تم توثيق العقد بنجاح",
                "content_en" => "The contract has been successfully documented",
                "code" => "U116"
            ];

            Notification::send($UserOne,new ClientNotification($data));
            Notification::send($UserTwo,new ClientNotification($data));

            if ($UserOne->fcm_token){
                $this->PushNotificationPerformRequest($UserOne->fcm_token,"Documentation of the contract","The contract has been successfully documented");
            }
            if ($UserTwo->fcm_token){
                $this->PushNotificationPerformRequest($UserTwo->fcm_token,"Documentation of the contract","The contract has been successfully documented");
            }

            return Response::successResponse([],__("deals.contract has been uploaded"));
        }

        return Response::errorResponse(__("deals.contract not uploaded please try again"));
    }
}
