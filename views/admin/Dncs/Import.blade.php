@extends('layouts.appcatalogos')
@section('content')
  <div class="container">
   <h3 align="center">Importar Archivo de Formatos DNC de Excel al Sistema</h3>
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
   <form method="post" enctype="multipart/form-data" action="{{ url('/admin/importDncs/import') }}">
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
     <h3 class="panel-title">Datos de los Formatos DNC</h3>
    </div>
    <div class="panel-body">
     <div class="table-responsive">
      <table class="table table-bordered table-striped">
       <tr>
       <th>ID</th>
    <th>Periodo</th>
		<th>Num.Emp</th>
    <th>Nombre</th>
    <th>Dependencia o Entidad</th>
    <th>Unidad Administrativa</th>
    <th>Area</th>
    <th>Grado de Estudios</th>    
    <th>Correo</th>    
    <th>Telefono</th>
    <th>Funciones</th>
    <th>Word Itermedio</th>
    <th>Word Avanzado</th>
    <th>Excel Itermedio</th>
    <th>Excel Avanzado</th>
    <th>Power Point</th>
    <th>Nuevas Tecnologías</th>
    <th>Acciones Institucionales</th>
    <th>Acciones de Desarrollo Humano</th>
    <th>Acciones Administrativas</th>
    <th>Otros Cursos</th>
    <th>Int.Ist.</th>
    <th>Curso a Impartir</th>
    <th>Activo</th>
       </tr>
       @foreach($dncs as $dnc)
       <tr>
       <td>{{ $dnc->id}}</td>
    <td>      
      <?php
        foreach ($periodos as $periodo) {
           if ($periodo->cve_periodo == $dnc->fk_cve_periodo) 
           {
             echo $periodo->descripcion;
           };
          };
      ?>
    </td>    
    <td>{{ $dnc->num_emp}}</td>
    <td>{{ $dnc->nombre_completo}}</td>
    <td>{{ $dnc->dep_o_ent}}</td>
    <td>{{ $dnc->unidad_admva}}</td>
    <td>{{ $dnc->area}}</td>
    <td>{{ $dnc->grado_est}}</td>
    <td>{{ $dnc->correo}}</td>
    <td>{{ $dnc->telefono}}</td>
    <td>{{ $dnc->funciones}}</td>
    <td>{{ $dnc->word_int}}</td>
    <td>{{ $dnc->word_ava}}</td>
    <td>{{ $dnc->excel_int}}</td>
    <td>{{ $dnc->excel_ava}}</td>
    <td>{{ $dnc->power_point}}</td>
    <td>{{ $dnc->nuevas_tec}}</td>
    <td>{{ $dnc->acc_institucionales}}</td>
    <td>{{ $dnc->acc_des_humano}}</td>
    <td>{{ $dnc->acc_administrativas}}</td>
    <td>{{ $dnc->otro_curso}}</td>
    <td>{{ $dnc->interes_instructor}}</td>
    <td>{{ $dnc->tema}}</td>
       </tr>
       @endforeach
      </table>
      {!! $dncs->links() !!}
     </div>
    </div>
   </div>
  </div>
 @endsection