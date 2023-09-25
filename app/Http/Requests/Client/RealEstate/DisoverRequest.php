<?php

namespace App\Http\Requests\Client\RealEstate;

use Illuminate\Foundation\Http\FormRequest;

class DisoverRequest extends FormRequest
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
            "purpose_id" => "numeric|in:1,2|nullable",
            "location" => "required",
            "location.lat" => "required|numeric",
            "location.lon" => "required|numeric",
            "price.min" => "numeric|nullable",
            "price.max" => "numeric|nullable|gte:price.min",
            "area.min" => "numeric|nullable",
            "area.max" => "numeric|nullable|gte:area.min",
            "lots.min" => "numeric|nullable",
            "lots.max" => "numeric|nullable|gte:lots.min",
            "property_type_id" => "array|nullable",
            "property_type_id.*" => "numeric|in:1,2,3,4,5,6,7,8,9",
            "property_usage_id" => "array|nullable",
            "property_usage_id.*" => "numeric|in:1,2",
        ];
    }

    public function messages()
    {
        return [
            "purpose_id.numeric" => __("real_estate_client.you must send purpose id as number"),
            "purpose_id.in" => __("real_estate_client.you must send purpose id as 1 or 2"),
            "location.required" => __("real_estate_client.you must send location"),
            "location.lat.required" => __("real_estate_client.you must send lat"),
            "location.lat.numeric" => __("real_estate_client.you must send lat as numeric"),
            "location.lon.required" => __("real_estate_client.you must send lon"),
            "location.lon.numeric" => __("real_estate_client.you must send lon as numeric"),
            "price.min.numeric" => __("real_estate_client.you must send price min as numeric"),
            "price.max.numeric" => __("real_estate_client.you must send price max as numeric"),
            "price.max.gte" => __("real_estate_client.you must send price max greater than or equal price min"),
            "area.min.numeric" => __("real_estate_client.you must send area min as numeric"),
            "area.max.numeric" => __("real_estate_client.you must send area max as numeric"),
            "area.max.gte" => __("real_estate_client.you must send area max greater than or equal area min"),
            "lots.min.numeric" => __("real_estate_client.you must send lots min as numeric"),
            "lots.max.numeric" => __("real_estate_client.you must send lots max as numeric"),
            "lots.max.gte" => __("real_estate_client.you must send lots max greater than or equal lots min"),
            "property_type_id.array" => __("real_estate_client.you must send property type id as array"),
            "property_type_id.*.numeric" => __("real_estate_client.you must send property type id value as numeric"),
            "property_type_id.*.in" => __("real_estate_client.you must send property type id value as 1,2,3,4,5,6,7,8,9"),
            "property_usage_id.array" => __("real_estate_client.you must send property usage id as array"),
            "property_usage_id.*.numeric" => __("real_estate_client.you must send property usage id value as numeric"),
            "property_usage_id.*.in" => __("real_estate_client.you must send property usage id value as 1,2"),
        ];
    }
}
