<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
            'last_name' => 'required|regex: /^[a-zA-Z ]{2,30}$/',
            'email' => 'required|email|unique:users,email',
            'phone_no' => 'required|min:10|max:15|regex:/^[+\-\d]+$/',
            'address' => 'required',
            'birth_date' => 'required|date_format:d/m/Y|before:today',
            'degree' => 'required',
            'experience' => 'required',
            'expertice' => 'required'

        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Doctor name is required.',
            'first_name.regex'=> 'Doctor name is invalid.',
            'last_name.required' => 'Doctor last name is required.',
            'last_name.regex'=> 'Doctor last name is invalid.',
            'email.required'=> 'Doctor email is required.',
            'email.unique'=> 'Doctor email is already taken.',
            'phone_no.required'=> 'Doctor phone number is required.',
            'address.required'=> 'Doctor address is required.',
            'birth_date.required'=> 'Doctor birth date is required.',
            'degree.required'=>'Doctor degree is required.',
            'experience.required'=>'Doctor experience is required.',
            'expertice.required'=>'Doctor expertise is required.'
        ];
    }
}
