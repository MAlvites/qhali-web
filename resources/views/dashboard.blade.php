@extends('layouts.main')
@section('content')
@php
    $user = currentUser();
@endphp
<div class="row content-menu">
    <div class="col-9">
        @if($user->role_id === 3)
            @php
                $data = [
                    "user" => $user,
                    "patient" => [
                        'id' => null
                    ]
                ];
            @endphp
            <bot-dashboard :data="{{json_encode($data)}}"></bot-dashboard>
        @endif
        @if($user->role_id === 1 || $user->role_id === 2)
            <div class="row">
                
                <div class="col-md-4">
                    <a href="/medical-appointments" class="a-section-title">
                        <div class="text-center">
                            <img src="/img/svg/menu/cita-medica.svg" alt="" class="dashboard-img">
                            <p class="section-title">Cita Médica</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="/patients" class="a-section-title">
                        <div class="text-center">
                            <img src="/img/svg/menu/pacientes.svg" alt="" class="dashboard-img">
                            <p class="section-title">Pacientes</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="/supports" class="a-section-title">
                        <div class="text-center">
                            <img src="/img/svg/menu/soporte.svg" alt="" class="dashboard-img">
                            <p class="section-title">Contactar Soporte</p>
                        </div>
                    </a>
                </div>
                @if($user->role_id === 1)
                    <div class="col-md-4">
                        <a href="/users" class="a-section-title">
                            <div class="text-center">
                                <img src="/img/svg/menu/usuarios.svg" alt="" class="dashboard-img">
                                <p class="section-title">Usuarios</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/bot-actions" class="a-section-title">
                            <div class="text-center">
                                <img src="/img/svg/menu/acciones.svg" alt="" class="dashboard-img">
                                <p class="section-title">Acciones</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/quizzes" class="a-section-title">
                            <div class="text-center">
                                <img src="/img/svg/menu/encuestas.svg" alt="" class="dashboard-img">
                                <p class="section-title">Encuestas</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/maps" class="a-section-title">
                            <div class="text-center">
                                <img src="/img/svg/menu/mapas.svg" alt="" class="dashboard-img">
                                <p class="section-title">Mapas</p>
                            </div>
                        </a>
                    </div>
                @endif
                @if($user->role_id === 1 || $user->role_id === 2)
                <div class="col-md-4">
                        <a href="/bots" class="a-section-title">
                            <div class="text-center">
                                <img src="/img/svg/menu/robotin.svg" alt="" class="dashboard-img">
                                <p class="section-title">Qhali</p>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
