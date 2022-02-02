@extends('layouts.app')
@section('content')
<div class="container">
<form action="{{ url('/admin/Plantillas')}}" method="post" enctype="multipart/form-data">
@csrf
@include('/admin/Plantillas.form',['modo'=>'Crear'])
</form>
</div>
@endsection