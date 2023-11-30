<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "user_one_id",
        "user_two_id"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];
}
