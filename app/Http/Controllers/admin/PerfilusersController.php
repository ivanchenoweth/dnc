<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\PerfilusersRepository;

class PerfilusersController extends Controller
{
    private $perfilusersRepository; 
    public function __construct( PerfilusersRepository $perfilusersRepository)
    {
        $this->perfilusersRepository = $perfilusersRepository;
        $this->middleware('auth');
    }
    public function index()
    {   
        $datos['Perfilusers'] = $this->perfilusersRepository->all();
        return view('admin/Perfilusers.index', $datos);
    }
    public function create()
    {                
        $perfilusers = $this->perfilusersRepository->perfilusers_blank();
        //dd($perfilusers);
        return view('admin/Perfilusers.create', compact('perfilusers'));
    }
    public function store(Request $request)
    {        
        $this->perfilusersRepository->insert( $request);
        return redirect("/admin/Perfilusers")->with('mensaje','Nuevo Perfil de Usuario Agergado.');
    }
    public function destroy( $id)
    {        
        $this->perfilusersRepository->delete( $id);
        return redirect("/admin/Perfilusers")->with('mensaje','Perfil de Usuario Borrado.');
    }
    public function edit($id)
    {                
        $perfilusers = $this->perfilusersRepository->edit( $id);
        return view('admin/Perfilusers.edit', compact('perfilusers'));
    }
    public function update(Request $request, $id)
    {   
        $this->perfilusersRepository->save( $request, $id); 
        return redirect("/admin/Perfilusers")->with('mensaje','Perfil de Usuario Actualizado.');
    }
}