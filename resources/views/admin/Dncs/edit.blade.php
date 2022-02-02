@extends('layouts.app')
@section('content')
<div class="container">
<form action="{{ url('/admin/Dncs/'.$dncs->id) }}" 
    method="post" enctype="multipart/form-data">
    @csrf
    {{ method_field('PATCH')}}
    @include('/admin/Dncs.form',['modo'=>'Editar'])
</form>
</div>
@endsection