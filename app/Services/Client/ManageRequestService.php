<?php


namespace App\Services\Client;


use App\Events\AdminNotifyEvent;
use App\Http\Resources\Client\ManageRequest\ReceivedRequestsResource;
use App\Http\Resources\Client\ManageRequest\SentRequestPaginateResources;
use App\Http\Resources\Client\ManageRequest\ShowDepositInvoiceResource;
use App\Http\Resources\Client\ManageRequest\ShowReceivedRequestsResource;
use App\Models\Admin;
use App\Models\Contract;
use App\Models\DepositInvoice;
use App\Models\RentPaymentCycle;
use App\Models\Request;
use App\Models\RequestStatus;
use App\Models\Unit;
use App\Models\User;
use App\Notifications\ClientNotification;
use App\Traits\FireBaseServiceTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ManageRequestService
{
    use FireBaseServiceTrait;

    public function ClickSendRequest($unit_id){
        $user_id = Auth::id();
        $Unit = Unit::whereHas("RealEstate", function ($q) use ($user_id){
            $q->where("user_id","!=",$user_id);
        })->whereDoesntHave("Requests",function ($q) use ($user_id,$unit_id){
            $q->where(function ($q){
                $q->where("request_states_id",2)->whereDate("tenancy_end_date",">=",Carbon::today()->toDateString());
            });
//                ->OrWhere(function ($q) use ($unit_id,$user_id){
//                $q->where("unit_id",$unit_id)->where("user_id",$user_id)->whereDate("tenancy_end_date",">=",Carbon::today()->toDateString());
//            });
        })->find($unit_id);

        if (!$Unit){
            return Response::errorResponse(__("manage_request.you can't request this unit"));
        }

        $data = [];

        if ($Unit->purpose_property_id == 1){
            return Response::successResponse(true,__("manage_request.data has been fetched success"));
        }else{
            return Response::successResponse("Coming soon",__("manage_request.data has been fetched success"));
        }

    }


    public function CalcAnnualRent($request){
        $unit_id = $request->unit_id;
        $user_id = Auth::id();
        $Unit = Unit::whereHas("RealEstate", function ($q) use ($user_id){
            $q->where("user_id","!=",$user_id);
        })->whereDoesntHave("Requests",function ($q) use ($user_id,$unit_id){
            $q->where(function ($q){
                $q->where("request_states_id",2)->whereDate("tenancy_end_date",">=",Carbon::today()->toDateString());
            });
//                ->OrWhere(function ($q) use ($unit_id,$user_id){
//                $q->where("unit_id",$unit_id)->where("user_id",$user_id)->whereDate("tenancy_end_date",">=",Carbon::today()->toDateString());
//            })
        })->find($request->unit_id);

        if (!$Unit){
            return Response::errorResponse(__("manage_request.please select valid unit"));
        }

        $contract_sealing_date = $request->contract_sealing_date;

        $tenancy_end_date = Carbon::parse($contract_sealing_date)->addYears($request->number_years);
        $tenancy_end_date = Carbon::parse($tenancy_end_date)->subDay();
        $tenancy_end_date->format("Y-m-d");

        $annual_rent = $Unit->price * 12;

        //Rent payment cycle
        $rent_payment_cycle = RentPaymentCycle::find($request->rent_payment_cycle_id);
        if (!$rent_payment_cycle){
            return Response::errorResponse(__("manage_request.please select valid rent payment cycle"));
        }

        $RegularRentPayment = 0;

        if ($rent_payment_cycle->id == 1){
            $RegularRentPayment = $Unit->price;
        }elseif ($rent_payment_cycle->id == 2){
            $RegularRentPayment = $Unit->price * 3;
        }elseif ($rent_payment_cycle->id == 3){
            $RegularRentPayment = $Unit->price * 6;
        }elseif ($rent_payment_cycle->id == 4){
            $RegularRentPayment = $Unit->price * 12;
        }


        $data = [
            "tenancy_end_date" => $tenancy_end_date,
            "annual_rent" => $annual_rent,
            "regular_rent_payment" => $RegularRentPayment
        ];

        if ($Unit->purpose_property_id == 1){
            $data["security_deposit"] = $Unit->security_deposit;
        }

        return Response::successResponse($data,__("manage_request.annual rent calculation has been calculated success"));
    }

    public function ClacRegularRentPayment($request){
        $unit_id = $request->unit_id;
        $user_id = Auth::id();
        $Unit = Unit::whereHas("RealEstate", function ($q) use ($user_id){
            $q->where("user_id","!=",$user_id);
        })->whereDoesntHave("Requests",function ($q) use ($user_id,$unit_id){
            $q->where(function ($q){
                $q->where("request_states_id",2)->whereDate("tenancy_end_date",">=",Carbon::today()->toDateString());
            })->OrWhere(function ($q) use ($unit_id,$user_id){
                $q->where("unit_id",$unit_id)->where("user_id",$user_id)->whereDate("tenancy_end_date",">=",Carbon::today()->toDateString());
            });
        })->find($request->unit_id);

        if (!$Unit){
            return Response::errorResponse(__("manage_request.please select valid unit"));
        }

        $rent_payment_cycle = RentPaymentCycle::find($request->rent_payment_cycle_id);
        if (!$rent_payment_cycle){
            return Response::errorResponse(__("manage_request.please select valid rent payment cycle"));
        }

        $RegularRentPayment = 0;

        if ($rent_payment_cycle->id == 1){
            $RegularRentPayment = $Unit->price;
        }elseif ($rent_payment_cycle->id == 2){
            $RegularRentPayment = $Unit->price * 3;
        }elseif ($rent_payment_cycle->id == 3){
            $RegularRentPayment = $Unit->price * 6;
        }elseif ($rent_payment_cycle->id == 4){
            $RegularRentPayment = $Unit->price * 12;
        }

        return Response::successResponse(["regular_rent_payment" => $RegularRentPayment],__("manage_request.regular rent payment calculation has been calculated success"));

    }

    public function submitRequest($request){
        $unit_id = $request->unit_id;
        $user_id = Auth::id();
        $Unit = Unit::whereHas("RealEstate", function ($q) use ($user_id){
            $q->where("user_id","!=",$user_id);
        })->whereDoesntHave("Requests",function ($q) use ($user_id,$unit_id){
            $q->where(function ($q){
                $q->where("request_states_id",2)->whereDate("tenancy_end_date",">=",Carbon::today()->toDateString());
            });
//                ->OrWhere(function ($q) use ($unit_id,$user_id){
//                $q->where("unit_id",$unit_id)->where("user_id",$user_id)->whereDate("tenancy_end_date",">=",Carbon::today()->toDateString());
//            })
        })->find($request->unit_id);

        if (!$Unit){
            return Response::errorResponse(__("manage_request.please select valid unit"));
        }

        $rent_payment_cycle = RentPaymentCycle::find($request->rent_payment_cycle_id);
        if (!$rent_payment_cycle){
            return Response::errorResponse(__("manage_request.please select valid rent payment cycle"));
        }

        if ($Unit->purpose_property_id == 1){
            $contract_sealing_date = $request->contract_sealing_date;

            $tenancy_end_date = Carbon::parse($contract_sealing_date)->addYears($request->number_years);
            $tenancy_end_date->format("Y-m-d");
            $annual_rent = $Unit->price * 12;

            if ($rent_payment_cycle->id == 1){
                $RegularRentPayment = $Unit->price;
            }elseif ($rent_payment_cycle->id == 2){
                $RegularRentPayment = $Unit->price * 3;
            }elseif ($rent_payment_cycle->id == 3){
                $RegularRentPayment = $Unit->price * 6;
            }elseif ($rent_payment_cycle->id == 4){
                $RegularRentPayment = $Unit->price * 12;
            }

            $Request = Request::create([
                "user_id" => $user_id,
                "unit_id" => $Unit->id,
                "rent_payment_cycle_id" => $request->rent_payment_cycle_id,
                "request_states_id" => 1,
                "contract_sealing_date" => $request->contract_sealing_date,
                "number_years" => $request->number_years,
                "tenancy_end_date" => $tenancy_end_date,
                "annual_rent" => $annual_rent,
                "regular_rent_payment" => $RegularRentPayment
            ]);

            //Send Notification
            $UserNotified = $Unit->RealEstate->User;
            $User = Auth::user();
            $data = [
                "title_ar" => "ارسال طلب",
                "title_en" => "send request",
                "content_ar" => $User->name." قام بارسال طلب وحدة للاجار ",
                "content_en" => $User->name." sent a request to rent the unit",
                "code" => "U111"
            ];

            Notification::send($UserNotified,new ClientNotification($data));

            if ($UserNotified->fcm_token){
                $this->PushNotificationPerformRequest($UserNotified->fcm_token,"send request",$User->name." sent a request to rent the unit");
            }

            return  Response::successResponse($Request,__("manage_request.request has been sent success"));

        }else{ // in Sell Status
            return Response::successResponse([],"coming soon in sell");
        }
    }

    public function GetCountReceivedRequest(){
        $user_id = Auth::id();
        $CountRequests = Request::where("request_states_id",1)
            ->whereHas("Unit",function ($q) use ($user_id){
                $q->whereHas("RealEstate",function ($q) use ($user_id){
                    $q->where("user_id",$user_id);
                });
            })->get()->count();

        return Response::successResponse(["count_pending_requests" => $CountRequests],__("manage_request.Count pending requests has been fetched success"));
    }

    public function GetAllReceivedRequest(){
        $user_id = Auth::id();
        $Requests = Request::select("id","unit_id","user_id")->with(["User" => function($q){
            $q->select("id","name","email","phone");
        },"Unit" => function($q){
            $q->select("id","real_estate_id","purpose_property_id","price","unit_area","unit_number")->with(["RealEstate" => function($q){
                $q->select("id","building_type_id","building_type_use_id","national_address")->with(["media","BuildingType" => function($q){
                    $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
                },"BuildingTypeUse" => function($q){
                    $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
                }]);
            },"PurposeProperty" => function($q){
                $q->select("id","title_".LaravelLocalization::getCurrentLocale() ." as title");
            }]);
        }])
            ->whereIn("request_states_id",[1,4])
            ->whereHas("Unit",function ($q) use ($user_id){
                $q->whereHas("RealEstate",function ($q) use ($user_id){
                    $q->where("user_id",$user_id);
                });
            })->get();

        return Response::successResponse(ReceivedRequestsResource::collection($Requests),__("manage_request.Requests have been fetched success"));
    }

    public function ShowReceivedRequest($request_id){
        $user_id = Auth::id();
        $Request = Request::with(["User"=>function($q){
            $q->select("id","name","email","phone");
        },"RentPaymentCycle" => function($q){
            $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
        },"Unit" => function($q){
            $q->select("id","security_deposit");
        }])->whereIn("request_states_id",[1,4])
            ->whereHas("Unit",function ($q) use ($user_id){
                $q->whereHas("RealEstate",function ($q) use ($user_id){
                    $q->where("user_id",$user_id);
                });
            })->find($request_id);

        if (!$Request){
            return Response::errorResponse(__("manage_request.Please select valid request"));
        }

        return Response::successResponse(ShowReceivedRequestsResource::make($Request),__("manage_request.Request has been fetched success"));
    }

    public function ChangeRequestStatus($request){
        $user_id = Auth::id();

        $Request = Request::where("request_states_id",1)
            ->whereHas("Unit",function ($q) use ($user_id){
                $q->whereHas("RealEstate",function ($q) use ($user_id){
                    $q->where("user_id",$user_id);
                });
            })->find($request->request_id);

        if (!$Request){
            return Response::errorResponse(__("manage_request.you can't take action with this request"));
        }

        $UserNotified = $Request->User;
        $User = Auth::user();

        if ($request->status == 0){
            $Request = $Request->update([
                "request_states_id" => 3
            ]);

            //Send Notification
            $data = [
                "title_ar" => "رفض الطلب",
                "title_en" => "reject request",
                "content_ar" => $User->name." قام برفض طلب وحدة الاجار ",
                "content_en" => $User->name." reject a request to rent the unit",
                "code" => "U112"
            ];

            Notification::send($UserNotified,new ClientNotification($data));

            if ($UserNotified->fcm_token){
                $this->PushNotificationPerformRequest($UserNotified->fcm_token,"reject request",$User->name." reject a request to rent the unit");
            }

            return Response::successResponse($Request,__("manage_request.request has been rejected success"));

        }elseif ($request->status == 1){
            $unit_id = $Request->unit_id;
            $Request = $Request->update([
                "request_states_id" => 2
            ]);


            $Requests = Request::where("request_states_id",1)
                ->where("unit_id",$unit_id)->where("user_id","!=",$user_id)->get();

            foreach ($Requests as $request_x){
                $request_x->update([
                    "request_states_id" => 4
                ]);
            }

            // Create Invoice
            $this->CreatePaymentInvoice($request->request_id);

            //Create Contract
            Contract::create([
                "request_id" => $request->request_id,
                "contract_status_id" => 1
            ]);

            //Send Notification
            $data = [
                "title_ar" => "قبوال الطلب",
                "title_en" => "approve request",
                "content_ar" => $User->name." قام بقبوال طلب وحدة الاجار ",
                "content_en" => $User->name." approve a request to rent the unit",
                "code" => "U113"
            ];

            Notification::send($UserNotified,new ClientNotification($data));

            if ($UserNotified->fcm_token){
                $this->PushNotificationPerformRequest($UserNotified->fcm_token,"approve request",$User->name." approve a request to rent the unit");
            }

            //Send Notification Admin
            $Admins = Admin::all();
            Notification::send($Admins,new ClientNotification($data));
            $data = [
                "title" => "approve request",
                "content" => $User->name." approve a request to rent the unit",
                "code" => "U113"
            ];
            event(new AdminNotifyEvent($data));

            return Response::successResponse($Request,__("manage_request.request has been approved success"));
        }
    }

    private function CreatePaymentInvoice($request_id){
        $CountInvoices = DepositInvoice::where("request_id",$request_id)->get()->count();
        if($CountInvoices == 0){
            DepositInvoice::create([
                "request_id" => $request_id,
                "deposit_invoice_status_id" => 1,
                "deposit_price" => 300
            ]);
        }
    }

    public function ListAllRequestStatuses(){
        $Statuses = RequestStatus::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();
        return Response::successResponse($Statuses,__("manage_request.statuses have been fetched success"));
    }

    public function GetAllSentRequest($request){
        $user_id = Auth::id();

        $Requests = Request::select("id","unit_id","request_states_id")->with(["Unit" => function($q){
            $q->select("id","real_estate_id","purpose_property_id")->with(["RealEstate" => function($q){
                $q->select("id","building_type_id","building_type_use_id","national_address")->with(["media","BuildingType" => function($q){
                    $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
                },"BuildingTypeUse" => function($q){
                    $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
                }]);
            },"PurposeProperty" => function($q){
                $q->select("id","title_".LaravelLocalization::getCurrentLocale() ." as title");
            }]);
        },"RequestStatus"=>function($q){
            $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
        }])
            ->where("user_id",$user_id)
            ->where(function ($q) use ($request){
                if($request->status == 2){
                   $q->where("request_states_id",$request->status)->whereHas("DepositInvoice",function ($q){
                       $q->where("deposit_invoice_status_id",1);
                   });
                }elseif($request->status != 0){
                    $q->where("request_states_id",$request->status);
                }
            })
            ->whereHas("Unit",function ($q){
                $q->whereHas("RealEstate");
            })->orderBy("id","DESC")->paginate(10);


        return Response::successResponse(SentRequestPaginateResources::make($Requests),__("manage_request.Sent requests have been fetched success"));
    }

    public function showDepositInvoice($request){
        $user_id = Auth::id();
        $Request = Request::select("id","unit_id","user_id")->with(["Unit" => function($q){
            $q->select("id","real_estate_id")->with(["RealEstate" => function($q){
                $q->select("id","building_type_id","national_address")->with(["media","BuildingType"=>function($q){
                    $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
                }]);
            }]);
        },"DepositInvoice"])
            ->where("user_id",$user_id)
            ->where("request_states_id",2)
            ->whereHas("Unit",function ($q){
                $q->whereHas("RealEstate");
            })->whereHas("DepositInvoice",function ($q){
                $q->where("deposit_invoice_status_id",1);
            })->find($request->request_id);

        if (!$Request){
            return Response::errorResponse(__("manage_request.no invoice for this request for pay"));
        }

        return Response::successResponse(ShowDepositInvoiceResource::make($Request),__("manage_request.Deposit Invoice has been fetched success"));
    }

    public function CancelPaymentInvoice($request){
        $user_id = Auth::id();
        $PaymentInvoice = DepositInvoice::with("Request")
            ->whereHas("Request",function ($q) use ($user_id){
            $q->where("user_id",$user_id)
                ->where("request_states_id",2);
        })->where("deposit_invoice_status_id",1)
            ->find($request->deposit_invoice_id);


        if (!$PaymentInvoice){
            return Response::errorResponse(__("manage_request.No deposit invoice for cancel"));
        }

        $Unit_id = $PaymentInvoice["Request"]->unit_id;
        $Request_id = $PaymentInvoice["Request"]->id;
        $Contract = $PaymentInvoice["Request"]->Contract;

        $Request = Request::find($Request_id);
        $Request->update([
            "request_states_id" => 3
        ]);

        //Cancel contract
        $Contract->contract_status_id = 4;
        $Contract->save();

        $PaymentInvoice->update([
            "deposit_invoice_status_id" => 3
        ]);

        $HoldingRequests = Request::where("unit_id",$Unit_id)
            ->where("request_states_id",4)->get();

        foreach ($HoldingRequests as $holdingRequest){
            $holdingRequest->request_states_id = 1;
            $holdingRequest->save();
        }

        //Send Notification
        $UserNotified = $Request->Unit->RealEstate->User;
        $User = Auth::user();
        $data = [
            "title_ar" => "الغاء الطلب",
            "title_en" => "cancel request",
            "content_ar" => $User->name." قام بالغاء طلب وحدة الاجار ",
            "content_en" => $User->name." cancel a request to rent the unit",
            "code" => "U114"
        ];

        Notification::send($UserNotified,new ClientNotification($data));

        if ($UserNotified->fcm_token){
            $this->PushNotificationPerformRequest($UserNotified->fcm_token,"cancel request",$User->name." cancel a request to rent the unit");
        }

        //Send Notification Admin
        $Admins = Admin::all();
        Notification::send($Admins,new ClientNotification($data));
        $data = [
            "title" => "cancel request",
            "content" => $User->name." cancel a request to rent the unit",
            "code" => "U114"
        ];
        event(new AdminNotifyEvent($data));


        return Response::successResponse([],__("manage_request.deposit payment invoice has been canceled"));
    }

    public function PayPaymentInvoice($request){
        $user_id = Auth::id();
        $PaymentInvoice = DepositInvoice::with("Request")
            ->whereHas("Request",function ($q) use ($user_id){
                $q->where("user_id",$user_id)
                    ->where("request_states_id",2);
            })->where("deposit_invoice_status_id",1)
            ->find($request->deposit_invoice_id);


        if (!$PaymentInvoice){
            return Response::errorResponse(__("manage_request.No deposit invoice for pay"));
        }

        $Unit_id = $PaymentInvoice["Request"]->unit_id;
        $Request_id = $PaymentInvoice["Request"]->id;
        $Contract = $PaymentInvoice["Request"]->Contract;

        $PaymentInvoice->update([
            "deposit_invoice_status_id" => 2
        ]);

        //Cancel contract
        $Contract->contract_status_id = 2;
        $Contract->save();

        $HoldingRequests = Request::where("unit_id",$Unit_id)
            ->where("request_states_id",4)->get();

        foreach ($HoldingRequests as $holdingRequest){
            $holdingRequest->request_states_id = 3;
            $holdingRequest->save();
        }

        //Send Notification
        $Request = Request::find($Request_id);
        $UserNotified = $Request->Unit->RealEstate->User;
        $User = Auth::user();
        $data = [
            "title_ar" => "دفع تكلفة التوثيق",
            "title_en" => "Pay the cost of documentation",
            "content_ar" => $User->name." قام بدفع تكلفة توثيق العقد ",
            "content_en" => $User->name." paid the cost of documenting the contract",
            "code" => "U115"
        ];

        Notification::send($UserNotified,new ClientNotification($data));

        if ($UserNotified->fcm_token){
            $this->PushNotificationPerformRequest($UserNotified->fcm_token,"Pay the cost of documentation",$User->name." paid the cost of documenting the contract");
        }

        //Send Notification Admin
        $Admins = Admin::all();
        Notification::send($Admins,new ClientNotification($data));
        $data = [
            "title" => "Pay the cost of documentation",
            "content" => $User->name." paid the cost of documenting the contract",
            "code" => "U115"
        ];
        event(new AdminNotifyEvent($data));

        return Response::successResponse([],__("manage_request.deposit payment invoice has been payed success"));
    }

}
