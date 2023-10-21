<?php

namespace App\Http\Requests\Client\RealEstate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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

        ];
    }
}
