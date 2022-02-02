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
<a href="{{ url('/admin/Periodos/create') }}" class="btn btn-success"> Agregar Nuevo Periodo </a>
<br>
<br>
<table class="table table-light">
  <thead class="thead-light">
	<tr>
		<th>ID</th>
		<th>Cve de Periodo</th>
    <th>Descripción</th>
    <th>Fecha Inicial</th>
    <th>Fecha Final</th>
    <th>Activo</th>
		<th>Acciones</th>
	</tr>
  </thead>
  <tbody>
  @foreach ($Periodos as $Periodo)
	<tr>
		<td>{{ $Periodo->id}}</td>
		<td>{{ $Periodo->cve_periodo}}</td>
    <td>{{ $Periodo->descripcion}}</td>
    <td>{{ substr($Periodo->fecha_ini,0,10)}}</td>
    <td>{{ substr($Periodo->fecha_fin,0,10)}}</td>
    <td>
    <?php
        if ($Periodo->activo) 
        {echo " &#10004 ";
        } else 
        { 
          echo " x ";
        };
      ?>
    </td>
		<td>
        <a href="{{ url('/admin/Periodos/'.$Periodo->id.'/edit') }}" class="btn btn-warning"> Editar
        </a>
        |
        <form action="{{ url('/admin/Periodos/'.$Periodo->id)}}" class="d-inline" method="post" enctype="multipart/form-data">
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
{!! $Periodos->links() !!}
</div>
@endsection