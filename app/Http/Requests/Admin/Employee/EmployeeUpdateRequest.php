<?php

namespace App\Http\Requests\Admin\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
            "phone" => "required|string|unique:admins,phone,".$this->id,
            "email" => "required|email|unique:admins,email,".$this->id,
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
        ];
    }
}
