<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'maker_id' => 'required',
            'model_id' => 'required',
            'year' => ['required', 'integer', 'min:1900', 'max:'.date('Y')],
            'car_type_id' => 'required|exists:car_types,id',
            'price' => 'required|integer|min:0',
            'vin' => 'required|string|max:17',
            'mileage' => 'required|integer|min:0',
            'fuel_type_id' => 'required|exists:fuel_types,id',
            'city_id' => 'required',
            'address' => 'required|string',
            'phone' => 'required|string|min:9|max:15',
            'description' => 'nullable|string',
            'published_at' => 'nullable|string',
            'features' => 'array',
            'features.*' => 'string',
            'images' => 'array',
            'images.*' => File::image()->max(2048),
        ];
    }

    // public function messages()
    // {
    //     // return [];
    // }

    // public function attributes()
    // {
    //     // return [];
    // }
}
