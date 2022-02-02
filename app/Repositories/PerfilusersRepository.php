<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Perfilusers;

class PerfilusersRepository extends Controller
{
    private $model;
    public function __construct()
    {        
        $this->model = New Perfilusers();
    }
    public function perfilusers_blank(){                    
        $perfilusers = Perfilusers::FindOrFail(1);
        $perfilusers->cve_perfil_usuario = "";
        $perfilusers->descripcion = "";
        return ($perfilusers);
    }
     public function all()
    {
        $all = $this->model->orderBy('cve_perfil_usuario', 'asc')->paginate(5);
        return( $all);
    }
    public function edit($id)
    {     
        $this->model = $this->model->FindOrFail($id);
        return ( $this->model );
    }
    public function delete( $id)
    {        
        $this->model->destroy($id);
    }
    public function save(Request $request, $id)
    {                
        $campos=[
            'cve_perfil_usuario'=> 'required|string|max:1|min:1',
            'descripcion'=> 'required|string|max:40|min:1',            
        ];
        $mensaje=[            
            'cve_perfil_usuario.required'=>'La Clave del Perfil de Usuario es requerido, al menos 1 caracter.',
            'cve_perfil_usuario.max'=>'La Clave del Perfil de Usuario debe tener 1 caracteres como máximo.',
            'cve_perfil_usuario.min'=>'La Clave del Perfil de Usuario debe tener 1 caracteres como mínimo.',
            'descripcion.required'=> 'La Descripción del Perfil de Usuario es requerida, al menos 1 caracter.',
            'descripcion.max'=>'La Descripción del Perfil de Usuario debe tener 40 caracteres máximo.',            
        ];
        $this->validate( $request, $campos, $mensaje);  
        $datos_perfilusers = $this->fix_datos_perfilusers( $request);                
        $this->model->where('id','=',$id)->update( $datos_perfilusers);
    }
    private function fix_datos_perfilusers($request) 
    {
       // elimina la variables _token , _method, y activao, activa
       $datos_perfilusers = request()->except('_token', '_method', "activao","activa");    
       if ( $request->activao) {
           $datos_perfilusers['activo'] = true;
       } else {
           $datos_perfilusers['activo'] = false;
       };
       return ($datos_perfilusers);
    }
    public function insert( Request $request)
    {   
        $campos=[
            'cve_perfil_usuario'=> 'required|string|unique:perfilusers|max:1|min:1',
            'descripcion'=> 'required|string|unique:perfilusers|max:40|min:1',
        ];
        $mensaje=[            
            'cve_perfil_usuario.required'=>'La Clave del Perfil de Usuario es requerido, al menos 1 caracter.',
            'cve_perfil_usuario.max'=>'La Clave del Perfil de Usuario debe tener 1 caracteres como máximo.',
            'cve_perfil_usuario.min'=>'La Clave del Perfil de Usuario debe tener 1 caracteres como mínimo.',
            'cve_perfil_usuario.unique'=>'La Clave del Perfil fe Usuario ya existe',
            'descripcion.required'=> 'La Descripción del Perfil de Usuario es requerida, al menos 1 caracter.',
            'descripcion.max'=>'La Descripción del Perfil de Usuario debe tener 40 caracteres máximo.',
            'descripcion.unique'=>'La Descripción del Perfil de Usuario ya existe',
        ];     
        //dd($request);
        $this->validate( $request, $campos, $mensaje);
        $datos_perfilusers= $this->fix_datos_perfilusers( $request);
        $this->model->insert( $datos_perfilusers);
    }
}