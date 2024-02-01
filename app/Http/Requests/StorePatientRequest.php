<?php

namespace App\Http\Requests;

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
        
        if(Auth::user()->hasRole('Super Admin')) {
            return [
                'first_name' => 'required|regex: /^[a-zA-Z ]{2,30}$/',
                'email' => 'required|email|unique:users,email',
                'phone_no' => 'required|digits:10|numeric',
                'address' => 'required',
                'gender' => 'required',
                'doctor_id' => 'required',  
                'clinic_id' => 'required',
            ];
        }

        if(Auth::user()->hasAnyRole(['Super Admin','Receptionist','Doctor','Hospital'])) {
            
            return [
                'first_name' => 'required|regex: /^[a-zA-Z ]{2,30}$/',
                'email' => 'required|email|unique:users,email',
                'phone_no' => 'required|digits:10|numeric',
                'address' => 'required',
                'gender' => 'required',
                // 'doctor_id' => 'required',
            ];
        }
    }
}
