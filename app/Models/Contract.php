<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "request_id",
        "contract_status_id"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function Request(){
        return $this->belongsTo(Request::class,"request_id","id");
    }

    public function ContractStatus(){
        return $this->belongsTo(ContractStatus::class,"contract_status_id","id");
    }
}
