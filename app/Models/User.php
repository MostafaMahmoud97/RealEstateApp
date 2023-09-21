<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\Client\ForgetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;


class User extends Authenticatable implements MustVerifyEmail
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "id",
        "type_identities_id",
        "name",
        "nationality",
        "id_number",
        "phone",
        "is_active",
        "email",
        "password"
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

    public function EmailVerifications(){
        return $this->hasMany(EmailVerificationClient::class,"user_id","id");
    }

    public function TypeIdentity(){
        return $this->hasOne(TypeIdentity::class,"type_identities_id","id");
    }

    public function CommercialActivities(){
        return $this->hasMany(CommercialActivities::class,"user_id","id");
    }

    public function RealEstates(){
        return $this->hasMany(RealEstate::class,"user_id","id");
    }

    public function Units(){
        return $this->hasMany(Unit::class,"beneficiary_id","id");
    }

    public function sendPasswordResetNotification($token)
    {
        $token = mt_rand(1000, 9999);
        $email = $this->email;
        $PasswordRest = PasswordReset::where("email",$email)->first();
        if($PasswordRest){
            $PasswordRest->delete();
        }
        PasswordReset::create([
            "email" => $email,
            "token" => $token
        ]);

        $name = $this->name;
        $this->notify(new ForgetPasswordNotification($token,$name));
    }
}
