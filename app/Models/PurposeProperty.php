<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurposeProperty extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =[
        "id",
        "title_ar",
        "title_en"
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];
}
