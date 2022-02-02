@extends('layouts.app')
@section('content')
<?php
    use App\Http\Controllers\DncsController;
?>
  <div class="container">
     @if($success)
          <div class="alert alert-success alert-block">
               <button type="button" class="close" data-dismiss="alert">×</button>
               <strong>{{ $success }}</strong>
          </div>
     @endif
    <div>Datos del Usuario=>Nombre: {{$usuario}} , Correo: {{$email}}
    </div>
    <table class="table table-bordered table-striped">
    <tr>
        <th>No.</th>
        <th>Periodo</th>
	    <th>Num.Emp</th>
        <th>Nombre</th>
        <th>Dependencia o Entidad</th>
        <th>Unidad Administrativa</th>
        <th>Area</th>
        <th>Grado de Estudios</th>    
        <th>Correo</th>    
        <th>Telefono</th>        
        <th>Int.Ist.</th>        
    </tr>
    @foreach($dncs as $dnc)
    <tr> 
         <td>{!! $dnc->id !!}</td>
         <td>      
         <?php
            foreach ($periodos as $periodo) 
            {
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
         </tr>
    @endforeach    
    </table>
  </div>
 @endsection