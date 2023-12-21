<?php

namespace App\Http\Requests\Admin\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
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
            "name" => "required|string",
            "phone" => "required|string|unique:admins,phone",
            "email" => "required|email|unique:admins,email",
            "password" => "required|confirmed|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/",
            "job_title" => "required|string",
            "logo" => "required|mimes:jpg,png,jpeg|max:2048"
        ];
    }

    public function messages()
    {
        return [
            "name.required"=> __("employee.you must enter full name"),
            "name.string" => __("employee.you must enter string in full name"),
            "phone.required" => __("employee.you must enter phone number"),
            "phone.string" => __("employee.you must enter string in phone number"),
            "phone.unique" => __("employee.This mobile number is already in use"),
            "email.required" => __("employee.you must enter email"),
            "email.email" => __("employee.you must enter valid email with @ sign"),
            "email.unique" => __("employee.This email is already in use"),
            "password.required" => __("employee.you must enter password"),
            "password.confirmed" => __("employee.password confirmation not match with password"),
            "password.min" => __("employee.you must enter min:8 characters in password"),
            "job_title.required" => __("employee.you must enter job title"),
            "job_title.string" => __("employee.you must enter job title as string"),
            "logo.required" => __("employee.you must choose logo image"),
            "logo.mimes" => __("employee.you must choose logo image as jpg,png,jpeg"),
        ];
    }
}
