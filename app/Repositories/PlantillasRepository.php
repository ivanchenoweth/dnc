<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

// Necesario para la clase Session
use Session;
use Auth;
use Excel;

use App\Models\Plantillas;
use App\Models\Perfilusers;
use App\Models\User;
use App\Models\Periodos;

use App\Imports\PlantillasImport;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

class PlantillasRepository extends Controller
{
    //use WithFileUploads;

    private $model;
    public function __construct()
    {        
        $this->model = New Plantillas();
    }    
    // completa la vista del Usuario normal Evaluador!!
    public function index()
    {
        //dd("aqui");
        $datos = [
            "usuario"=>Auth::user()->name,
            "cve_perfil_usuario"=>Auth::user()->fk_cve_perfil_usuario,
            "email"=>Auth::user()->email,
            "success"=>""
        ];
        //dd("USUARIO MORTAL");
        $plantillas = DB::table('plantillas')
        ->orderBy('id', 'ASC')            
        ->select(
                'plantillas.id',                
                'plantillas.num_emp',
                'plantillas.nombre_completo',
                'plantillas.sexo',
                'plantillas.nivel',
                'plantillas.dependencia',
                'plantillas.unidad_admva',
                'plantillas.puesto',
                'plantillas.municipio',
                'plantillas.plaza',
                'plantillas.tipo_plaza',
                'plantillas.fuente',
                'plantillas.plantilla',
                'plantillas.tipo_org',
                'plantillas.num_plaza',
                'plantillas.activo'
                )                
                ->where('plantillas.activo',true)
                ->get();
        //dd($plantillas);
        if ($plantillas>isEmpty())
        { 
            $vista= back()->with("Error, tabla plantillas vacía o empleado(a) inactivo(a).");
            //dd($vista);
            return $vista;
        };
        //dd($plantillas);
         $vista= view('consideraciones',$datos);
         return $vista;
    }
    // completa la vista del Administrador!!
    public function indexAdmin()
    {
        //dd("aqui");
        $datos = [
            "usuario"=>Auth::user()->name,
            "cve_perfil_usuario"=>Auth::user()->fk_cve_perfil_usuario,
            "email"=>Auth::user()->email,            
            "success"=>""
        ];
        $datos['success']  = "Tenga cuidado con estas opciones";
        $vista = view('administrador',$datos);     
        return $vista;
    }
    public function perfil_usuarios()
    {
        return( Perfilusers::all()->SortBy('cve_perfil_usuario'));
    }
    public function usuarios()
    {        
        return( User::all()->SortBy('email'));
    }
    public function periodos()
    {        
        return( Periodos::all()->SortBy('cve_perdiodo'));
    }
    public function all()
    {   
        return( $this->model->orderBy('num_emp', 'asc')->paginate(5));
    }
    public function plantillas_blank(){
        $plantillas = Plantillas::FindOrFail(1);
        $plantillas->num_emp = "";
        $plantillas->nombre_completo = "";
        $plantillas->sexo = "";
        $plantillas->nivel = "";
        $plantillas->dependencia = "";
        $plantillas->unidad_admva = "";
        $plantillas->puesto = "";
        $plantillas->municipio = "";
        $plantillas->plaza = "";
        $plantillas->tipo_plaza = "";
        $plantillas->fuente = "";
        $plantillas->plantilla = "";
        $plantillas->tipo_org = "";
        $plantillas->num_plaza = "";
        $plantillas->activo = true;
        return ( $plantillas);
    }
    public function insert( Request $request)
    {
        $campos=        $this->get_campos_val();
        $mensajes=      $this->get_mensajes_val();
        $this->validate( $request, $campos, $mensajes);
        $plantillas= $this->fix_datos_plantillas( $request);
        $this->model->insert( $plantillas);
    }
    private function fix_datos_plantillas( $request) 
    {
        // elimina la variables _token , _method, y activao
        $datos_plantillas = request()->except('_token', '_method', "activao","activa");
        $datos_plantillas['activo'] = filter_var($request->activao, FILTER_VALIDATE_BOOLEAN);                    
        //dd( $datos_plantillas);        
        return ($datos_plantillas);
    }
    public function edit( $id)
    {             
        $this->model = $this->model->FindOrFail( $id);            
        //dd( $this->model);
        return ( $this->model );
    }
    public function save(Request $request, $id)
    {
        $campos=        $this->get_campos_val();
        $mensajes=      $this->get_mensajes_val();
        $this->validate( $request, $campos, $mensajes);
        $datos_plantillas = $this->fix_datos_plantillas( $request);
        //dd($datos_plantillas);
        $this->model->where('id', '=', $id)->update( $datos_plantillas);
    }
    public function get_campos_val()
    {
        $campos=[            
            'num_emp'=> 'required|digits_between:1,999999999999',
            'nombre_completo'=> 'required|string|max:60|min:5',
            'sexo'=> 'required|string|max:10|min:1',
            'nivel'=> 'required|string|max:5|min:1',
            'dependencia'=> 'required|string|max:120|min:5',
            'unidad_admva'=> 'required|string|max:180|min:5',
            'puesto'=> 'required|string|max:80|min:5',
            'municipio'=> 'required|string|max:180|min:5',
            'plaza'=> 'required|string|max:10|min:1',
            'tipo_plaza'=> 'required|string|max:60|min:1',
            'fuente'=> 'required|string|max:10|min:1',
            'plantilla'=> 'required|string|max:10|min:1',
            'tipo_org'=> 'required|string|max:20|min:1',
            'num_plaza'=> 'required|string|max:5|min:1',
        ];
        return $campos;
    }
    public function get_mensajes_val()
    {
        $mensajes=[            
            'num_emp.required'=>'El Número de Empleado es requerido y debe ser numérico',
            'num_emp.min'=>'El Número de Empleado debe ser numérico, entero y mayor que cero.',
            'num_emp.max'=>'El Número de Empleado debe ser numérico, entero y menor o igual a 999999999.',
            'nombre_completo.required'=>'El Nombre de Empleado es requerido y debe iniciar por los apellidos',
            'nombre_completo.min'=>'El Nombre del Empleado debe tener al menos 5 caracteres.',
            'nombre_completo.max'=>'El Nombre del Empleado debe tener como máximo 80 caracteres.',
            'sexo.required'=>'El Sexo del Empleado debe especificarse, normalmente MASCULINO o FEMENINO con mayúsculas',
            'sexo.min'=>'El Sexo del Empleado debe tener al menos 1 caracter.',
            'sexo.max'=>'El Sexo del Empleado debe tener como máximo 10 caracteres.',
            'nivel.required'=>'El Nivel debe especificarse, normalmente MASCULINO o FEMENINO',
            'nivel.min'=>'El Nivel debe tener al menos 1 caracter.',
            'nivel.max'=>'El Nivel debe tener como máximo 5 caracteres.',
            'dependencia.required'=>'La Dependencia o Entidad debe especificarse',
            'dependencia.min'=>'La Dependencia o Entidad debe tener al menos 5 caracteres.',
            'dependencia.max'=>'La Dependencia o Entidad debe tener como máximo 120 caracteres.',
            'unidad_admva.required'=>'La Unidad Administrativa debe especificarse',
            'unidad_admva.min'=>'La Unidad Administrativa debe tener al menos 5 caracteres.',
            'unidad_admva.max'=>'La  Unidad Administrativa debe tener como máximo 120 caracteres.',
            'puesto.required'=>'El Puesto debe especificarse',
            'puesto.min'=>'El Puesto debe tener al menos 5 caracteres.',
            'puesto.max'=>'El Puesto debe tener como máximo 80 caracteres.',
            'municipio.required'=>'El Municipio debe especificarse',
            'municipio.min'=>'El Municipio debe tener al menos 5 caracteres.',
            'municipio.max'=>'El Municipio debe tener como máximo 180 caracteres.',
            'plaza.required'=>'La Plaza debe especificarse',
            'plaza.min'=>'La Plaza debe tener al menos 1 caracter.',
            'plaza.max'=>'La Plaza debe tener como máximo 10 caracteres.',
            'tipo_plaza.required'=>'El Tipo de Plaza debe especificarse',
            'tipo_plaza.min'=>'El Tipo de Plaza debe tener al menos 1 caracter.',
            'tipo_plaza.max'=>'El Tipo de Plaza debe tener como máximo 60 caracteres.',
            'fuente.required'=>'La Fuente debe especificarse',
            'fuente.min'=>'La Fuente debe tener al menos 1 caracter.',
            'fuente.max'=>'La Fuente debe tener como máximo 10 caracteres.',
            'plantilla.required'=>'La Plantilla debe especificarse',
            'plantilla.min'=>'La Plantilla debe tener al menos 1 caracter.',
            'plantilla.max'=>'La Plantilla debe tener como máximo 10 caracteres.',
            'tipo_org.required'=>'El Tipo de Organismo debe especificarse',
            'tipo_org.min'=>'El Tipo de Organismo debe tener al menos 1 caracter.',
            'tipo_org.max'=>'El Tipo de Organismo debe tener como máximo 5 caracteres.',
            'num_plaza.required'=>'El Tipo de Organismo debe especificarse',
            'num_plaza.min'=>'El Tipo de Organismo debe tener al menos 1 caracter.',
            'num_plaza.max'=>'El Tipo de Organismo debe tener como máximo 5 caracteres.',
        ];
        return $mensajes;
    }
    public function es_administrador() 
    {
      if (Auth::user()->fk_cve_perfil_usuario != "A") 
      {
        return back()->with('success', 'Error, solo pueden ingresar los Administradores.');  
      }
      return "Si";
    }
    public function import(Request $request) 
    {
      //dd("imp_rep");
      if ($request->clean == 'Limpiar')
      {
          DB::table('plantillas')->where('id', '>', 1)->delete();
          return back()->with('success', 'Tabla de Plantillas limpiada, excepto el primer registro.');
      } // end if ($clean)
      else 
      {
        return $this->import_old( $request);
      } // end else $clean == 'Limpiar'
    } // end import function  
    public function get_user_data() 
    {
      $datos=[
        "usuario"=>Auth::user()->name,
        "email"=>Auth::user()->email,
        "success"=>"Error, Solo pueden entrar Administradores a esta opción"
      ]; 
      return $datos;
    }

