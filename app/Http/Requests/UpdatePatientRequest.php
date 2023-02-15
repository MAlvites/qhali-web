<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'id' => 'required|integer|exists:patients,id',
            'name' => 'required|string',
            'last_name' => 'required|string',
            'mother_last_name' => 'required|string',
            'nin' => 'required|string',
            'age' => 'required|integer',
            'date_birth' => 'required|date',
            'civil_status' => 'required|string',
            'birth_sex' => 'string',
            'sex_orientation' => 'string',
            'academic_level' => 'string',
            'profession' => 'string',
            'employment_situation' => 'string',
            'address' => 'required|string',
            'district' => 'required|string',
            'phone_number' => 'required|integer',
            'email' => 'required|string|email'
        ];
    }
}
