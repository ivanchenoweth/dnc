<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use DB;
use Session;
use Excel;
use Auth;

use App\Imports\UsersImport;

use App\Models\User;
use App\Models\Perfilusers;

class UsuariosRepository extends Controller
{
    private $model;
    public function __construct()
    {        
        $this->model = New User();
    }
    public function es_administrador() 
    {
      if (Auth::user()->fk_cve_perfil_usuario != "A") 
      {
        return back()->with('success', 'Error, solo pueden ingresar los Administradores.');  
      }
      return "Si";
    }
    public function perfil_usuarios()
    {
        return( Perfilusers::all()->SortBy('cve_perfil_usuario'));
    }
    public function usuarios_blank(){                    
        $usuarios = User::FindOrFail(1);
        $usuarios->fk_cve_perfil_usuario = "U";
        $usuarios->descripcion = "";
        $usuarios->activo = true;
        return ( $usuarios);
    }
    public function all()
    {                      
        return $this->model->orderBy('email', 'asc')->paginate(5);
    }

    public function edit( $id)
    {     
        //dd($id);
        $this->model = $this->model->FindOrFail( $id);
        //dd( $this->model);
        return ( $this->model );
    }
    public function delete( $id)
    {        
        $this->model->destroy( $id);
    }
    public function save(Request $request, $id)
    {                 
        $campos=[
            'fk_cve_perfil_usuario'=> 'required|string|max:1|min:1',
            'name'=> 'required|string|max:80|min:1',
            'email'=> 'required|string|max:80|min:1',
            'password'=> 'required|string|max:80|min:1',
        ];
        $mensaje=[            
            'fk_cve_perfil_usuario.required'=>'La Clave del Perfil de Usuario es requerido, al menos 1 caracter.',
            'name.required'=> 'El Nombre del Usuario es requerido.',
            'name.min'=> 'El Nombre del Usuario debe tener 1 caracteres como mínimo.',
            'name.max'=> 'El Nombre del Usuario debe tener 80 caracteres como máximo.',
            'email.required'=> 'El Correo del Usuario es requerido.',
            'email.min'=> 'El Correo del Usuario debe tener 1 caracteres como mínimo.',
            'email.max'=> 'El Correo del Usuario debe tener 80 caracteres como máximo.',
            'password.required'=> 'La Contraseña del Usuario es requerido.',
            'password.min'=> 'La Contraseña del Usuario debe tener 1 caracteres como mínimo.',
            'password.max'=> 'La Contraseña del Usuario debe tener 80 caracteres como máximo.',
        ];
        $this->validate( $request, $campos, $mensaje);        
        $datos_usuarios = $this->fix_datos_usuarios( $request);
        //dd($datos_usuarios);
        $this->model->where('id', '=', $id)->update( $datos_usuarios);
    }
    private function fix_datos_usuarios( $request) 
    {
        // elimina la variables _token , _method, y activao
        $datos_usuarios = request()->except('_token', '_method', "activao","activa");
        $datos_usuarios['activo'] = filter_var($request->activao, FILTER_VALIDATE_BOOLEAN);    
        $datos_usuarios['password'] = Hash::make($datos_usuarios['password']);
        return ($datos_usuarios);
    }
    public function insert( Request $request)
    {   
        $campos=[
            'fk_cve_perfil_usuario'=> 'required|string|max:1|min:1',
            'name'=> 'required|string|max:80|min:1',
            'email'=> 'required|string|unique:users|max:80|min:1',
            'password'=> 'required|string|max:80|min:1',
        ];
        $mensaje=[            
            'fk_cve_perfil_usuario.required'=>'La Clave del Perfil de Usuario es requerido, al menos 1 caracter.',
            'name.required'=> 'El Nombre del Usuario es requerido.',
            'name.min'=> 'El Nombre del Usuario debe tener 1 caracteres como mínimo.',
            'name.max'=> 'El Nombre del Usuario debe tener 80 caracteres como máximo.',
            'email.required'=> 'El Correo del Usuario es requerido.',
            'email.unique'=> 'El Correo del Usuario ya existe.',
            'email.min'=> 'El Correo del Usuario debe tener 1 caracteres como mínimo.',
            'email.max'=> 'El Correo del Usuario debe tener 80 caracteres como máximo.',
            'password.required'=> 'La Contraseña del Usuario es requerido.',
            'password.min'=> 'La Contraseña del Usuario debe tener 1 caracteres como mínimo.',
            'password.max'=> 'La Contraseña del Usuario debe tener 80 caracteres como máximo.',
        ];   
        //dd($request);
        $this->validate( $request, $campos, $mensaje);
        $datos_usuarios= $this->fix_datos_usuarios( $request);
        //dd($datos_usuarios);
        $this->model->insert( $datos_usuarios);
    }
    public function import(Request $request) 
    {
      $datos= $this->get_user_data();
      //dd("hey");      
      $clean = $request->clean;
      if ( $clean == 'Limpiar')
      {
          DB::table('users')->where('id', '>', 2)->delete();
          return back()->with('success', 'Base de datos limpiada, excepto los primeros 2 registros.');  
      } // end if ($clean
      else 
      {
        $this->validate($request, 
          [ 'select_file'  => 'required|mimes:xls,xlsx'   ], 
          [ 'select_file.required'=>'Se pide un archivo de Excel con extensión .xls o .xlsx' ]
        );
        $path1 = $request->file('select_file')->store('temp'); 
        $path = storage_path('app').'/'.$path1;          
        try 
        {
          //dd($path1);
          $data = Excel::toCollection(new UsersImport, $path);
          //$this->importUsuariosRepository->          
          $existentes = 0;
          if($data->count() > 0)
          {
           foreach($data->toArray() as $key => $value)
           {
            foreach($value as $row)
            {
              //dd($insert_data);
              if (! (               
                isset($row['nombre']) &&
                isset($row['correo']) &&
                isset($row['contrasenia']) 
                ))
              {
                  return back()->with('success', 
                  'Error: El archivo de Excel de Usuarios debe tener las columnas siguientes : '.
                  "nombre, correo y contrasenia. Alguno de ellos esta faltando."
                );
              } // end if(!)
              $users = DB::table('users')->where('name', $row['nombre'])->get();              
              if ($users->isNotEmpty()) 
              {
                $existentes= $existentes + 1;
              } // end if ($users
              else
              {                
               $insert_data[] = array(                
                'name'   => $row['nombre'],
                'password'   => Hash::make($row['contrasenia']),
                'email'   => $row['correo']
               );
              } // end else
            } // end foreach($value as $row)
           } // end foreach($data->toArray() as $key => $value)
           $suma = 0;
           if(!empty($insert_data))
           {
            //dd($insert_data);
            $suma = count($insert_data);
            DB::table('users')->insert($insert_data);
           } // end if(!empty)
          } // end if($data)
          return back()->with('success', 'El archivo de Usuarios de Excel se subió con éxito. '.
            "Se repitieron ".$existentes." registros".
            " y se subieron ".$suma. " registro(s).");         
          //$data = Excel::import(new UsersImport,$path);
          //return back()->with('success', 'El archivo de Uusarios de Excel se subió con éxito.');
        } // end try
        catch (\Illuminate\Database\QueryException $e) 
        {
            return back()->with('success', 'Ocurrió un error:  '.$e->errorInfo[2]);
        } // end catch    
      } // end else $clean == 'Limpiar'      
  } // end function
  public function get_user_data() 
  {
    $datos=[
      "usuario"=>Auth::user()->name,
      "email"=>Auth::user()->email,
      "success"=>"Error, Solo pueden entrar Administradores a esta opción"
    ]; 
    return $datos;
  }
  public function perfiles()
  {
    return DB::table('perfilusers')->orderBy('descripcion', 'ASC')->get();
  }
}