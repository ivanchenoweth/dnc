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
<a href="{{ url('/admin/Plantillas/create') }}" 
  class="btn btn-success"> Agregar Nueva Plantilla </a>
<br>
<br>
<table class="table table-light">
  <thead class="thead-light">
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
  </thead>
  <tbody>
  @foreach ($plantillas as $plantilla)
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
		<td>
        <a href="{{ url('/admin/Plantillas/'.$plantilla->id.'/edit') }}" class="btn btn-warning"> Editar
        </a>
        <form action="{{ url('/admin/Plantillas/'.$plantilla->id)}}" 
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
{!! $plantillas->links() !!}
</div>
@endsection