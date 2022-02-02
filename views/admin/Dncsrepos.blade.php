@extends('layouts.appcatalogos')
@section('content')
<div class="container">
<form action="{{ url('/admin/Dncsrepos/repo') }}" 
    method="post" enctype="multipart/form-data">
    @csrf
    {{ method_field('POST')}}
     @if(Session::has('mensaje'))
     <div class="alert alert-success alert-dismissible" role="alert">
             {{Session::get('mensaje')}}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
     </div>
     @endif
  <h1> Reporte de Formatos DNC </h1>
     @include('include.periodos')  
    <br>
    <label for="num_emp">Número de Empleado:</label>
     <input type="text" class="form-control input-normal" name="num_emp" id="num_emp" 
     maxlength="10" size="10"
    value="{{$dncs->num_emp}}">
    <br>
    @include('include.dep_uni_area')
    <br>
    <input type="submit" class="btn btn-success" name="repodet" id="repodet" value="Reporte Detallado">
    <input type="submit" class="btn btn-success" name="repodep" id="repodep" value="Reporte por Dependencia">
    </form> 
</div>
@endsection
@include('include.jsperiodos')
@include('include.jsdep_uni_area')
