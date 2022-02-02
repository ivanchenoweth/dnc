@extends('layouts.app')
@section('content')
<div class="container">
<form action="{{ url('/admin/Periodos/'.$periodo->id) }}" 
    method="post" enctype="multipart/form-data">
    @csrf
    {{ method_field('PATCH')}}
    @include('/admin/Periodos.form',['modo'=>'Editar'])
</form>
</div>
@endsection