@extends('layouts.main')
@section('content')
<div class="h-100">
    <div class="class-position">Gestion de Encuestas</div>
    <div class="content-menu-patients">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-center">
                            <a href="/quizzes/add" class="a-section-title">
                                <img src="/img/svg/menu/agregar-encuesta.svg" alt="" class="dashboard-img">
                                <p class="section-title">Crear Encuesta</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center">
                            <a href="/quizzes/list" class="a-section-title">
                                <img src="/img/svg/menu/listar-encuesta.svg" alt="" class="dashboard-img">
                                <p class="section-title">Lista de Encuestas</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
    