@extends('layouts.main')
@section('content')
@php
    $data = [
        "patient" => $patient
    ];
@endphp
<edit-patient :data="{{json_encode($data)}}"></edit-patient>
@endsection
