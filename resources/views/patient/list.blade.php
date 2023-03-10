@extends('layouts.main')
@section('content')
@php
    $data = [
        "user" => currentUser(),
    ];
@endphp
    <list-patient :data="{{json_encode($data)}}"></list-patient>
@endsection
