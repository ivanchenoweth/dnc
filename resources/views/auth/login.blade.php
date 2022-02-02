@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <img src="../images/Logo_Hacienda_Recursos_Humanos_MD.jpg">
            </div>
            <br>
            <font size="+2">
                <center>
                <strong>SISTEMA FORMATO DNC 2022</strong>
                </center>
            </font>
                <!--
                <div class="card-header">{{ __('Acceso') }}</div>
                -->
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo Electrónico') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Recuerdame') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Acceso') }}
                                </button>
                                <!--
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('¿Olvidaste tu contraseña?') }}
                                    </a>
                                @endif
                                -->
                            </div>
                        </div>
                        <div>
                            <br>
                            <font size="-1">
                            <br>
                                <center>Contacto: Comonfort y Blvrd. Paseo Río Sonora, Centro de Gobierno Edificio Hermosillo, Tercer nivel C.P. 83280</center>
                                <center>Teléfono (662) 213 79 75 y (662) 212 08 10</center>
                            </font>
                            <br>
                            <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
