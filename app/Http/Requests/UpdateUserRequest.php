<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateUserRequest extends FormRequest
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
            'last_name' => 'required|regex: /^[a-zA-Z ]{2,30}$/',
            'email' => 'required|email|',
            'roles_type' => 'required',
        ];
    }
}
