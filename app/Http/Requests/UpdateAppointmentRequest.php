<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
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
            'disease_name' => 'required',
            'is_complete' => 'sometimes',
            'next_date' => 'sometimes',
            'prescription'=>'required',
            'next_start_time' => 'sometimes',
            // 'time_start' =>'sometimes',
            // 'end_time'=>'sometimes',
            'weight' =>'sometimes',
            'blood_pressure'=>'sometimes',
            'dietplan'=>'sometimes'

        ];
    }

    public function messages()
    {
        return [
            'disease_name.required' => 'Disease name is required.',
            'is_complete.required' => 'is completed is required.',
            'prescription.required' => 'Prescription is required.'

        ];
    }
}
