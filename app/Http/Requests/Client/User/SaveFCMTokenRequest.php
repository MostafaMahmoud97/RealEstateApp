<?php

namespace App\Http\Requests\Client\User;

use Illuminate\Foundation\Http\FormRequest;

class SaveFCMTokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "fcm_token" => "required",
            "platform" => "required|in:android,ios"
        ];
    }

    public function messages()
    {
        return [
            "fcm_token.required" => __("auth.FCMToken is required"),
            "platform.required" => __("auth.Platform is required"),
            "platform.in" => __("auth.Platform must be android or ios"),
        ];
    }
}
