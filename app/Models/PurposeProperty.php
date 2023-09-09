<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurposeProperty extends Model
{
    use HasFactory;

    protected $fillable =[
        "id",
        "title_ar",
        "title_en"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];
}
