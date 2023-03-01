<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"></head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <style>
        html,
        body {
            height: 100%;
            width: 100%;
            background-color: #fff;
        }
        .block-web {
            pointer-events: none;
            background-color: #fff;
            opacity: 0.5;
        }
    </style>
<body>
    @php
        $user = currentUser();
    @endphp
    <div id="main" class="h-100">
        <section class="header">
            <div class="wrapper">
                <div id="imageBot" class="bot-navbar">
                    <img  src="/img/cara2.png" alt="" style="height: 100%;">
                    <div id="textBot" class="popup">
                        <div class="popup-em"></div>
                        Hola doc, ¿Cómo puedo ayudarte?
                    </div>
                </div>
                <a  href="/dashboard">
                    <img src="/img/logo.png" alt="" class="img-navbar-center">
                </a>
                <div class="navbar-user d-flex" id="username">
                    <div  class="mr-4">{{ $user->name }}</div>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        <img src="/img/svg/close.svg" alt="" style="width: 30px;margin-left: 10px;">
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </section>
        <div id="sidebar">
            @if($user->role_id === 1 || $user->role_id === 2)
                <div class="toggle-btn">
                    <span>&#9776;</span>
                </div>
            @endif

            <div class="content-enterprise position-relative">
                <img src="/img/logo.png" alt="logo" class="position-center" style="max-width: 100%;">
                <!--<span class="name">Crece Group</span>-->
            </div>
            <ul>
                @if($user->role_id === 1 || $user->role_id === 2)
                    <li>
                        <i class="fad fa-robot"></i><a href="/bots">Qhali</a>
                    </li>
                    <li>
                        <i class="far fa-sticky-note"></i></i><a href="/medical-appointments">Cita Médica</a>
                    </li>
                    <li>
                        <i class="fas fa-id-badge"></i></i><a href="/patients">Pacientes</a>
                    </li>
                    <li>
                        <i class="fas fa-at"></i></i><a href="/supports">Contactar Soporte</a>
                    </li>
                @endif
                @if($user->role_id === 1)
                    <li>
                        <i class="far fa-user"></i></i></i><a href="/users">Usuarios</a>
                    </li>
                    <li>
                        <i class="fas fa-tools"></i></i><a href="/bot-actions">Acciones</a>
                    </li>
                    <li>
                        <i class="far fa-clipboard"></i><a href="/quizzes">Encuestas</a>
                    </li>
                    <li>
                        <i class="fas fa-map"></i><a href="/maps">Mapas</a>
                    </li>
                @endif
            </ul>
        </div>

        <div id="content" class="active h-100 background-white"> 
            <div id="app" class="h-100">
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
    @if($user->role_id === 1 || $user->role_id === 2)
    <script>
        const btnToggle = document.querySelector('.toggle-btn')
        btnToggle.addEventListener('click', function(){
            document.getElementById('sidebar').classList.toggle('active')
            document.getElementById('content').classList.toggle('active')
            document.getElementById('imageBot').classList.toggle('active')
            document.getElementById('textBot').classList.toggle('active')

        })
    </script>
    @endif
    @yield('script')
</body>
</html>