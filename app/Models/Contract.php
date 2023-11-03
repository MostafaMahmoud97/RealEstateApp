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
}
