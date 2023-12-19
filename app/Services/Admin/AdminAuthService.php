<?php


namespace App\Services\Admin;


use App\Models\Admin;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminAuthService
{
    public function login($request){
        $validator = Validator::make($request->all(), [
            'admin_identity' => 'required',
            'password' => 'required|min:6'
        ],[
            "admin_identity.required" => __("auth.admin identity is required"),
            "password.required" => __("auth.the password is required"),
            "password.min" => __("auth.The minimum password length is 6 characters"),
        ]);

        if ($validator->fails()) {
            return Response::errorResponse($validator->errors()->first());
        }

        $user = $this->checkLogin($request->admin_identity,$request->password);
        if ($user) {
            auth('admin-api')->setUser($user);

            $token = Auth::guard('admin-api')->user()->createToken('passport_token',["admin"])->accessToken;
            $user = Auth::guard('admin-api')->user();

            $media = $user->media;
            if ($media != null){
                $user->logo = $media->file_path;
            }else{
                $user->logo = "";
            }

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
        $user = Admin::where('email',$admin_identity)->OrWhere('phone',$admin_identity)->first();
        if($user&&Hash::check($password, $user->password)){
            return $user;
        }else{
            return null;
        }
    }

    public function logout(){
        $user = Auth::guard('admin-api')->user()->token();
        $user->revoke();
        return Response::successResponse([],__("auth.logout success"));
    }

    public function forgot_password(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::broker("admins")
            ->sendResetLink($request->only('email'));

        if($status == Password::RESET_LINK_SENT){
            return Response::successResponse([],__("auth.The token has been sent successfully"));
        }

        if ($status == Password::RESET_THROTTLED){
            return Response::errorResponse(__('auth.reset message is sent to mail'));
        }elseif ($status == Password::INVALID_USER){
            return Response::errorResponse(__('auth.this user not found'));
        }

        return Response::errorResponse($status);
    }

    public function change_password(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6'
        ],[
            "token.required" => __("auth.token has been required"),
            "email.required" => __("auth.email has been required"),
            "email.email" => __("auth.The email must be valid and contain @"),
            "password.required" => __("auth.the password is required"),
            "password.min" => __("auth.The minimum password length is 6 characters"),
            "password.confirmed" => __("auth.the confirmation password doesn't match with password"),
        ]);

        $status = Password::broker("admins")->reset(
            $request->only('email','password','password_confirmation','token'),
            function ($user) use ($request){
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60)
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET){
            return Response::successResponse([],__("auth.password reset successfully"));
        }

        return Response::errorResponse($status,[],500);
    }
}
