<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "title_en",
        "title_ar"
    ];
    protected $hidden = [
        "created_at",
        "updated_at"
    ];

}
