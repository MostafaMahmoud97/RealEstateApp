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
            "cover_real_estate" => "required|string",
            "cover_real_estate_extention" => "required|string|in:jpg,png,jpeg",
            "unit" => "required",
            "unit.commercial_activity_id" => "required_if:building_type_use_id,1|numeric",
            "unit.purpose_property_id" => "required|numeric|in:1,2",
            "unit.price" => "required|numeric",
            "unit.security_deposit" => "required_if:unit.purpose_property_id,1|numeric",
            "unit.unit_type" => "required|string",
            "unit.unit_number" => "required|string",
            "unit.floor_number" => "numeric|nullable",
            "unit.unit_area" => "required|numeric",
            "unit.furnished" => "boolean|nullable",
            "unit.composite_kitchen_cabinets" => "boolean|nullable",
            "unit.ac_type" => "string|nullable",
            "unit.num_ac_units" => "numeric|nullable",
            "unit.electricity_meter_number" => "numeric|nullable",
            "unit.electricity_meter_reading" => "numeric|nullable",
            "unit.gas_meter_number" => "numeric|nullable",
            "unit.gas_meter_reading" => "numeric|nullable",
            "unit.water_meter_number" => "numeric|nullable",
            "unit.water_meter_reading" => "numeric|nullable",
            "unit.description" => "string|nullable",
            "unit.is_publish" => "required|boolean|nullable",
            "unit.media" => "required|array|min:1",
            "unit.media.*.media" => "required|string",
            "unit.media.*.extention" => "in:jpg,png,jpeg,mp4,avchd,mov,webm,avi,flv,wmv",
            "unit.unit_length" => "numeric|nullable",
            "unit.unit_direction" => "string|nullable",
            "unit.unit_number_parking_lots" => "numeric|nullable",
            "unit.sign_area" => "numeric|nullable",
            "unit.sign_location" => "string|nullable",
            "unit.special_sign_specification" => "string|nullable",
            "unit.insurance_policy_number" => "numeric|nullable",
            "unit.mezzanine" => "boolean|nullable",
            "unit.unit_finishing" => "string|nullable",
        ];
    }

    public function messages()
    {
        return [
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
            "unit.commercial_activity_id.required_if" => __("real_estate_client.you must choose commercial activity"),
            "unit.commercial_activity_id.numeric" => __("real_estate_client.you must choose commercial activity and send id number"),
            "unit.purpose_property_id.required" => __("real_estate_client.you must choose purpose property"),
            "unit.purpose_property_id.numeric" => __("real_estate_client.you must choose purpose property and send id number"),
            "unit.price.required" => __("real_estate_client.you must enter price"),
            "unit.price.numeric" => __("real_estate_client.you must enter price as number"),
            "unit.unit_type.required" => __("real_estate_client.you must enter unit type"),
            "unit.unit_type.string" => __("real_estate_client.you must enter unit type as string"),
            "unit.unit_number.required" => __("real_estate_client.you must enter unit number"),
            "unit.unit_number.string" => __("real_estate_client.you must enter unit number as string"),
            "unit.floor_number.numeric" => __("real_estate_client.you must enter floor number as number"),
            "unit.unit_area.required" => __("real_estate_client.you must enter unit area"),
            "unit.unit_area.numeric" => __("real_estate_client.you must enter unit area as number"),
            "unit.furnished.boolean" => __("real_estate_client.you must enter furnished as boolean 1 or 0"),
            "unit.composite_kitchen_cabinets.boolean" => __("real_estate_client.you must enter furnished as boolean 1 or 0"),
            "unit.ac_type.string" => __("real_estate_client.you must enter ac_type as string"),
            "unit.num_ac_units.numeric" => __("real_estate_client.you must enter num_ac_units as numeric"),
            "unit.electricity_meter_number.numeric" => __("real_estate_client.you must enter electricity meter number as numeric"),
            "unit.electricity_meter_reading.numeric" => __("real_estate_client.you must enter electricity meter reading as numeric"),
            "unit.gas_meter_number.numeric" => __("real_estate_client.you must enter gas meter number as numeric"),
            "unit.gas_meter_reading.numeric" => __("real_estate_client.you must enter gas meter reading as numeric"),
            "unit.water_meter_number.numeric" => __("real_estate_client.you must enter water meter number as numeric"),
            "unit.water_meter_reading.numeric" => __("real_estate_client.you must enter water meter reading as numeric"),
            "unit.description.string" => __("real_estate_client.you must enter description as string"),
            "unit.is_publish.required" => __("real_estate_client.you must choose is_publish"),
            "unit.description.boolean" => __("real_estate_client.you must choose is_publish as yes or no"),
            "unit.media.required" => __("real_estate_client.you must choose unit media"),
            "unit.media.array" => __("real_estate_client.you must choose unit media as array"),
            "unit.unit_length.numeric" => __("real_estate_client.you must enter unit length as number"),
            "unit.unit_direction.string" => __("real_estate_client.you must enter unit direction as string"),
            "unit.number_parking_lots.numeric" => __("real_estate_client.you must enter number parking lots as number"),
            "unit.sign_area.numeric" => __("real_estate_client.you must enter sign area as number"),
            "unit.sign_location.string" => __("real_estate_client.you must enter sign location as string"),
            "unit.special_sign_specification.string" => __("real_estate_client.you must enter special sign specification as string"),
            "unit.insurance_policy_number.numeric" => __("real_estate_client.you must enter insurance policy number as number"),
            "unit.mezzanine.boolean" => __("real_estate_client.you must enter mezzanine as boolean yes or no"),
            "unit.unit_finishing.string" => __("real_estate_client.you must enter unit finishing as string"),

        ];
    }
}
