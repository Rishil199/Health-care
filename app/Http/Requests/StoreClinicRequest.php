<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicRequest extends FormRequest
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
            'first_name' => 'required|unique:users,first_name|regex: /^[a-zA-Z ]{2,30}$/',
            'email' => 'required|email|unique:users,email',
            'phone_no' => 'required|min:10|max:15|regex:/^[+\-\d]+$/',
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Hospital name is required.',
            'first_name.unique' => 'Hospital name is already taken.',
            'first_name.regex'=> 'Hospital name is invalid.',
            'email.required'=> 'Hospital email is required.',
            'email.unique'=> 'Hospital email is already taken.',
            'phone_no.required'=> 'Hospital contact number is required.',
            'address.required'=> 'Hospital address is required.',
        ];
    }
}
