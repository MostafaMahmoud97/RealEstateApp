<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "request_id",
        "deposit_invoice_status_id",
        "deposit_price"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function Request(){
        return $this->belongsTo(Request::class,"request_id","id");
    }

    public function InvoiceStatus(){
        return $this->belongsTo(DepositInvoiceStatus::class,"deposit_invoice_status_id","id");
    }
}
