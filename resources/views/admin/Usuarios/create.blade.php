@extends('layouts.app')
@section('content')
<div class="container">
<form action="{{ url('/admin/Usuarios')}}" method="post" enctype="multipart/form-data">
@csrf
@include('/admin/Usuarios.form',['modo'=>'Crear'])
</form>
</div>
@endsection