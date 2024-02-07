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
            'next_date' => 'required',
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
            'disease_name.required' => 'Prescription field is required.',
            'is_complete.required' => 'This field is required.',

        ];
    }
}
