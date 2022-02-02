@extends('layouts.app')
@section('content')
<div class="container">
<form action="{{ url('/admin/Perfilusers')}}" method="post" enctype="multipart/form-data">
@csrf
@include('/admin/Perfilusers.form',['modo'=>'Crear'])
</form>
</div>
@endsection