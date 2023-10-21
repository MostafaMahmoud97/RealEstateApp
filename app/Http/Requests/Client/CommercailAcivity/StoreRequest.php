<?php

namespace App\Http\Requests\Client\CommercailAcivity;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            "company_name" => "required|string",
            "organization_type" => "required|string",
            "cr_number" => "required|numeric",
            "cr_date" => "required|date_format:Y-m-d",
            "unified_number" => "required|numeric",
            "issued_by" => "string|nullable",
            "licence_number" => "numeric|nullable",
            "licence_issue_place" => "string|nullable",
            "modify_business" => "required|boolean",
        ];
    }

    public function messages()
    {
        return [
            "company_name.required" => __("commercial_activity_client.you must enter company name"),
            "company_name.string" => __("commercial_activity_client.company name must be string"),
            "organization_type.required" => __("commercial_activity_client.you must enter organization type"),
            "organization_type.string" => __("commercial_activity_client.organization type must be string"),
            "cr_number.required" => __("commercial_activity_client.you must enter cr_number"),
            "cr_number.numeric" => __("commercial_activity_client.cr_number must be numeric"),
            "cr_date.required" => __("commercial_activity_client.you must enter cr_date"),
            "cr_date.date_format" => __("commercial_activity_client.cr_date must be with date format yyyy-mm-dd"),
            "unified_number.required" => __("commercial_activity_client.you must enter unified number"),
            "unified_number.numeric" => __("commercial_activity_client.unified number must be numeric"),
            "issued_by.string" => __("commercial_activity_client.issued_by must be string"),
            "licence_number.numeric" => __("commercial_activity_client.licence number must be numeric"),
            "licence_issue_place.string" => __("commercial_activity_client.licence issue place must be string"),
            "modify_business.required" => __("commercial_activity_client.you must choose modify business type"),
            "modify_business.boolean" => __("commercial_activity_client.modify business type must be true or false, 0 or 1"),
        ];
    }
}
