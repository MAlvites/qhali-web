@extends('layouts.main')
@section('content')
@php
    $data = [
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
