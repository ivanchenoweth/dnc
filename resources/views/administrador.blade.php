@extends('layouts.appadmin')
@section('content')
<div class="container">
    @if($success)
          <div class="alert alert-success alert-block">
               <button type="button" class="close" data-dismiss="alert">×</button>
               <strong>{{ $success }}</strong>
          </div>
     @endif
    <div>Administración del Sistema: </div>
    <div>{{$usuario}} </div>
    <div>{{$email}}</div> 
    <div>Verson 1.0.0, fecha 22/11/21</div> 
</div>
@endsection
