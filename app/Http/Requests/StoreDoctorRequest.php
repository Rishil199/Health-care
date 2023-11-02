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
            'phone_no' => 'required|digits:10|numeric',
            'status' => 'required',
            'address' => 'required',
            'birth_date' => 'required|date_format:d/m/Y',
            'degree' => 'required',
            'experience' => 'required',
            'expertice' => 'required'

        ];
    }
}
