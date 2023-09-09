<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "id",
        "real_estate_id",
        "beneficiary_id",
        "purpose_property_id",
        "unit_status_id",
        "price",
        "unit_type",
        "unit_number",
        "floor_number",
        "unit_area",
        "furnished",
        "composite_kitchen_cabinets",
        "ac_type",
        "num_ac_units",
        "electricity_meter_number",
        "electricity_meter_reading",
        "gas_meter_number",
        "gas_meter_reading",
        "water_meter_number",
        "water_meter_reading",
        "description",
        "is_publish"
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    public function RealEstate(){
        return $this->belongsTo(RealEstate::class,"real_estate_id","id");
    }

    public function Beneficiary(){
        return $this->belongsTo(User::class,"beneficiary_id","id");
    }

    public function PurposeProperty(){
        return $this->belongsTo(PurposeProperty::class,"purpose_property_id","id");
    }

    public function UnitStatus(){
        return $this->belongsTo(UnitStatus::class,"unit_status_id","id");
    }

    public function CommercialInfo(){
        return $this->hasOne(CommercialInfo::class,"unit_id","id");
    }

    public function media(){
        return $this->morphMany(Media::class,"mediable");
    }
}
