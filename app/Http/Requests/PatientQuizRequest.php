<?php

namespace App\Http\Requests;

use App\Models\PatientQuiz;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientQuizRequest extends FormRequest
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
            'quiz_id' => 'required|exists:quizzes,id',
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'who_resolved' =>  [
                'required',
                Rule::in(
                    [
                        PatientQuiz::PATIENT,
                        PatientQuiz::MEDIC
                    ]
                ),
            ],
            'response' =>  'required|json',
            'score' =>  'required|integer',
        ];
    }
}
