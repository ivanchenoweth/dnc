<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Periodos;

class PeriodosRepository extends Controller
{
    private $model;
    public function __construct()
    {        
        $this->model = New Periodos();
    }
    public function Periodo_blank(){
        $periodo = Periodos::FindOrFail(1);
        $periodo->cve_periodo = "";
        $periodo->descripcion = "";
        $periodo->fecha_ini = "";
        $periodo->fecha_fin = "";
        return ($periodo);
    }
     public function all()
    {
        return( $this->model->orderBy('cve_periodo', 'asc')->paginate(5));
    }
    public function edit($id)
    {     
        $this->model = $this->model->FindOrFail($id);
        $this->model->cve_area = substr( $this->model->cve_area, 4, 2);
        return ( $this->model );
    }

    public function delete( $id)
    {        
        $this->model->destroy($id);
    }
    public function save(Request $request, $id)
    {        
        /* Validacion ESTRICTA
        $campos=[
            'cve_periodo'=> 'required|string|unique:periodos|max:3|min:1',
            'descripcion'=> 'required|string|unique:periodos|max:120|min:1',
            'fecha_ini'=> 'required|date|unique:periodos',
            'fecha_fin'=> 'required|date|unique:periodos',
        ];

        $mensaje=[            
            'cve_periodo.required'=>'La Clave del Periodo es requerido, al menos 1 caracter.',
            'cve_periodo.max'=>'La Clave del Periodo debe tener 3 caracteres máximo.',
            'cve_periodo.unique'=>'La Clave del periodo ya existe',
            'descripcion.required'=> 'La Descripción del Periodo es requerida, al menos 1 caracter.',
            'descripcion.unique'=> 'La Descripción del Periodo ya existe.',
            'descripcion.max'=>'La Descripción del Periodo debe tener 120 caracteres máximo.',
            //'fecha_ini.gt'=>'La fecha inicial del periodo debe ser menor que la final.',
            'fecha_ini.required'=> 'Es necesario capturar la fecha de inicio del Periodo.',
            'fecha_ini.unique'=> 'La fecha de inicio ya existe.',
            'fecha_fin.required'=> 'Es necesario capturar la fecha final del Periodo.',
            'fecha_fin.unique'=> 'La fecha final ya existe.',
        ];
        */
        $campos=[
            'cve_periodo'=> 'required|string|max:3|min:1',
            'descripcion'=> 'required|string|max:120|min:1',
            'fecha_ini'=> 'required|date|after:1 January 2001',
            'fecha_fin'=> 'required|date|after_or_equal:fecha_ini',
        ];

        $mensaje=[            
            'cve_periodo.required'=>'La Clave del Periodo es requerido, al menos 1 caracter.',
            'cve_periodo.max'=>'La Clave del Periodo debe tener 3 caracteres máximo.',
            'descripcion.required'=> 'La Descripción del Periodo es requerida, al menos 1 caracter.',
            'descripcion.max'=>'La Descripción del Periodo debe tener 120 caracteres máximo.',
            'fecha_ini.required'=> 'Es necesario capturar la fecha de inicio del Periodo.',
            'fecha_ini.after'=> 'Es necesario que la fecha de inicio del Periodo sea mayor que 1/1/2001.',
            'fecha_fin.required'=> 'Es necesario capturar la fecha final del Periodo.',
            'fecha_fin.after_or_equal'=> 'Es necesario que la fecha final sea mayor o igual que la inicial.',
        ];        
        $this->validate( $request, $campos, $mensaje);  
        $datos_periodo = $this->fix_datos_periodo( $request);                
        $this->model->where('id','=',$id)->update( $datos_periodo);
    }
    private function fix_datos_periodo($request) 
    {
        // elimina la variables _token , _method, y activao, activa
        $datos_periodo = request()->except('_token', '_method', "activao","activa");
    
       if ( $request->activao) {
           $datos_periodo['activo'] = true;
       } else {
           $datos_periodo['activo'] = false;
       };
       return ($datos_periodo);
    }
    public function insert( Request $request)
    {      
        $campos=[
            'cve_periodo'=> 'required|string|unique:periodos|max:3|min:1',
            'descripcion'=> 'required|string|unique:periodos|max:120|min:1',
            'fecha_ini'=> 'required|date|after:1 January 2001',
            'fecha_fin'=> 'required|date|after_or_equal:fecha_ini',
        ];
        $mensaje=[            
            'cve_periodo.required'=>'La Clave del Periodo es requerido, al menos 1 caracter.',
            'cve_periodo.max'=>'La Clave del Periodo debe tener 3 caracteres máximo.',
            'cve_periodo.unique'=>'La Clave del periodo ya existe',
            'descripcion.required'=> 'La Descripción del Periodo es requerida, al menos 1 caracter.',
            'descripcion.max'=>'La Descripción del Periodo debe tener 120 caracteres máximo.',
            'fecha_ini.required'=> 'Es necesario capturar la fecha de inicio del Periodo.',
            'fecha_ini.after'=> 'Es necesario que la fecha de inicio del Periodo sea mayor que 1/1/2001.',
            'fecha_fin.required'=> 'Es necesario capturar la fecha final del Periodo.',
            'fecha_fin.after_or_equal'=> 'Es necesario que la fecha final sea mayor o igual que la inicial.',
        ];       
        $this->validate( $request, $campos, $mensaje);
        $datos_periodo= $this->fix_datos_periodo( $request);
        $this->model->insert( $datos_periodo);
    }
}