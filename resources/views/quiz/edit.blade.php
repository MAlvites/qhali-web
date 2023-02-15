@extends('layouts.main')
@section('content')
@php
    $data = [
        "quiz" => $quiz
    ];
@endphp
    <edit-quiz :data="{{json_encode($data)}}"></edit-quiz>
@endsection
