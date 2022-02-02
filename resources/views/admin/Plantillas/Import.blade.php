@extends('layouts.appcatalogos')
@section('content')
  <div class="container">
   <h3 align="center">Importar Archivo de Plantillas de Personal de Excel al Sistema</h3>
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
   <form method="post" enctype="multipart/form-data" action="{{ url('/admin/importPlantillas/import') }}">
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
     <h3 class="panel-title">Datos de las Plantillas</h3>
    </div>
    <div class="panel-body">
     <div class="table-responsive">
      <table class="table table-bordered table-striped">
       <tr>
    <th>ID</th>
		<th>Num.Emp</th>
    <th>Nombre Completo</th>    
    <th>Sexo</th>
    <th>Nivel</th>
    <th>Dependencia o Entidad</th>
    <th>Unidad Administrativa</th>
    <th>Puesto</th>
    <th>Municipio</th>
    <th>Plaza</th>    
    <th>Tipo de Plaza</th>
    <th>Fuente</th>
    <th>Plantilla</th>
    <th>Tipo de Organismo</th>
    <th>Num.Plaza</th>
    <th>Activo</th>
    </tr>
    @foreach($plantillas as $plantilla)    
	<tr>
		<td>{{ $plantilla->id}}</td>
    <td>{{ $plantilla->num_emp}}</td>
    <td>{{ $plantilla->nombre_completo}}</td>
    <td>{{ $plantilla->sexo}}</td>
    <td>{{ $plantilla->nivel}}</td>
    <td>{{ $plantilla->dependencia}}</td>
    <td>{{ $plantilla->unidad_admva}}</td>
    <td>{{ $plantilla->puesto}}</td>
    <td>{{ $plantilla->municipio}}</td>
    <td>{{ $plantilla->plaza}}</td>
    <td>{{ $plantilla->tipo_plaza}}</td>
    <td>{{ $plantilla->fuente}}</td>
    <td>{{ $plantilla->plantilla}}</td>
    <td>{{ $plantilla->tipo_org}}</td>
    <td>{{ $plantilla->num_plaza}}</td>
    <td>{{ $plantilla->activo}}</td>
    <td>
      <?php
        if ($plantilla->activo) 
        {echo " &#10004 ";
        } else 
        { 
          echo " x ";
        };
      ?>
    </td>
       </tr>
       @endforeach
      </table>
      {!! $plantillas->links() !!}
     </div>
    </div>
   </div>
  </div>
 @endsection