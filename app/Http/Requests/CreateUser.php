<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUser extends FormRequest
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
            'name' => 'required',
            'password' => 'required|min:6|confirmed',
            'mobile' => 'required|iran_mobile',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|is_not_persian|unique:users,username',
            'avatar' => 'nullable|image',
        ];
    }
}
