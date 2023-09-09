<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommercialInfo extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "id",
        "unit_id",
        "unit_length",
        "unit_direction",
        "number_parking_lots",
        "sign_area",
        "sign_location",
        "special_sign_specification",
        "insurance_policy_number",
        "mezzanine",
        "unit_finishing"
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    public function Unit(){
        return $this->belongsTo(Unit::class,"unit_id","id");
    }
}
