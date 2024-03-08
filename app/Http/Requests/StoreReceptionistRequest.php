<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReceptionistRequest extends FormRequest
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
            'first_name' => 'required|regex: /^[A-Z]{2,30}+$/i',
            'last_name' => 'required|regex: /^[A-Z]{2,30}+$/i',
            'email' => 'required|email|unique:users,email',
            'phone_no' => 'required|digits:10|numeric',
            'birth_date' => 'required|before:today',
            'gender' => 'required',
            'qualification' => 'required',
            'experience' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Staff first name is required.',
            'first_name.regex'=> 'Staff first name is invalid.',
            'last_name.required' => ' Staff last name is required.',
            'last_name.regex'=> 'Staff last name is invalid.',
            'email.required'=> 'Staff email is required.',
            'email.unique'=> 'Staff email is already taken.',
            'phone_no.required'=> 'Staff phone number is required.',
            'birth_date.required'=> 'Staff birth date is required.',
            'gender.required'=>'Staff gender is required.',
            'qualification.required'=>'Staff qualification is required.',
            'experience.required'=>'Staff experience is required.'

        ];
    }
}
