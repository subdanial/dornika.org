<?php

namespace App\Http\Requests;

use App\Product;
use Illuminate\Foundation\Http\FormRequest;

class AddToCart extends FormRequest
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
            'client' => 'required',
            'number' => 'nullable',
            'box' => 'nullable',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ( !$this->number && !$this->box  ) {
                $validator->errors()->add('number', 'تعداد محصول یا تعداد کارتن را انتخاب کنید.');
                $validator->errors()->add('box', 'تعداد محصول یا تعداد کارتن را انتخاب کنید.');
            } else {
                $product = Product::where('slug', $this->route('slug'))->first();
                if ( $this->number ) {
                    if ( $this->number > $product->available ) {
                        $validator->errors()->add('number', 'این تعداد محصول موجود نمی باشد.');
                    }
                }

                if ( $this->box ) {
                    $count = $this->box * $product->number_in_box;
                    if ( $count > $product->available ) {
                        $validator->errors()->add('box', 'این تعداد کارتن موجود نمی باشد.');
                    }
                }

                if ( $this->number && $this->box ) {
                    $boxes = $this->box * $product->number_in_box;
                    if ( ($boxes + $this->number) > $product->available ) {
                        $validator->errors()->add('number', 'جمع تعداد محصول با تعداد کارتن بیشتر از موجودی در انبار میباشد.');
                        $validator->errors()->add('box', 'جمع تعداد محصول با تعداد کارتن بیشتر از موجودی در انبار میباشد.');
                    }
                }
            }
        });
        return;
    }
}
