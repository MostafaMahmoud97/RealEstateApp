<?php

namespace App\Http\Requests\Admin\Deals;

use Illuminate\Foundation\Http\FormRequest;

class UploadContractRequest extends FormRequest
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
            "deal_id" => "required|numeric",
            "contract_file" => "required|mimes:pdf|max:2048"
        ];
    }

    public function messages()
    {
        return [
            "deal_id.required" => __("deals.you must send deal id"),
            "deal_id.numeric" => __("deals.you must send deal id as number"),
            "contract_file.required" => __("deals.you must send contract file"),
            "contract_file.mimes" => __("deals.you must send contract file as pdf"),
        ];
    }
}
