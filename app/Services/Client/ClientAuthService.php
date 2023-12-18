<?php


namespace App\Services\Client;


use App\Http\Resources\Client\User\ShowUserResource;
use App\Models\EmailVerificationClient;
use App\Models\Nationality;
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

    public function getHelpData(){
        $TypeIdentities = TypeIdentity::select("id",LaravelLocalization::getCurrentLocale()."_title as title")->get();
        $Nationality = Nationality::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();

        return Response::successResponse(["type_identities" => $TypeIdentities,"Nationalities" => $Nationality],__("client.Help data has been fetched"));
    }

    public function registerClient($request){
        $User = User::create([
            "type_identities_id" => $request->type_id,
            "name" => $request->name,
            "nationality_id" => $request->nationality_id,
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

    public function show(){
        $user_id = Auth::id();
        $User = User::with(["TypeIdentity" => function($q){
            $q->select("id",LaravelLocalization::getCurrentLocale()."_title as title");
        },"Nationality" => function($q){
            $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
        }])->find($user_id);


        return Response::successResponse(ShowUserResource::make($User),__("auth.user data has been fetched success"));
    }

    public function update($request){
        $User_id = Auth::id();
        $User = User::find($User_id);
        $User->update($request->all());

        return Response::successResponse($User,__("auth.user has been updated"));
    }

    public function resetPassword($request){
        $user_id = Auth::id();
        $user = User::find($user_id);

        if (!Hash::check($request->old_password, $user->password)){
            return Response::errorResponse(__("auth.old password is invalid"));
        }

        $user->update([
            "password" => Hash::make($request->password)
        ]);

        return Response::successResponse($user,__("auth.password has been changed success"));
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
            return Response::errorResponse(__('auth.reset message is sent to mail'));
        }elseif ($status == Password::INVALID_USER){
            return Response::errorResponse(__('auth.this user not found'));
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
            'password' => 'required|confirmed|min:8'
        ],[
            "token.required" => __("auth.token has been required"),
            "email.required" => __("auth.email has been required"),
            "email.email" => __("auth.The email must be valid and contain @"),
            "password.required" => __("auth.the password is required"),
            "password.min" => __("auth.The minimum password length is 8 characters"),
            "password.confirmed" => __("auth.the confirmation password doesn't match with password"),
        ]);

        $PasswordRest = PasswordReset::where("email",$request->email)->where("token",$request->token)->first();
        if (!$PasswordRest){
            return Response::errorResponse(__("auth.token is incorrect| try again"));
        }

        $user = User::where("email",$request->email)->first();

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60)
        ])->save();

        return Response::successResponse([],__("auth.password reset successfully"));

    }

    public function saveFCMToken($request){
        $user = Auth::user();

        $user->update([
            "fcm_token" => $request->fcm_token,
            "platform" => $request->platform
        ]);

        return Response::successResponse($user,__("auth.FCMToken has been updated success"));
    }
}
