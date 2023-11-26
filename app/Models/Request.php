<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "user_id",
        "unit_id",
        "rent_payment_cycle_id",
        "request_states_id",
        "contract_sealing_date",
        "number_years",
        "tenancy_end_date",
        "annual_rent",
        "regular_rent_payment"
    ];

    protected $hidden =[
        "updated_at"
    ];

    public function Unit(){
        return $this->belongsTo(Unit::class,"unit_id","id");
    }

    public function User(){
        return $this->belongsTo(User::class,"user_id","id");
    }

    public function RentPaymentCycle(){
        return $this->belongsTo(RentPaymentCycle::class,"rent_payment_cycle_id","id");
    }

    public function RequestStatus(){
        return $this->belongsTo(RequestStatus::class,"request_states_id","id");
    }

    public function DepositInvoice(){
        return $this->hasOne(DepositInvoice::class,"request_id","id");
    }

    public function Contract(){
        return $this->hasOne(Contract::class,"request_id","id");
    }
}
