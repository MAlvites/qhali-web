@extends('layouts.app')

@section('content')
<div class="h-100 w-100" style="display: flex;">
    <div class="login-content-left">
        <img src="/img/robotin3.png" alt="" class="login-bot-img">
    </div>
    <div class="login-content-right">
        <div class="text-center">
            <img src="/img/logo.png" alt="">

            <div class="login-form">
                <div class="login-text">
                    Bienvenido a RoboSoftMed. Por favor logueate para acceder a Robotin.
                </div>
                <div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="email" class="login-text-form">Correo Electrónico</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror login-input" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus id="email" aria-describedby="emailHelp" placeholder="Ingresar Correo">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password" class="login-text-form">Contraseña</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror login-input" id="password" name="password" placeholder="Ingresar Contraseña" required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-check mt-4" hidden>
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" checked {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary login-button w-100">Ingresar</button>
                                </div>
                                <div class="mt-2">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link login-text-form" style="text-decoration: none" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
