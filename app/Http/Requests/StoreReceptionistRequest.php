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
            'birth_date' => 'required',
            'gender' => 'required',
            'qualification' => 'required',
            'experience' => 'required',
        ];
    }
}
