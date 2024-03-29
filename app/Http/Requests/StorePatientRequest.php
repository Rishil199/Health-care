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
                'phone_no' => 'required|min:10|max:15|regex:/^[+\-\d]+$/',
                'address' => 'required',
                'gender' => 'required',
                'doctor_id' => 'required',  
                'clinic_id' => 'required',
                'height'=>'required|regex:/^\d{2,3}(\.\d*)?$/|max:6',
                'weight'=>'required|regex:/^\d{2,3}(\.\d{1})?$/|max:5',
                'blood_pressure'=>'nullable|regex:/^\d+\/\d+$/|max:6',
                'blood_group'=>'nullable|regex:/^[A-Za-z+-]+$/',
                'emergency_contact'=>'nullable|regex:/^[+\-\d]+$/'
                
            ];
        }
        
        if(Auth::user()->hasAnyRole([User::ROLE_RECEPTIONIST,User::ROLE_DOCTOR,User::ROLE_CLINIC])) {
            
            return [
                'first_name' => 'required|regex: /^[a-zA-Z ]{2,30}$/',
                'email' => 'required|email|unique:users,email',
                'phone_no' => 'required|min:10|max:15|regex:/^[+\-\d]+$/',
                'address' => 'required',
                'gender' => 'required',
                'height'=>'required|regex:/^\d{2,3}(\.\d*)?$/|max:6',
                'weight'=>'required|regex:/^\d{2,3}(\.\d{1})?$/|max:5',
                'blood_pressure'=>'nullable|regex:/^\d+\/\d+$/|max:6',
                'blood_group'=>'nullable|regex:/^[A-Za-z+-]+$/',
                'emergency_contact'=>'nullable|regex:/^[+\-\d]+$/'
            ];
        }
    }

    public function messages(){
        return [

            'first_name.required'=>'Patient name is required.',
            'first_name.regex'=> 'Patient name is invalid..',
            'email.required'=>'Patient email is required.',
            'email.unique' => 'patient email is already taken.',
            'phone_no.required'=>'Patient contact number is required.',
            'address.required'=>'Patient address is required.',
            'gender.required'=>'Patient gender is required.',
            'doctor_id.required'=>'Selecting Doctor is mandatory.',
            'height.required'=>'Patient height is required.',
            'height.regex'=>'Patient height must be in CM.',
            'weight.required'=>'Patient weight is required',
            'weight.regex'=>'Patient weight must be in KG.',
            'blood_pressure.regex'=>'Patient blood pressure format is invalid.',
            'blood_group.regex'=>'Patient blood group format is invalid.'

        ];
    }
}
