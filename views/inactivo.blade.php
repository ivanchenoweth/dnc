@extends('layouts.app')
@section('content')
<div class="container">
<tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;page-break-inside:avoid;
         height:18.6pt'>  
<br>
<br>
<div>Estimado(a) usuario, el tipo de usuario o usuario encuentra inactivo
<br> Favor de comunicarse a los teléfonos (662) 213 7975 y (662) 212 0810 y proporcionar los datos siguientes:
<br> Correo del Usuario: <strong>{!! $correo_usuario !!}</strong> 
<br> Tipo de Usuario: <strong>{!! $perfil_usuario !!}</strong> 
<br>
<br>
</div>
<td width=570 style='width:1.0cm;border:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;
               mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
               mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 3.5pt 0cm 3.5pt;                         
               height:17.35pt'>
        <a href='/' class="btn btn-primary">Aceptar</a>        
</td>
</tr>
</div>
@endsection