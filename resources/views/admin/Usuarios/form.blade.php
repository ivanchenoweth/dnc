<h1> {{$modo}} Usuario</h1>
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
<label for="fk_cve_perfil_usuario"> Perfil de Usuario </label>
<select class="form-control" name="fk_cve_perfil_usuario" id="fk_cve_perfil_usuario">
     @foreach( $perfil_usuarios as $perfil)
     <option value="{{ $perfil->cve_perfil_usuario }}" 
       <?php   
           if (isset($usuarios->fk_cve_perfil_usuario)) {
               $usuarios->fk_cve_perfil_usuario = trim( $usuarios->fk_cve_perfil_usuario); }
            else {
               //dd($usuarios);
               $usuarios->fk_cve_perfil_usuario = old('cve_perfil_usuario');
            }                
            if( $perfil->cve_perfil_usuario == $usuarios->fk_cve_perfil_usuario) 
                echo 'selected="selected"'                
        ?>                     
       > 
       {{ $perfil->descripcion }}
     </option>
     @endforeach            
</select>
<br>
<label for="name"> Nombre </label>
<input type="text" class="form-control" name="name" id="name" 
    value="{{ $usuarios->name }}">
<br>
<label for="email"> Correo </label>
<input type="text" class="form-control" name="email" id="email" 
    value="{{ $usuarios->email }}">
<br>
<label for="password"> Contraseña </label>
<input type="text" class="form-control" name="password" id="password" 
    value="{{ $usuarios->password }}">
<br>
<label for="activo"> Activo </label>
<input onInput="jsactiva();" type="checkbox" id="activa" name="activa" 
    value="{{ $usuarios->activo }}"
<?php
    if ($usuarios->activo) echo " checked "
?>
> 
<br>
<input type="submit" class="btn btn-success" value="{{$modo}} Datos">
<a href="{{ url('/admin/Usuarios') }}" class="btn btn-primary"  > Regresar </a>
<br>
<input type="hidden" id="activao" name= "activao" value="{{ $usuarios->activo }}">
</div>
@include('include.jsactiva')