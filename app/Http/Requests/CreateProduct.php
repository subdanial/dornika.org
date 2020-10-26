<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProduct extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:products,title',
            'description' => 'required',
            'image' => 'required|image',
            'price_1' => 'required',
            'price_2' => 'required',
            'price_3' => 'required',
            'price_4' => 'required',
            'consumer' => 'required',
            'number_in_box' => 'required',
            'available' => 'required',
            'category_id' => 'required',
            'commission' => 'required',
        ];
    }
}
