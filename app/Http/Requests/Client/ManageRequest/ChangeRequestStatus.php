<?php

namespace App\Http\Requests\Client\ManageRequest;

use Illuminate\Foundation\Http\FormRequest;

class ChangeRequestStatus extends FormRequest
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
            "request_id" => "required|integer",
            "status" => "required|in:1,2"
        ];
    }

    public function messages()
    {
        return [
            "request_id.required" => __("manage_request.you must send request id"),
            "request_id.integer" => __("manage_request.you must send request id as integer"),
            "status.required" => __("manage_request.you must send status"),
            "status.in" => __("manage_request.you must send status as zero or one"),
        ];
    }
}
