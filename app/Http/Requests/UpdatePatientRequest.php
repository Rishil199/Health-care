<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;


class UpdatePatientRequest extends FormRequest
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
        $userId  = Auth::id();

        return [
            'first_name' => 'required|regex: /^[a-zA-Z ]{2,30}$/',
            'email' => 'required|email',
            'phone_no' => 'required|digits:10|numeric',
            'address' => 'required',
            'admit_date' => 'required|date_format:d/m/Y',
            'gender' => 'required',
            'disease_name' => 'required',
            'prescription' => 'required',
            'illness' => 'required',
            'exercise' => 'required',
            'alchohol_consumption' => 'required',
            'diet' => 'required',
            'height'=>'required|numeric',
            'weight'=>'required|numeric',
            'emergency_contact' => 'required|digits:10|numeric'


        ];
    }
}
