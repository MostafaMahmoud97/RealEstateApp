<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory,Notifiable,HasApiTokens;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'is_active',
        'job_title'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function sendPasswordResetNotification($token)
    {
        $url = "localhost:8000/reset?token=".$token.'&email='.$this->email;
        $this->notify(new ResetPasswordNotification($url,$this->name));
    }

    public function media(){
        return $this->morphMany(Media::class,"mediable");
    }

}
