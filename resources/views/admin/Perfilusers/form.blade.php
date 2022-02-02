<h1> {{$modo}} Perfil de Usuario</h1>
@if(count($errors)>0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach($errors->all() as $error)
                <li> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<br>
<div class="form-group">
<label for="perfilusers"> Perfil de Usuario </label>
<input type="text" class="form-control" name="cve_perfil_usuario" id="cve_perfil_usuario" 
    value="{{ $perfilusers->cve_perfil_usuario }}">
<br>
<input type="text" class="form-control" name="descripcion" id="descripcion" 
    value="{{ $perfilusers->descripcion }}">
<br>
<label for="activo"> Activo </label>
<input onInput="jsactiva();" type="checkbox" id="activa" name="activa" 
    value="{{ $perfilusers->activo }}"
<?php
    if ($perfilusers->activo) echo " checked "
?>
> 
<br>
@include('include.grabarbtn')
<a href="{{ url('/admin/Perfilusers') }}" class="btn btn-primary"  > Regresar </a>
<br>
<input type="hidden" id="activao" name= "activao" 
    value="{{ $perfilusers->activo }}">
</div>
@include('include.jsactiva')