@extends('layouts.main')
@section('content')
@php
    $data = [
        "user" => currentUser(),
    ];
@endphp
<map-component :data="{{json_encode($data)}}"></map-component>
@endsection
