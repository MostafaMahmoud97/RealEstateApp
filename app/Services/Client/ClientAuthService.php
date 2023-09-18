<?php


namespace App\Services\Client;


use App\Models\EmailVerificationClient;
use App\Models\PasswordReset;
use App\Models\TypeIdentity;
use App\Models\User;
use App\Notifications\Client\VerifyEmailNotify;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ClientAuthService
{
    public function login($request){
        $validator = Validator::make($request->all(), [
            'client_identity' => 'required',
            'password' => 'required|min:6'
        ],[
            "client_identity.required" => __("auth.client identity is required"),
            "password.required" => __("auth.the password is required"),
            "password.min" => __("auth.The minimum password length is 6 characters"),
        ]);

        if ($validator->fails()) {
            return Response::errorResponse($validator->errors()->first());
        }

        $user = $this->checkLogin($request->client_identity,$request->password);
        if ($user) {
            auth()->setUser($user);

            $token = Auth::user()->createToken('passport_token')->accessToken;
            $user = Auth::user();


            if($user->is_active == 0){
                return Response::errorResponse(__("auth.you can't login"));
            }

            $data = ['user' => $user, 'token' => $token];
            return Response::successResponse($data);
        } else {
            return Response::errorResponse(__('auth.email,phone number or password incorrect'));
        }
    }

    private function checkLogin($admin_identity,$password){
        $user = User::where('email',$admin_identity)->OrWhere('phone',$admin_identity)->first();
        if($user&&Hash::check($password, $user->password)){
            return $user;
        }else{
            return null;
        }
    }

    public function getTypeIdentities(){
        $TypeIdentities = TypeIdentity::select("id",LaravelLocalization::getCurrentLocale()."_title")->get();
        return Response::successResponse($TypeIdentities,__("client.Type identities have been fetched"));
    }

    public function registerClient($request){
        $User = User::create([
            "type_identities_id" => $request->type_id,
            "name" => $request->name,
            "nationality" => $request->nationality,
            "id_number" => $request->id_number,
            "phone" => $request->phone,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        auth()->setUser($User);

        $token = Auth::user()->createToken('passport_token')->accessToken;
        $user = Auth::user();

        $data = ['user' => $user, 'token' => $token];
        $this->verifyEmailAfterRegister($user);

        return Response::successResponse($data,__("auth.Client has been registered success"));
    }

    protected function verifyEmailAfterRegister($user){
        $token = random_int(1000, 9999);
        $expire = Carbon::now()->addMinutes(2);
        $expire = $expire->toDateTimeString();

        EmailVerificationClient::create([
            "user_id" => $user->id,
            "token_number" => $token,
            "expired" => $expire
        ]);

        $user->notify(new VerifyEmailNotify($token,$user->name));
    }

    public function resendVerifyToken(){
        $user = Auth::user();
        $user_id = Auth::id();
        $expire_now = Carbon::now();
        $expire_now = $expire_now->toDateTimeString();

        $EmailVerificationCode = EmailVerificationClient::where("user_id",$user_id)->where("expired",'>',$expire_now)->first();
        if ($EmailVerificationCode){
            return Response::successResponse([],__("auth.The token has already been sent to you"));
        }


        $token = random_int(1000, 9999);
        $expire = Carbon::now()->addMinutes(2);
        $expire = $expire->toDateTimeString();

        EmailVerificationClient::create([
            "user_id" => $user_id,
            "token_number" => $token,
            "expired" => $expire
        ]);

        $user->notify(new VerifyEmailNotify($token,$user->name));

        return Response::successResponse([],__("auth.The token has been sent successfully"));
    }

    public function sendTokenToVerifyEmail($request){
        $user = Auth::user();
        $expire_now = Carbon::now();
        $expire_now = $expire_now->toDateTimeString();
        $EmailVerificationCode = EmailVerificationClient::where("user_id",$user['id'])
            ->where("expired",'>',$expire_now)
            ->where("token_number",$request->token)->first();

        if (!$EmailVerificationCode){
            return Response::errorResponse(__("auth.This code is invalid or the grace period for this code has expired"));
        }

        $user['email_verified_at'] = $expire_now;
        $user->save();

        return Response::successResponse($user,__("auth.email has been verified success"));
    }

    public function forgotPassword($request){
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if($status == Password::RESET_LINK_SENT){
            return Response::successResponse([],__("auth.The token has been sent successfully"));
        }

        if ($status == Password::RESET_THROTTLED){
            return Response::errorResponse(__("auth.throttled reset attempt"),[],320);
        }elseif ($status == Password::INVALID_USER){
            return Response::errorResponse(__("auth.Invalid email"),[],310);
        }

        return Response::errorResponse($status,[],310);
    }

    public function sendForgotPasswordToken($request){
        $request->validate([
            'token' => 'required',
        ]);

        $PasswordRest = PasswordReset::where("token",$request->token)->first();
        if (!$PasswordRest){
            return Response::errorResponse(__("auth.token is incorrect| try again"));
        }

        return Response::successResponse(["token" => $request->token],__("auth.token has been successfully"));
    }

    public function change_password($request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        $PasswordRest = PasswordReset::where("email",$request->email)->where("token",$request->token)->first();
        if (!$PasswordRest){
            return Response::errorResponse(__("auth.token is incorrect| try again"));
        }

        $user = Captain::where("email",$request->email)->first();

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60)
        ])->save();

        return Response::successResponse([],"password reset successfully");

    }
}
