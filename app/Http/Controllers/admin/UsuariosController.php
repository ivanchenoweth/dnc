<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\UsuariosRepository;

class UsuariosController extends Controller
{
    private $usuariosRepository; 
    public function __construct( UsuariosRepository $usuariosRepository)
    {
        $this->usuariosRepository = $usuariosRepository;
        $this->middleware('auth');
    }    
    public function index()
    {   
        $perfil_usuarios   = $this->usuariosRepository->perfil_usuarios();
        $datos['usuarios'] = $this->usuariosRepository->all(); 
        return view('admin/Usuarios.index', $datos, compact('perfil_usuarios'));
    }
    public function create()
    {                
        $perfil_usuarios   = $this->usuariosRepository->perfil_usuarios();
        $usuarios = $this->usuariosRepository->Usuarios_blank();
        return view('admin/Usuarios.create', compact('usuarios','perfil_usuarios'));
    }
    public function store(Request $request)
    {        
        $this->usuariosRepository->insert( $request);
        return redirect("/admin/Usuarios")->with('mensaje','Nuevo Usuario Agergado.');        
    }
    public function destroy( $id)
    {        
        $this->usuariosRepository->delete( $id);        
        return redirect("/admin/Usuarios")->with('mensaje','Usuario Borrado.');
    }
    public function edit( $id)
    {
        $perfil_usuarios   = $this->usuariosRepository->perfil_usuarios();
        $usuarios = $this->usuariosRepository->edit( $id);
        return view('admin/Usuarios.edit', compact('usuarios','perfil_usuarios'));
    }
    public function update(Request $request, $id)
    {   
        $this->usuariosRepository->save( $request, $id); 
        return redirect("/admin/Usuarios")->with('mensaje','Usuario Actualizado.');
    }
    function indeximport()
    {
      //dd("aqui");      
      if ( $this->usuariosRepository->es_administrador() == "Si") 
      {
          $usuarios = $this->usuariosRepository->all();
          return view('/admin/Usuarios/Import', compact('usuarios'));
      }
      else
      {        
        $datos= $this->usuariosRepository->get_user_data();
        return $datos;
      }
    }
    function import(Request $request)    
    {
      if ( $this->usuariosRepository->es_administrador() == "Si") 
      {
        return $this->usuariosRepository->import( $request);
      }
      else
      {        
        return $this->usuariosRepository->get_user_data();
      }
    }
}