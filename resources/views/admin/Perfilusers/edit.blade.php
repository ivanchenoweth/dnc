@extends('layouts.app')
@section('content')
<div class="container">
<form action="{{ url('/admin/Perfilusers/'.$perfilusers->id) }}" 
    method="post" enctype="multipart/form-data">
    @csrf
    {{ method_field('PATCH')}}
    @include('/admin/Perfilusers.form',['modo'=>'Editar'])
</form>
</div>
@endsection