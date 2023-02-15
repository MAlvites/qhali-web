<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class SaveMedicalHitoryRequest extends FormRequest
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
            'patient_id' => 'required|integer',
            'reason_consultation'=> Rule::requiredIf($this->validateHistory()),
            'important_background'=> Rule::requiredIf($this->validateHistory()),
            'clinical_description'=> Rule::requiredIf($this->validateHistory()),
            'questionnaire_result'=> Rule::requiredIf($this->validateHistory()),
            'diagnostic_approach'=> Rule::requiredIf($this->validateHistory()),
            'recommendations'=> Rule::requiredIf($this->validateHistory()),
            'intervention_report'=> Rule::requiredIf($this->validateHistory())
        ];
    }

    private function validateHistory()
    {
    $request = $this->all();
        if (is_null($request['reason_consultation']) && is_null($request['important_background']) && is_null($request['clinical_description']) && 
        is_null($request['questionnaire_result']) && is_null($request['diagnostic_approach']) && is_null($request['recommendations']) && 
        is_null($request['intervention_report'])) {
            return true;
        } else {
            return false;
        }
    }
}
