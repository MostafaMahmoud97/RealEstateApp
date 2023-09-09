<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RealEstate extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "id",
        "user_id",
        "building_type_id",
        "building_type_use_id",
        "national_address",
        "lat",
        "lon",
        "number_floors",
        "number_units",
        "number_parking_lots"
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    public function User(){
        return $this->belongsTo(User::class,"user_id","id");
    }

    public function BuildingType(){
        return $this->belongsTo(BuildingType::class,"building_type_id","id");
    }

    public function BuildingTypeUse(){
        return $this->belongsTo(BuildingTypeUse::class,"building_type_use_id","id");
    }

    public function Units(){
        return $this->hasMany(Unit::class,"real_estate_id","id");
    }

    public function media(){
        return $this->morphMany(Media::class,"mediable");
    }
}
