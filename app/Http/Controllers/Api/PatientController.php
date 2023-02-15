<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\SaveMedicalHitoryRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\MedicalHistory;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use PDF;

class PatientController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $patients = Patient::select(DB::raw('id, concat(name, " ",last_name, " ", mother_last_name) full_name,
            if(has_medic_history is not null, concat("'.config('app.url').'api/patients/generate-medical-history-pdf/", patients.id), null) as uri'))
            ->whereRaw('concat(name, " ",last_name, " ", mother_last_name) like "%'.$request->name.'%"')
            ->orderByDesc('id')
            ->paginate(15);

        return response()->services(true, 'Lista de pacientes', $patients);
    }

    public function create(CreatePatientRequest $request): JsonResponse
    {
        Patient::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'mother_last_name' => $request->mother_last_name,
            'nin' => $request->nin,
            'age' => $request->age,
            'date_birth' => $request->date_birth,
            'civil_status' => $request->civil_status,
            'birth_sex' => $request->birth_sex,
            'sex_orientation' => $request->sex_orientation,
            'academic_level' => $request->academic_level,
            'profession' => $request->profession,
            'employment_situation' => $request->employment_situation,
            'address' => $request->address,
            'district' => $request->district,
            'phone_number' => $request->phone_number,
            'email' => $request->email
        ]);

        return response()->services(true, 'Paciente creado correctamente');
    }

    public function saveMedicalHistory(SaveMedicalHitoryRequest $request)
    {
        MedicalHistory::create([
            'user_id' => $request->user()->id,
            'patient_id'=> $request->patient_id,
            'reason_consultation'=> $request->reason_consultation,
            'important_background'=> $request->important_background,
            'clinical_description'=> $request->clinical_description,
            'questionnaire_result'=> $request->questionnaire_result,
            'diagnostic_approach'=> $request->diagnostic_approach,
            'recommendations'=> $request->recommendations,
            'intervention_report'=> $request->intervention_report
        ]);
        Patient::find($request->patient_id)->update(['has_medic_history' => 1]);

        return response()->services(true, 'Historial medico guardado');
    }

    public function generateMedicalHistoryPdf($patientId)
    {
        $medicalHistory = MedicalHistory::selectRaw('users.name medic_name, concat(patients.name, " ", patients.last_name) patient_name,
            age patient_age, civil_status patient_civil_status, profession patient_profession, DATE_FORMAT(medical_history.created_at, "%d/%m/%Y") date,medical_history.*')
            ->where('patient_id', $patientId)
            ->join('users', 'users.id', 'medical_history.user_id')        
            ->join('patients', 'patients.id', 'medical_history.patient_id')        
            ->get();
        
        if ($medicalHistory->count() == 0) {
            return "El paciente no cuenta con historial medico";
        }

        $pdf = PDF::loadView('pdf.medical-history', ['medicalHistory' => $medicalHistory]);
        return $pdf->download('historial_medico-'.now().'.pdf');
    }

    public function getPatient(int $id)
    {
        $patient = Patient::find($id);
        return response()->services(true, 'Informacion del paciente', $patient);
    }
    
    public function update(UpdatePatientRequest $request)
    {
        Patient::find($request->id)->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'mother_last_name' => $request->mother_last_name,
            'nin' => $request->nin,
            'age' => $request->age,
            'date_birth' => $request->date_birth,
            'civil_status' => $request->civil_status,
            'birth_sex' => $request->birth_sex,
            'sex_orientation' => $request->sex_orientation,
            'academic_level' => $request->academic_level,
            'profession' => $request->profession,
            'employment_situation' => $request->employment_situation,
            'address' => $request->address,
            'district' => $request->district,
            'phone_number' => $request->phone_number,
            'email' => $request->email
        ]);

        return response()->services(true, 'Paciente actualizado correctamente');
    }
}
