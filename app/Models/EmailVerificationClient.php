<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailVerificationClient extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "user_id",
        "token_number",
        "expired"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function User(){
        return $this->belongsTo(User::class,"user_id","id");
    }
}
