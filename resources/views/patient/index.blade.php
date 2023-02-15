@extends('layouts.main')
@section('content')
<div class="h-100">
    <div class="class-position">Gestion de Pacientes</div>
    <div class="content-menu-patients">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-center">
                            <a href="/patients/add" class="a-section-title">
                                <img src="/img/svg/menu/agregar.svg" alt="" class="dashboard-img">
                                <p class="section-title">Añadir pacientes</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center">
                            <a href="/patients/list" class="a-section-title">
                                <img src="/img/svg/menu/buscar.svg" alt="" class="dashboard-img">
                                <p class="section-title">Buscar pacientes</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
