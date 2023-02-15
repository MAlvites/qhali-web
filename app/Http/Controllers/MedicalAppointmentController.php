<?php

namespace App\Http\Controllers;

use App\Models\Patient;

class MedicalAppointmentController extends Controller
{
    public function patientManagment(int $patientId)
    {
        $patient = Patient::find($patientId);

        if (!$patient) {
            return redirect('/medical-appointments');
        }

        return view('medical-appointment.patient-managment', ['patient' => $patient]);
    }

    public function medicalAttention(int $patientId, int $botId)
    {
        $patient = Patient::find($patientId);

        if (!$patient) {
            return redirect('/medical-appointments');
        }

        return view('medical-appointment.medical-attention', [
            'patient' => $patient,
            'botId' => $botId
        ]);
    }
}
