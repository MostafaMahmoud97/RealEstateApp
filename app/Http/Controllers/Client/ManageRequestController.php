<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ManageRequest\CalcAnnualRentRequest;
use App\Http\Requests\Client\ManageRequest\ChangeRequestStatus;
use App\Http\Requests\Client\ManageRequest\SubmitRequest;
use App\Services\Client\ManageRequestService;
use Illuminate\Http\Request;

class ManageRequestController extends Controller
{
    protected $service;
    public function __construct(ManageRequestService $service)
    {
        $this->service = $service;
    }

    public function ClickSendRequest($unit_id){
        return $this->service->ClickSendRequest($unit_id);
    }

    public function CalcAnnualRent(CalcAnnualRentRequest $request){
        return $this->service->CalcAnnualRent($request);
    }

    public function CalcRegularRentPayment(Request $request){
        return $this->service->ClacRegularRentPayment($request);
    }

    public function SubmitRequest(SubmitRequest $request){
        return $this->service->submitRequest($request);
    }

    public function GetCountReceivedRequest(){
        return $this->service->GetCountReceivedRequest();
    }

    public function GetAllReceivedRequest(){
        return $this->service->GetAllReceivedRequest();
    }

    public function ShowReceivedRequest($request_id){
        return $this->service->ShowReceivedRequest($request_id);
    }

    public function ChangeRequestStatus(ChangeRequestStatus $request){
        return $this->service->ChangeRequestStatus($request);
    }

    public function ListAllRequestStatuses(){
        return $this->service->ListAllRequestStatuses();
    }

    public function GetSentRequests(Request $request){
        return $this->service->GetAllSentRequest($request);
    }

    public function showDepositInvoice(Request $request){
        return $this->service->showDepositInvoice($request);
    }

    public function CancelPaymentInvoice(Request $request){
        return $this->service->CancelPaymentInvoice($request);
    }

    public function PayPaymentInvoice(Request $request){
        return $this->service->PayPaymentInvoice($request);
    }
}
