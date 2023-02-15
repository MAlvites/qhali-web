@extends('layouts.main')
@section('content')
@php
    $data = [
        "user" => currentUser(),
        "patient" => $patient,
        "pusher" => [
            'key' => config('broadcasting.connections.pusher.key'),
            'cluster' => config('broadcasting.connections.pusher.options.cluster'),
        ]
    ];
@endphp
<patient-managment :data="{{json_encode($data)}}"></patient-managment>
@endsection
