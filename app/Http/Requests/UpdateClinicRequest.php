<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
class UpdateClinicRequest extends FormRequest
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
            'first_name' => 'required|regex: /^[a-zA-Z ]{2,30}$/',
            'email' => 'required|email',
            'phone_no' => 'required|digits:10|numeric',
            'status' => 'required',
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Hospital name is required.',
            'first_name.regex'=> 'Hospital name is invalid.',
            'email.required'=> 'Hospital email is required.',
            'phone_no.required'=> 'Hospital phone number is required.',
            'status.required' => 'Hospital status is required.',
            'address.required'=> 'Hospital address is required.',
        ];
    }
}
