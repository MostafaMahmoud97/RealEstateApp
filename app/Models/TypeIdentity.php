<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeIdentity extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "en_title",
        "ar_title"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];
}
