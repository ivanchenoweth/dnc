<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\PlantillasRepository;

class PlantillasController extends Controller
{
    private $plantillasRepository; 
    public function __construct( PlantillasRepository $plantillasRepository)
    {
        $this->plantillasRepository = $plantillasRepository;
        $this->middleware('auth');
    }
    // Menu de Administrador
    public function indexAdmin()
    {           
        return ( $this->plantillasRepository->indexAdmin());
    }
    public function index()
    {   
        //dd("hey");
        $perfil_usuarios    = $this->plantillasRepository->perfil_usuarios();
        $usuarios           = $this->plantillasRepository->usuarios();
        $periodos           = $this->plantillasRepository->periodos();
        $datos['plantillas']      = $this->plantillasRepository->all(); 
        return view('admin/Plantillas.index', $datos, compact(
            'perfil_usuarios',
            'periodos',
            'usuarios'
        ));
    }
    public function create()
    {
        $perfil_usuarios    = $this->plantillasRepository->perfil_usuarios();
        $usuarios           = $this->plantillasRepository->usuarios();
        $plantillas         = $this->plantillasRepository->plantillas_blank();
        return view('admin/Plantillas.create', compact(
            'usuarios',
            'perfil_usuarios',
            'plantillas'));
    }
    public function store(Request $request)
    {        
        $this->plantillasRepository->insert( $request);
        return redirect("/admin/Plantillas")->with('mensaje','Nueva Pantilla Agergada.');
    }
    public function destroy( $id)
    {        
        $this->plantillasRepository->delete( $id);        
        return redirect("/admin/Plantillas")->with('mensaje','Plantilla Borrada.');
    }
    public function edit( $id)
    {
        $perfil_usuarios    = $this->plantillasRepository->perfil_usuarios();
        $usuarios           = $this->plantillasRepository->usuarios();
        $plantillas         = $this->plantillasRepository->edit( $id);
        return view('admin/Plantillas.edit', compact(
            'usuarios',
            'perfil_usuarios',
            'plantillas'));
    }
    public function update(Request $request, $id)
    {   
        $this->plantillasRepository->save( $request, $id); 
        return redirect("/admin/Plantillas")->with('mensaje','Plantilla Actualizada.');
    }
    function import(Request $request)    
    {
      //dd('imp');
      if ( $this->plantillasRepository->es_administrador() == "Si") 
      {
        return $this->plantillasRepository->import( $request);
      }
      else
      {        
        return $this->plantillasRepository->get_user_data();
      }
    }
    function indeximport()
    {
      //dd("hey");
      if ( $this->plantillasRepository->es_administrador() == "Si") 
      {
          $periodos           = $this->plantillasRepository->periodos();
          $plantillas         = $this->plantillasRepository->all();
          $importing          = false;
          $importFinished     = false;
          return view('/admin/Plantillas/Import', compact(
              'plantillas',
              'importing',
              'importFinished',
              'periodos'
            ));
      }
      else
      {        
        return $this->dncsRepository->get_user_data();        
      }
    }
}