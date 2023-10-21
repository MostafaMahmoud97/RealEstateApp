<?php

namespace App\Http\Requests\Client\RealEstate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnit extends FormRequest
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
            "building_type_use_id" => "required|numeric|in:1,2",
            "purpose_property_id" => "required|numeric|in:1,2",
            "price" => "required|numeric",
            "security_deposit" => "required_if:purpose_property_id,1|numeric",
            "unit_type" => "required|string",
            "unit_number" => "required|string",
            "floor_number" => "numeric|nullable",
            "unit_area" => "required|numeric",
            "furnished" => "string|nullable",
            "composite_kitchen_cabinets" => "boolean|nullable",
            "ac_type" => "string|nullable",
            "num_ac_units" => "numeric|nullable",
            "electricity_meter_number" => "numeric|nullable",
            "electricity_meter_reading" => "numeric|nullable",
            "gas_meter_number" => "numeric|nullable",
            "gas_meter_reading" => "numeric|nullable",
            "water_meter_number" => "numeric|nullable",
            "water_meter_reading" => "numeric|nullable",
            "description" => "string|nullable",
            "is_publish" => "required|boolean|nullable",
            "unit_length" => "numeric|nullable",
            "unit_direction" => "string|nullable",
            "number_parking_lots" => "numeric|nullable",
            "sign_area" => "numeric|nullable",
            "sign_location" => "string|nullable",
            "special_sign_specification" => "string|nullable",
            "insurance_policy_number" => "numeric|nullable",
            "mezzanine" => "boolean|nullable",
            "unit_finishing" => "boolean|nullable",
        ];
    }

    public function messages()
    {
        return [

            "building_type_use_id.required" => __("real_estate_client.you must choose building type use"),
            "building_type_use_id.numeric" => __("real_estate_client.you must choose building type use and send id number"),
            "building_type_use_id.in" => __("real_estate_client.you must choose building type from 1 : 2"),
            "purpose_property_id.required" => __("real_estate_client.you must choose purpose property"),
            "purpose_property_id.numeric" => __("real_estate_client.you must choose purpose property and send id number"),
            "price.required" => __("real_estate_client.you must enter price"),
            "price.numeric" => __("real_estate_client.you must enter price as number"),
            "security_deposit.required_if" => __("real_estate_client.you must enter security deposit"),
            "security_deposit.numeric" => __("real_estate_client.you must enter security deposit as number"),
            "unit_type.required" => __("real_estate_client.you must enter unit type"),
            "unit_type.string" => __("real_estate_client.you must enter unit type as string"),
            "unit_number.required" => __("real_estate_client.you must enter unit number"),
            "unit_number.string" => __("real_estate_client.you must enter unit number as string"),
            "floor_number.numeric" => __("real_estate_client.you must enter floor number as number"),
            "unit_area.required" => __("real_estate_client.you must enter unit area"),
            "unit_area.numeric" => __("real_estate_client.you must enter unit area as number"),
            "furnished.string" => __("real_estate_client.you must enter furnished as string"),
            "composite_kitchen_cabinets.boolean" => __("real_estate_client.you must enter furnished as boolean 1 or 0"),
            "ac_type.string" => __("real_estate_client.you must enter ac_type as string"),
            "num_ac_units.numeric" => __("real_estate_client.you must enter num_ac_units as numeric"),
            "electricity_meter_number.numeric" => __("real_estate_client.you must enter electricity meter number as numeric"),
            "electricity_meter_reading.numeric" => __("real_estate_client.you must enter electricity meter reading as numeric"),
            "gas_meter_number.numeric" => __("real_estate_client.you must enter gas meter number as numeric"),
            "gas_meter_reading.numeric" => __("real_estate_client.you must enter gas meter reading as numeric"),
            "water_meter_number.numeric" => __("real_estate_client.you must enter water meter number as numeric"),
            "water_meter_reading.numeric" => __("real_estate_client.you must enter water meter reading as numeric"),
            "description.string" => __("real_estate_client.you must enter description as string"),
            "is_publish.required" => __("real_estate_client.you must choose is_publish"),
            "description.boolean" => __("real_estate_client.you must choose is_publish as yes or no"),
            "media.required" => __("real_estate_client.you must choose unit media"),
            "media.array" => __("real_estate_client.you must choose unit media as array"),
            "unit_length.numeric" => __("real_estate_client.you must enter unit length as number"),
            "unit_direction.string" => __("real_estate_client.you must enter unit direction as string"),
            "number_parking_lots.numeric" => __("real_estate_client.you must enter number parking lots as number"),
            "sign_area.numeric" => __("real_estate_client.you must enter sign area as number"),
            "sign_location.string" => __("real_estate_client.you must enter sign location as string"),
            "special_sign_specification.string" => __("real_estate_client.you must enter special sign specification as string"),
            "insurance_policy_number.numeric" => __("real_estate_client.you must enter insurance policy number as number"),
            "mezzanine.boolean" => __("real_estate_client.you must enter mezzanine as boolean yes or no"),
            "unit_finishing.boolean" => __("real_estate_client.you must enter unit finishing as boolean yes or no"),
        ];
    }
}
