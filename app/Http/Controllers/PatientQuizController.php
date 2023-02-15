<?php

namespace App\Http\Controllers;

use App\Events\RealizePatientQuiz;
use App\Http\Requests\PatientQuizRequest;
use App\Models\PatientQuiz;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PatientQuizController extends Controller
{
    public function create(PatientQuizRequest $request): JsonResponse
    {
        PatientQuiz::create([
            'quiz_id' => $request->quiz_id,
            'patient_id' => $request->patient_id,
            'user_id' => currentUser()->id,
            'who_resolved' =>  $request->who_resolved,
            'response' =>  $request->response,
            'score' =>  $request->score,
        ]);

        return response()->services(true, 'La encuesta fue registrada');
    }

    public function search(Request $request): JsonResponse
    {
        $patientQuizzes = PatientQuiz::selectRaw('patient_quizzes.id, quizzes.name quiz_name, who_resolved,
            score, DATE_FORMAT(patient_quizzes.created_at, "%d/%m/%Y %H:%i") date')
            ->join('quizzes', 'quizzes.id', 'patient_quizzes.quiz_id')
            ->where('patient_id', $request->patient_id)
            ->whereRaw('quizzes.name like "%'.$request->name.'%"')
            ->orderByDesc('patient_quizzes.created_at')
            ->paginate(15);

        return response()->services(true, 'Lista de encuestas', $patientQuizzes);
    }

    public function getPatientQuiz(int $id)
    {
        $patientQuiz = PatientQuiz::selectRaw('patient_quizzes.*, quizzes.name')
            ->join('quizzes', 'quizzes.id', 'patient_quizzes.quiz_id')
            ->where('patient_quizzes.id', $id)
            ->first();

        return response()->services(true, 'Lista de encuestas', $patientQuiz);
    }

    public function relizeQuiz(Request $request)
    {
        event(new RealizePatientQuiz($request->quiz_id, $request->patient_id, $request->bot_id));
    }
}
