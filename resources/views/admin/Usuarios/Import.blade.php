@extends('layouts.appcatalogos')
@section('content')
  <div class="container">
   <h3 align="center">Importar Archivo de Usuarios de Excel al Sistema</h3>
    <br />
   @if(count($errors) > 0)
    <div class="alert alert-danger">
     Error de Validación al Cargar<br><br>
     <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif
   @if($message = Session::get('success'))
   <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
           <strong>{{ $message }}</strong>
   </div>
   @endif
   <form method="post" enctype="multipart/form-data" action="{{ url('/admin/importUsuarios/import') }}">
    {{ csrf_field() }}
    <div class="form-group">
     <table class="table">
      <tr>
       <td width="40%" align="right"><label>Seleccione el Archivo a Cargar</label></td>
       <td width="30">
        <input type="file" name="select_file" />
       </td>
       <td width="30%" align="left">
        <input type="submit" name="upload" class="btn btn-primary" value="Cargar">
       </td>
       <td width="30%" align="left">
        <input type="submit" name="clean" class="btn btn-primary" value="Limpiar">
       </td>
      </tr>
      <tr>
       <td width="40%" align="right"></td>
       <td width="30"><span class="text-muted">.xls, .xslx</span></td>
       <td width="30%" align="left"></td>
      </tr>
     </table>
    </div>
   </form>
   <br>
   <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title">Datos de los Usuarios</h3>
    </div>
    <div class="panel-body">
     <div class="table-responsive">
      <table class="table table-bordered table-striped">
       <tr>
        <th>ID</th>
        <th>Perfil</th>
        <th>Nombre de Usuario</th>
        <th>Correo</th>
        <th>Contraseña codificada con Hash (no es decifrable)</th>
       </tr>
       @foreach($usuarios as $usuario)
       <tr>
        <td>{{ $usuario->id }}</td> 
        <td>{{ $usuario->fk_cve_perfil_usuario }}</td> 
        <td>{{ $usuario->name }}</td>
        <td>{{ $usuario->email }}</td>
        <td>{{ $usuario->password }}</td>        
       </tr>
       @endforeach
      </table>
      {!! $usuarios->links() !!}
     </div>
    </div>
   </div>
  </div>
 @endsection