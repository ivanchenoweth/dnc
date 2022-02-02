<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if (Auth::user()->activo == false)
        {
            $correo_usuario = Auth::user()->email;
            $perfil_usuario = Auth::user()->fk_cve_perfil_usuario;
            return view("inactivo",compact('correo_usuario','perfil_usuario'));
        }
        //dd("aqui");
        if (Auth::user()->fk_cve_perfil_usuario == "A") 
        {  
            return view('homeadmin');           
        }
        else
        {
            //dd(Auth::user());
            return view('home');
        }      
    }
}