<?php

namespace App\Http\Requests;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StorePatientRequest extends FormRequest
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
        
        if(Auth::user()->hasRole(User::ROLE_SUPER_ADMIN)) {
            return [
                'first_name' => 'required|regex: /^[a-zA-Z ]{2,30}$/',
                'email' => 'required|email|unique:users,email',
                'phone_no' => 'required|digits:10|numeric',
                'address' => 'required',
                'gender' => 'required',
                'doctor_id' => 'required',  
                'clinic_id' => 'required',
                'height'=>'required|numeric',
                'weight'=>'required|numeric'
            ];
        }
        
        if(Auth::user()->hasAnyRole([User::ROLE_SUPER_ADMIN,User::ROLE_RECEPTIONIST,User::ROLE_DOCTOR,User::ROLE_CLINIC])) {
            
            return [
                'first_name' => 'required|regex: /^[a-zA-Z ]{2,30}$/',
                'email' => 'required|email|unique:users,email',
                'phone_no' => 'required|digits:10|numeric',
                'address' => 'required',
                'gender' => 'required',
                'height'=>'required|numeric',
                'weight'=>'required|numeric'
            ];
        }
    }

    public function messages(){
        return [

            'first_name.required'=>'Patient name is required',
            'first_name.regex'=> 'Patient name is invalid.',
            'email.required'=>'Patient email is required',
            'email.unique' => 'patient email is already taken.',
            'phone_no.required'=>'Patient phone number is required',
            'address.required'=>'Patient address is required',
            'gender.required'=>'Patient gender is required',
            'height.required'=>'Patient height is required',
            'height.numeric'=>'Patient height must be in CM',
            'weight.required'=>'Patient weight is required',
            'weight.numeric'=>'Patient weight must be in KG '
            
        ];
    }
}
