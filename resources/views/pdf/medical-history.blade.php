    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Historial Medico</title>
    <style>
        .mt-16 {
            margin-top: 16px;
        }
        .mt-30 {
            margin-top: 30px;
        }
    </style>
</head>
@foreach ($medicalHistory as $item)
<body>
    <div style="text-align: center">
        <h1>Informe Psicologico</h1>
    </div>
    <div class="mt-30">1. Fecha de evaluacion: {{$item->date}}</div>
    <div class="mt-16">2. Examinador: {{$item->medic_name}}</div>
    <div class="mt-16">3. Datos de filiacion:</div>
    <div>
        <ul>
            <li>Nombre: {{$item->patient_name}}</li>
            <li>Edad: {{$item->patient_age}} años</li>
            <li>Estado civil: {{$item->patient_civil_status}}</li>
            <li>Ocupacion: {{$item->patient_profession}}</li>
        </ul>
    </div>
    <div class="mt-16">4. Motivo de consulta:</div>
    <div>{{$item->reason_consultation}}</div>
    <div class="mt-16">5. Antecedentes de importancia:</div>
    <div>{{$item->important_background}}</div>
    <div class="mt-16">6. Descripcion clnica:</div>
    <div>{{$item->clinical_description}}</div>
    <div class="mt-16">7. Resultados de cuestionarios:</div>
    <div>{{$item->questionnaire_result}}</div>
    <div class="mt-16">8. Aproximacion diagnostica:</div>
    <div>{{$item->diagnostic_approach}}</div>
    <div class="mt-16">9. Recomendaciones:</div>
    <div>{{$item->recommendations}}</div>
    <div class="mt-16">10. Reporte de intervencion:</div>
    <div>{{$item->intervention_report}}</div>
</body>
@endforeach
</html>