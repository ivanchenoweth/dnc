@extends('layouts.appcatalogos')
@section('content')
<div class="container">
@if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{Session::get('mensaje')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<a href="{{ url('/admin/Dncs/create') }}" 
  class="btn btn-success"> Agregar Nuevo Formato DNC </a>
<br>
<br>
<table class="table table-light">
  <thead class="thead-light">
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
  </thead>
  <tbody>
  @foreach ($dncs as $dnc)
	<tr>
		<td>{{ $dnc->id}}</td>    
    <td>      
      <?php 
      /*       
        foreach ($periodos as $periodo) {
           //dd($periodo);
           if ($periodo->cve_periodo == $dnc->fk_cve_periodo) 
           {
             echo $periodo->descripcion;
           };
          };
          */
          echo $dnc->fk_cve_periodo;
      ?>
    </td>    
    <td>{{ $dnc->num_emp }}</td>
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
    <td>
      <?php
        if ($dnc->activo) 
        {echo " &#10004 ";
        } else 
        { 
          echo " x ";
        };
      ?>
    </td>
		<td>
        <a href="{{ url('/admin/Dncs/'.$dnc->id.'/edit') }}" class="btn btn-warning"> Editar
        </a>
        <form action="{{ url('/admin/Dncs/'.$dnc->id)}}" 
            class="d-inline" method="post" enctype="multipart/form-data">
            @csrf
            {{ method_field('DELETE') }}
            <input type="submit" onclick="return confirm('¿Quieres borrar?')" 
	        value="Borrar" class="btn btn-danger">
        </form>
        </td>
	</tr>
  @endforeach
  </tbody>
</table>
{!! $dncs->links() !!}
</div>
@endsection