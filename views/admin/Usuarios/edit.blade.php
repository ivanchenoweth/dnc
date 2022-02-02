@extends('layouts.app')
@section('content')
<div class="container">
<form action="{{ url('/admin/Usuarios/'.$usuarios->id) }}" 
    method="post" enctype="multipart/form-data">
    @csrf
    {{ method_field('PATCH')}}
    @include('/admin/Usuarios.form',['modo'=>'Editar'])
</form>
</div>
@endsection