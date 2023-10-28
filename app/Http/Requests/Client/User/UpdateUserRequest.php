<?php

namespace App\Http\Requests\Client\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
        $user_id = Auth::id();
        return [
            "type_identities_id" => "required|numeric",
            "name" => "required|string",
            "nationality_id" => "required|numeric",
            "id_number" => "required|numeric",
            "phone" => "required|string|unique:users,phone,".$user_id,
            "email" => "required|email|unique:users,email,".$user_id,
        ];
    }

    public function messages()
    {
        return [
            "type_identities_id.required" => __("client.you must choose type id"),
            "type_identities_id.numeric"=> __("client.you must enter number in type id"),
            "name.required"=> __("client.you must enter full name"),
            "name.string" => __("client.you must enter string in full name"),
            "nationality_id.required" => __("client.you must enter nationality"),
            "nationality_id.numeric" => __("client.you must enter number in nationality"),
            "id_number.required" => __("client.you must enter id number"),
            "id_number.numeric"  => __("client.you must enter number in id number"),
            "phone.required" => __("client.you must enter phone number"),
            "phone.string" => __("client.you must enter string in phone number"),
            "phone.unique" => __("client.This mobile number is already in use"),
            "email.required" => __("client.you must enter email"),
            "email.email" => __("client.you must enter valid email with @ sign"),
            "email.unique" => __("client.This email is already in use"),
        ];
    }
}
