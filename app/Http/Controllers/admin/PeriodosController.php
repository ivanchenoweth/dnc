<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\PeriodosRepository;

class PeriodosController extends Controller
{
    private $periodosRepository; 
    public function __construct( PeriodosRepository $periodosRepository)
    {
        $this->periodosRepository = $periodosRepository;
        $this->middleware('auth');
    }
    public function index()
    {   
        $datos['Periodos'] = $this->periodosRepository->All();        
        return view('admin/Periodos.index', $datos);
    }
    public function create()
    {                
        $periodo = $this->periodosRepository->Periodo_blank();
        return view('admin/Periodos.create', compact('periodo'));
    }
    public function store(Request $request)
    {        
        $this->periodosRepository->insert( $request);
        return redirect("/admin/Periodos")->with('mensaje','Nuevo Periodo Agergado.');        
    }
    public function destroy( $id)
    {        
        $this->periodosRepository->delete( $id);        
        return redirect("/admin/Periodos")->with('mensaje','Periodo Borrado.');
    }
    public function edit($id)
    {                
        $periodo = $this->periodosRepository->edit( $id);
        return view('admin/Periodos.edit', compact('periodo'));
    }
    public function update(Request $request, $id)
    {   
        //dd($id);     
        $this->periodosRepository->save( $request, $id); 
        return redirect("/admin/Periodos")->with('mensaje','Periodo Actualizado.');    
    }
}