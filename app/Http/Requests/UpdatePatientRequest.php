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
            'phone_no' => 'required|min:10|max:16|regex:/^[+\-\d]+$/',
            'address' => 'required',
            'admit_date' => 'required|date_format:d/m/Y',
            'gender' => 'required',
            'disease_name' => 'required',
            'prescription' => 'required',
            'illness' => 'required',
            'exercise' => 'required',
            'alchohol_consumption' => 'required',
            'diet' => 'required',
            'height'=>'required||regex:/^\d+(\.\d{1})?$/|max:5',
            'weight'=>'required||regex:/^\d+(\.\d{1})?$/|max:5',
            'smoke'=>'required'

        ];

    }

    public function messages(){
        return [

            'first_name.required'=>'Patient name is required',
            'first_name.regex'=> 'Patient name is invalid.',
            'email.required'=>'Patient email is required',
            'phone_no.required'=>'Patient phone number is required',
            'address.required'=>'Patient address is required',
            'admit_date.required'=>'Patient admit date is required',
            'gender.required'=>'Patient gender is required',
            'disease_name.required'=>'Patient disease name is required',
            'prescription.required'=>'Patient prescription is required',
            'illness.required'=>'Patient illness is required',
            'exercise.required'=>'Patient exercise is required',
            'alchohol_consumption.required'=>'Patient alchohol consumption is required',
            'diet.required'=>'Patient diet is required',
            'height.required'=>'Patient height is required',
            'height.numeric'=>'Patient height must be in CM',
            'weight.required'=>'Patient weight is required',
            'weight.numeric'=>'Patient weight must be in KG',
            'smoke.required'=>'Patient smoke is required',
            
        ];
    }


}
