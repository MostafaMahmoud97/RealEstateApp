<?php

namespace App\Http\Requests\Admin\Client;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
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
            "type_id" => "required|numeric|in:1,2,3",
            "name" => "required|string",
            "nationality" => "required|string",
            "id_number" => "required|numeric",
            "phone" => "required|string|unique:users,phone",
            "email" => "required|email|unique:users,email",
            "password" => "required|confirmed|min:6"
        ];
    }

    public function messages()
    {
        return [
            "type_id.required" => __("client.you must choose type id"),
            "type_id.numeric"=> __("client.you must enter number in type id"),
            "type_id.in"=> __("client.you must enter number in type id as 1,2,3"),
            "name.required"=> __("client.you must enter full name"),
            "name.string" => __("client.you must enter string in full name"),
            "nationality.required" => __("client.you must enter nationality"),
            "nationality.string" => __("client.you must enter string in nationality"),
            "id_number.required" => __("client.you must enter id number"),
            "id_number.numeric"  => __("client.you must enter number in id number"),
            "phone.required" => __("client.you must enter phone number"),
            "phone.string" => __("client.you must enter string in phone number"),
            "phone.unique" => __("client.This mobile number is already in use"),
            "email.required" => __("client.you must enter email"),
            "email.email" => __("client.you must enter valid email with @ sign"),
            "email.unique" => __("client.This email is already in use"),
            "password.required" => __("client.you must enter password"),
            "password.confirmed" => __("client.password confirmation not match with password"),
            "password.min" => __("client.you must enter min:6 characters in password"),
        ];
    }
}