  public function import_new( Request $request)
  {
   // $datos= $this->get_user_data();
   $this->validate($request, 
      [ 'select_file'  => 'required|mimes:xls,xlsx'   ], 
      [ 'select_file.required'=>'Se pide un archivo de Excel con extensión .xls o .xlsx' ]
    );    
    $path = storage_path('app').'/'.$request->file('select_file')->store('temp');
    Excel::import(new PlantillasImport, $path);
    $existentes= 0;
    $suma= 0;
    return back()->with('success', 
        'El archivo de Plantillas de Excel se subió con éxito. '.
        "Se repitieron ".$existentes." registro(s)".
        " y se subieron ".$suma. " registro(s).");
      //$data = Excel::import(new UsersImport,$path);
      //return back()->with('success', 'El archivo de Uusarios de Excel se subió con éxito.');
  }
  public function import3( Request $request)
    {
        //dd("hey");
        //$this->validate([ 'importFile' => 'required']);

        $this->importing = true;
        $this->importFilePath = storage_path('app').'/'.$request->file('select_file')->store('temp');
        //dd($this);
        
        //(new PlantillasImport)->queue($this->importFilePath)
        //Excel::queueImport((new PlantillasImport)->queue($this->importFilePath), $this->importFilePath);
        //Excel::import(new PlantillasImport, $this->importFilePath);
        $batch = Bus::batch([
            new ImportJob($this->importFilePath),
        ])->dispatch();

        $this->batchId = $batch->id;
        //dd("hey");
    }
  
