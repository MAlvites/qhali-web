@extends('layouts.main')
@section('content')
@php
    $data = [
        "current_date" => now()->format("d/m/Y"),
        "user" => currentUser(),
        "mapId" => $mapId,
        "patient" => $patient,
        "botId" => $botId,
        "pusher" => [
            'key' => config('broadcasting.connections.pusher.key'),
            'cluster' => config('broadcasting.connections.pusher.options.cluster'),
        ]
    ];
@endphp
<medical-attention :data="{{json_encode($data)}}"></medical-attention>
@endsection
