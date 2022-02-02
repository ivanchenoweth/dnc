@extends('layouts.app')
@section('content')
<div class="container">
<form action="{{ url('/admin/Plantillas/'.$plantillas->id) }}" 
    method="post" enctype="multipart/form-data">
    @csrf
    {{ method_field('PATCH')}}
    @include('/admin/Plantillas.form',['modo'=>'Editar'])
</form>
</div>
@endsection