  public function import_old( Request $request)
  {
    // $datos= $this->get_user_data();
    //ini_set('memory_limit', '-1');

    $this->validate($request, 
      [ 'select_file'  => 'required|mimes:xls,xlsx,csv'   ], 
      [ 'select_file.required'=>'Se pide un archivo de Excel con extensión .xls o .xlsx, o delimitado por comas csv' ]
    );
    $path1 = $request->file('select_file')->store('temp'); 
    $path = storage_path('app').'/'.$path1;
    if (strpos($path, "xls")) {
      return  $this->import_excel( $request, $path);
    }
    dd($path);
    try {
    
    } 
    catch (\Illuminate\Database\QueryException $e) 
    {
        return back()->with('success', 'Ocurrió un error:  '.$e->errorInfo[2]);
    } // end catch
  }

  public function import_excel( Request $request, $path)
  {           
    //dd("xls");
      //dd($path1);
      ini_set('memory_limit', '-1');
      set_time_limit(1600);
      //ini_set('max_execution_time', 120); 
      //set_time_limit(0);
      $data = Excel::toCollection(new PlantillasImport, $path); 
      //dd($path1);
      //$data = Excel::import(new PlantillasImport, $path);
      $existentes  = 0;
      $suma        = 0;
      //dd( $data);
      if($data->count() > 0)
      {       
       foreach($data->toArray() as $key => $value)
       {            
        foreach($value as $row)
        {
          //dd( $row);
          //dd(count($row) );
          if (! (               
            isset($row['num_emp']) &&
            isset($row['nombre_completo']) &&
            isset($row['sexo']) &&
            isset($row['nivel']) &&
            isset($row['dependnecia']) &&
            isset($row['unidad_admva']) &&
            isset($row['puesto']) &&
            isset($row['municipio']) &&
            isset($row['plaza']) &&
            isset($row['tipo_plaza']) &&
            isset($row['fuente']) &&
            isset($row['plantilla']) &&
            isset($row['tipo_org']) &&
            isset($row['num_plaza'])   
            ))
          {  
            $msg= 'Error: El archivo de Excel de Plantillas debe tener las columnas siguientes : '.
            "num_emp, nombre_completo, sexo, nivel, dependencia, unidad_admva, ".
            "puesto, municipio, plaza, tipo_plaza, fuente, plantilla, tipo_org, num_plaza. ".
            "Alguno de ellos esta faltando. ".
            "Vea la documentación Técnica para importar Plantillas.";
            //dd($msg);
            //dd($row);
            //return back()->with('success', $msg);
          } // end if(!)
          //dd( $data);
          //dd($row);
          $plantillas = DB::table('plantillas')
            ->where('num_emp',      $row['num_emp'])
            ->where('dependencia',  $row['dependencia'])
            ->get();
          //dd( $plantillas);
          if ( $plantillas->isNotEmpty()) 
          {
            $existentes= $existentes + 1;
          }
          else 
          { 
            $insert_data[] = array(                
                'num_emp'               => $row['num_emp'],
                'nombre_completo'       => $row['nombre_completo'],
                'sexo'                  => $row['sexo'],
                'nivel'                 => $row['nivel'],
                'dependencia'           => $row['dependencia'],
                'unidad_admva'          => $row['unidad_admva'],
                'puesto'                => $row['puesto'],
                'municipio'             => $row['municipio'],
                'plaza'                 => $row['plaza'],
                'tipo_plaza'            => $row['tipo_plaza'],                    
                'fuente'                => $row['fuente'],
                'plantilla'             => $row['plantilla'],
                'tipo_org'              => $row['tipo_org'],
                'num_plaza'             => $row['num_plaza']
                );                 
          } // end if( $row)
        } // end foreach($value as $row)
       } // end foreach($data->toArray() as $key => $value)
       //dd( $insert_data);
       if(!empty( $insert_data))
       {
        //dd($insert_data);
        $suma = count($insert_data);
        foreach (array_chunk($insert_data,1000) as $t) 
        {
            DB::table('plantillas')->insert($t);
        }
        //dd($suma);
       } // end if(!empty)
      } // end if($data)
      $msg = 'El archivo de Plantillas de Excel se subió con éxito. '.
      "Se repitieron ".$existentes." registro(s)".
      " y se subieron ".$suma. " registro(s).";
      //dd($msg);
      return back()->with('success', $msg);      
      //$data = Excel::import(new UsersImport,$path);
      //return back()->with('success', 'El archivo de Uusarios de Excel se subió con éxito.');    
  } 
}