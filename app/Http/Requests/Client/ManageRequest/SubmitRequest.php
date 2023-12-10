<?php

namespace App\Http\Requests\Client\ManageRequest;

use Illuminate\Foundation\Http\FormRequest;

class SubmitRequest extends FormRequest
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
            "unit_id" => "required|integer",
            "contract_sealing_date" => "required|date_format:Y-m-d",
            "number_years" => "required|integer|gt:0|lt:15",
        ];
    }

    public function messages()
    {
        return [
            "unit_id.required" => __("manage_request.you must send unit_id"),
            "unit_id.integer" => __("manage_request.you must send unit_id as integer value"),
            "contract_sealing_date.required" => __("manage_request.you must send contract sealing date"),
            "contract_sealing_date.date_format" => __("manage_request.contract sealing date format is YYYY-mm-dd"),
            "number_years.required" => __("manage_request.you must send number of years"),
            "number_years.integer" => __("manage_request.you must send number of years as integer"),
            "number_years.gt" => __("manage_request.you must send number of years greater than zero"),
        ];
    }
}
