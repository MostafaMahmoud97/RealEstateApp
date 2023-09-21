<?php

namespace App\Http\Requests\Client\RealEstate;

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
            "user_id.required" => __("real_estate_client.you must enter user id"),
            "user_id.numeric" => __("real_estate_client.you must enter user id as number"),
            "building_type_id.required" => __("real_estate_client.you must choose building type"),
            "building_type_id.numeric" => __("real_estate_client.you must choose building type and send id number"),
            "building_type_id.in" => __("real_estate_client.you must choose building type from 1 : 9"),
            "building_type_use_id.required" => __("real_estate_client.you must choose building type use"),
            "building_type_use_id.numeric" => __("real_estate_client.you must choose building type use and send id number"),
            "building_type_use_id.in" => __("real_estate_client.you must choose building type from 1 : 2"),
            "national_address.required" => __("real_estate_client.you must enter national address"),
            "national_address.string" => __("real_estate_client.you must enter national address as string"),
            "lat.required" => __("real_estate_client.you must enter lat"),
            "lat.numeric" => __("real_estate_client.you must enter lat as number"),
            "lon.required" => __("real_estate_client.you must enter lon"),
            "lon.numeric" => __("real_estate_client.you must enter lon as number"),
            "number_floors.numeric" => __("real_estate_client.you must enter number floors as number"),
            "number_units.numeric" => __("real_estate_client.you must enter number units as number"),
            "number_parking_lots.numeric" => __("real_estate_client.you must enter number parking lots as number"),
            "cover_real_estate.required" => __("real_estate_client.you must choose cover image"),
            "cover_real_estate.mimes" => __("real_estate_client.you must choose cover image as jpg,png,jpeg"),
            "units.required" => __("real_estate_client.you must add unit"),
            "units.array" => __("real_estate_client.you must add unit as array"),
            "units.min" => __("real_estate_client.you must add min 1 unit"),
            "units.*.purpose_property_id.required" => __("real_estate_client.you must choose purpose property"),
            "units.*.purpose_property_id.numeric" => __("real_estate_client.you must choose purpose property and send id number"),
            "units.*.price.required" => __("real_estate_client.you must enter price"),
            "units.*.price.numeric" => __("real_estate_client.you must enter price as number"),
            "units.*.unit_type.required" => __("real_estate_client.you must enter unit type"),
            "units.*.unit_type.string" => __("real_estate_client.you must enter unit type as string"),
            "units.*.unit_number.required" => __("real_estate_client.you must enter unit number"),
            "units.*.unit_number.string" => __("real_estate_client.you must enter unit number as string"),
            "units.*.floor_number.numeric" => __("real_estate_client.you must enter floor number as number"),
            "units.*.unit_area.required" => __("real_estate_client.you must enter unit area"),
            "units.*.unit_area.numeric" => __("real_estate_client.you must enter unit area as number"),
            "units.*.furnished.string" => __("real_estate_client.you must enter furnished as string"),
            "units.*.composite_kitchen_cabinets.boolean" => __("real_estate_client.you must enter furnished as boolean 1 or 0"),
            "units.*.ac_type.string" => __("real_estate_client.you must enter ac_type as string"),
            "units.*.num_ac_units.numeric" => __("real_estate_client.you must enter num_ac_units as numeric"),
            "units.*.electricity_meter_number.numeric" => __("real_estate_client.you must enter electricity meter number as numeric"),
            "units.*.electricity_meter_reading.numeric" => __("real_estate_client.you must enter electricity meter reading as numeric"),
            "units.*.gas_meter_number.numeric" => __("real_estate_client.you must enter gas meter number as numeric"),
            "units.*.gas_meter_reading.numeric" => __("real_estate_client.you must enter gas meter reading as numeric"),
            "units.*.water_meter_number.numeric" => __("real_estate_client.you must enter water meter number as numeric"),
            "units.*.water_meter_reading.numeric" => __("real_estate_client.you must enter water meter reading as numeric"),
            "units.*.description.string" => __("real_estate_client.you must enter description as string"),
            "units.*.is_publish.required" => __("real_estate_client.you must choose is_publish"),
            "units.*.description.boolean" => __("real_estate_client.you must choose is_publish as yes or no"),
            "units.*.media.required" => __("real_estate_client.you must choose unit media"),
            "units.*.media.array" => __("real_estate_client.you must choose unit media as array"),
            "units.*.unit_length.numeric" => __("real_estate_client.you must enter unit length as number"),
            "units.*.unit_direction.string" => __("real_estate_client.you must enter unit direction as string"),
            "units.*.number_parking_lots.numeric" => __("real_estate_client.you must enter number parking lots as number"),
            "units.*.sign_area.numeric" => __("real_estate_client.you must enter sign area as number"),
            "units.*.sign_location.string" => __("real_estate_client.you must enter sign location as string"),
            "units.*.special_sign_specification.string" => __("real_estate_client.you must enter special sign specification as string"),
            "units.*.insurance_policy_number.numeric" => __("real_estate_client.you must enter insurance policy number as number"),
            "units.*.mezzanine.boolean" => __("real_estate_client.you must enter mezzanine as boolean yes or no"),
            "units.*.unit_finishing.boolean" => __("real_estate_client.you must enter unit finishing as boolean yes or no"),

        ];
    }
}
