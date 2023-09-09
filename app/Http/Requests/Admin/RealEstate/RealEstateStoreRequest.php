<?php

namespace App\Http\Requests\Admin\RealEstate;

use Illuminate\Foundation\Http\FormRequest;

class RealEstateStoreRequest extends FormRequest
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
            "user_id" => "required|numeric",
            "building_type_id" => "required|numeric|in:1,2,3,4,5,6,7,8,9",
            "building_type_use_id" => "required|numeric|in:1,2",
            "national_address" => "required|string",
            "lat" => "required|numeric",
            "lon" => "required|numeric",
            "number_floors" => "numeric|nullable",
            "number_units" => "numeric|nullable",
            "number_parking_lots" => "numeric|nullable",
            "cover_real_estate" => "required|mimes:jpg,png,jpeg|max:2048",
            "units" => "required|array|min:1",
            "units.*.purpose_property_id" => "required|numeric|in:1,2",
            "units.*.price" => "required|numeric",
            "units.*.unit_type" => "required|string",
            "units.*.unit_number" => "required|string",
            "units.*.floor_number" => "numeric|nullable",
            "units.*.unit_area" => "required|numeric",
            "units.*.furnished" => "string|nullable",
            "units.*.composite_kitchen_cabinets" => "boolean|nullable",
            "units.*.ac_type" => "string|nullable",
            "units.*.num_ac_units" => "numeric|nullable",
            "units.*.electricity_meter_number" => "numeric|nullable",
            "units.*.electricity_meter_reading" => "numeric|nullable",
            "units.*.gas_meter_number" => "numeric|nullable",
            "units.*.gas_meter_reading" => "numeric|nullable",
            "units.*.water_meter_number" => "numeric|nullable",
            "units.*.water_meter_reading" => "numeric|nullable",
            "units.*.description" => "string|nullable",
            "units.*.is_publish" => "required|boolean|nullable",
            "units.*.media" => "required|array|min:1",
            "units.*.media.*" => "max:2048",
            "units.*.unit_length" => "numeric|nullable",
            "units.*.unit_direction" => "string|nullable",
            "units.*.number_parking_lots" => "numeric|nullable",
            "units.*.sign_area" => "numeric|nullable",
            "units.*.sign_location" => "string|nullable",
            "units.*.special_sign_specification" => "string|nullable",
            "units.*.insurance_policy_number" => "numeric|nullable",
            "units.*.mezzanine" => "boolean|nullable",
            "units.*.unit_finishing" => "boolean|nullable",
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
