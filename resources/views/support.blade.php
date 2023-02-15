@extends('layouts.main')
@section('content')
@php
    $data = [
        "user" => currentUser(),
    ];
@endphp
<contact-support :data="{{json_encode($data)}}"></contact-support>
@endsection
