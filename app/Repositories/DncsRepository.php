<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

// Necesario para la clase Session
use Session;
use Auth;
use Excel;

use App\Models\Dncs;
use App\Models\Perfilusers;
use App\Models\User;
use App\Models\Periodos;

use App\Imports\DncsImport;
use App\Exports\UsersExport;
use App\Exports\DncsExport;
use App\Exports\PlantillasExport;

/*
//Step 1: Load KoolReport
require_once "../vendor/koolreport/core/src/koolreport.php";

//Step 2: Creating Report class
class MyReport extends \koolreport\KoolReport
{
    protected function settings()
    {
        return array(
            "dataSources"=>array(
                "data"=>array(
                    "class"=>'\koolreport\datasources\ArrayDataSource',
                    "dataFormat"=>"table",
                    "data"=>array(
                        array("name","age","income"),
                        array("John",26,50000),
                        array("Marry",29,60000),
                        array("Peter",34,100000),
                        array("Donald",28,80000),
                    )
                )
            )
        );
    }
    protected function setup()
    {
        $this->src("data")->pipe($this->dataStore("data"));
    }    
}
*/
class DncsRepository extends Controller
{
    private $model;
    public function __construct()
    {        
        $this->model = New Dncs();
    }
    public function get_user_data() 
    {
      $datos=[
        "usuario"=>Auth::user()->name,
        "email"=>Auth::user()->email,
        "success"=>"Error, Solo pueden entrar Administradores a esta opción"
      ]; 
      return $datos;
    }
    public function es_administrador() 
    {
      if (Auth::user()->fk_cve_perfil_usuario != "A") 
      {
        return back()->with('success', 'Error, solo pueden ingresar los Administradores.');  
      }
      return "Si";
    }
    // completa la vista del Usuario normal Evaluador!!
    public function index()
    {
        $datos = [
            "usuario"=>Auth::user()->name,
            "cve_perfil_usuario"=>Auth::user()->fk_cve_perfil_usuario,
            "email"=>Auth::user()->email,
            "success"=>""
        ];
        //dd("USUARIO MORTAL");
        $dnc = DB::table('dncs')
        ->join('periodos', 'periodos.cve_periodo', '=', 'dncs.fk_cve_periodo')
        ->join('plantillas', 'plantillas.id', '=', 'dncs.id')
        ->orderBy('id', 'ASC')
        ->select(
                'dncs.id',
                'dncs.fk_cve_periodo',
                'dncs.num_emp',
                'dncs.nombre_completo',
                'dncs.dep_o_ent',
                'dncs.unidad_admva',
                'dncs.area',
                'dncs.grado_est',
                'dncs.correo',
                'dncs.telefono',
                'dncs.funciones',
                'dncs.word_int',
                'dncs.word_ava',
                'dncs.excel_int',
                'dncs.excel_ava',
                'dncs.power_point',
                'dncs.nuevas_tec',
                'dncs.acc_institucionales',
                'dncs.acc_des_humano',
                'dncs.acc_administrativas',
                'dncs.otro_curso',
                'dncs.interes_instructor',
                'dncs.tema',
                'dncs.activo',
                'periodos.descripcion as periodo_descripcion',
                'periodos.activo as periodo_activo',
                'plantillas.activo as plantilla_activo',
                'plantillas.puesto as plantilla_puesto'
                )
                ->where('dncs.activo',true)
                ->where('periodos.activo',true)
                ->where('plantillas.activo',true)
                ->get();
        //dd($dnc);
        if ($dnc->isEmpty())
        { 
            $vista= back()->with("Error, tabla dnc vacía o periodo inactivo o empleado(a) inactivo(a).");
            //dd($vista);
            return $vista;
        };
        //dd($dnc);
         $vista= view('consideraciones',$datos);
         return $vista;
    }
    // completa la vista del Administrador!!
    public function indexAdmin()
    {
        //dd("Administrador");
        //echo "Home Admin"
        $datos = [
            "usuario"=>Auth::user()->name,
            "cve_perfil_usuario"=>Auth::user()->fk_cve_perfil_usuario,
            "email"=>Auth::user()->email,            
            "success"=>""
        ];
        $datos['success']  = "Tenga cuidado con estas opciones";
        $vista = view('administrador',$datos);
        //$vista = "ok";
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
    public function dncs_blank(){
        $dncs = Dncs::FindOrFail(1);        
        $dncs->activo = true;
        return ( $dncs);
    }
    public function insert( Request $request)
    {
        $campos=        $this->get_campos_val();
        $mensajes=      $this->get_mensajes_val();
        //dd($request);
        $this->validate( $request, $campos, $mensajes);
        $dncs= $this->fix_datos_dncs( $request);
        //dd( $dncs);
        $this->model->insert( $dncs);
    }
    private function fix_datos_dncs( $request) 
    {
        // elimina la variables _token , _method, y activao
        $datos_dncs = request()->except('_token', '_method', "activao","activa");
        $datos_dncs['activo'] = filter_var($request->activao, FILTER_VALIDATE_BOOLEAN);            
        $datos_dncs['word_int']= "";
        $datos_dncs['word_ava']= "";
        $datos_dncs['excel_int']= "";
        $datos_dncs['excel_ava']= "";
        $datos_dncs['power_point']= "";
        $datos_dncs['nuevas_tec']= "";
        $datos_dncs['acc_institucionales']= "";
        $datos_dncs['acc_des_humano']= "";
        $datos_dncs['acc_administrativas']= "";        
        if (array_key_exists('word_int_tablas', $datos_dncs)) {
            $datos_dncs['word_int'] = "Tablas en Word.";
            unset($datos_dncs['word_int_tablas']);
        };
        if (array_key_exists('word_ava_correspondencia',$datos_dncs) ) {
            $datos_dncs['word_ava'] = "Combinación de Correspondencia.";
            unset($datos_dncs['word_ava_correspondencia']);
        };
        if (array_key_exists('excel_int_graficos',$datos_dncs)) {
            $datos_dncs['excel_int'] = "Gráficos en Excel.";
            unset($datos_dncs['excel_int_graficos']);
        };
        if (array_key_exists('excel_int_formulas',$datos_dncs)) {
            $datos_dncs['excel_int'] = $datos_dncs['excel_int']."\r\n".
            "Formulas Básicas en Excel.";
            unset($datos_dncs['excel_int_formulas']);
        };
        if (array_key_exists('excel_ava_herramientas',$datos_dncs)) {
            $datos_dncs['excel_ava'] = "Herramientas de visualización de datos.";
            unset($datos_dncs['excel_ava_herramientas']);
        };
        if (array_key_exists('excel_ava_funciones',$datos_dncs)) {
            $datos_dncs['excel_ava'] = $datos_dncs['excel_ava']."\r\n".
            "Funciones y herramientas avanzadas.";
            unset($datos_dncs['excel_ava_funciones']);
        };
        if (array_key_exists('power_point_cualidades',$datos_dncs)) {
            $datos_dncs['power_point'] = "La cualidades de la Presentaciones.";
            unset($datos_dncs['power_point_cualidades']);
        };
        if (array_key_exists('nuevas_tec_competencia',$datos_dncs)) {
            $datos_dncs['nuevas_tec'] = "Competencia comunicativa a través de la competencia digital.";
            unset($datos_dncs['nuevas_tec_competencia']);
        };
        if (array_key_exists('nuevas_tec_zoom',$datos_dncs)) {
            $datos_dncs['nuevas_tec'] = $datos_dncs['nuevas_tec']."\r\n".
            "Nuevas tecnologías (zoom).";
            unset($datos_dncs['nuevas_tec_zoom']);
        };
        if (array_key_exists('acc_institucionales_etica',$datos_dncs)) {
            $datos_dncs['acc_institucionales'] = "Ética e Integridad en el Servicio Público.";
            unset($datos_dncs['acc_institucionales_etica']);
        };
        if (array_key_exists('acc_institucionales_valores',$datos_dncs)) {
            $datos_dncs['acc_institucionales'] = $datos_dncs['acc_institucionales']. "\r\n".
            "Valores Gubernamentales.";
            unset($datos_dncs['acc_institucionales_valores']);
        };
        if (array_key_exists('acc_institucionales_responsabilidades',$datos_dncs)) {
            $datos_dncs['acc_institucionales'] = $datos_dncs['acc_institucionales']. "\r\n".
            "Responsabilidades Administrativas de las personas servidoras públicas.";
            unset($datos_dncs['acc_institucionales_responsabilidades']);
        };
        if (array_key_exists('acc_institucionales_metodologia',$datos_dncs)) {
            $datos_dncs['acc_institucionales'] = $datos_dncs['acc_institucionales']. "\r\n".
            "Metodología de las 5´s.";
            unset($datos_dncs['acc_institucionales_metodologia']);
        };
        if (array_key_exists('acc_institucionales_identificacion',$datos_dncs)) {
            $datos_dncs['acc_institucionales'] = $datos_dncs['acc_institucionales']. "\r\n".
            "Identificación Institucional.";
            unset($datos_dncs['acc_institucionales_identificacion']);
        };
        if (array_key_exists('acc_institucionales_violencia',$datos_dncs)) {
            $datos_dncs['acc_institucionales'] = $datos_dncs['acc_institucionales']. "\r\n".
            "Violencia ver, conocer y reconocer.";
            unset($datos_dncs['acc_institucionales_violencia']);
        };
        if (array_key_exists('acc_institucionales_seguridad',$datos_dncs)) {
            $datos_dncs['acc_institucionales'] = $datos_dncs['acc_institucionales']. "\r\n".
            "Seguridad con perspectiva de género.";
            unset($datos_dncs['acc_institucionales_seguridad']);
        };
        if (array_key_exists('acc_institucionales_norma',$datos_dncs)) {
            $datos_dncs['acc_institucionales'] = $datos_dncs['acc_institucionales']. "\r\n".
            "Norma 025.Igualdad laboral.";
            unset($datos_dncs['acc_institucionales_norma']);
        };
        if (array_key_exists('acc_institucionales_induccion',$datos_dncs)) {
            $datos_dncs['acc_institucionales'] = $datos_dncs['acc_institucionales']. "\r\n".
            "Inducción al Servicio Público.";
            unset($datos_dncs['acc_institucionales_induccion']);
        };
        if (array_key_exists('acc_institucionales_actualizacion',$datos_dncs)) {
            $datos_dncs['acc_institucionales'] = $datos_dncs['acc_institucionales']. "\r\n".
            "Actualización en Gestión archivística, un camino hacia la transparencia y rendición de cuentas.";
            unset($datos_dncs['acc_institucionales_actualizacion']);
        };
        if (array_key_exists('acc_institucionales_documentos',$datos_dncs)) {
            $datos_dncs['acc_institucionales'] = $datos_dncs['acc_institucionales']. "\r\n".
            "Documentos Administrativos.";
            unset($datos_dncs['acc_institucionales_documentos']);
        };
        if (array_key_exists('acc_institucionales_politicas',$datos_dncs)) {
            $datos_dncs['acc_institucionales'] = $datos_dncs['acc_institucionales']. "\r\n".
            "Políticas públicas y el Ciudadano.";
            unset($datos_dncs['acc_institucionales_politicas']);
        };
        if (array_key_exists('acc_institucionales_correcto',$datos_dncs)) {
            $datos_dncs['acc_institucionales'] = $datos_dncs['acc_institucionales']. "\r\n".
            "Correcto manejo de Información.";
            unset($datos_dncs['acc_institucionales_correcto']);
        };
        if (array_key_exists('acc_institucionales_protocolos',$datos_dncs)) {
            $datos_dncs['acc_institucionales'] = $datos_dncs['acc_institucionales']. "\r\n".
            "Protocolos de Atención y Servicio.";
            unset($datos_dncs['acc_institucionales_protocolos']);
        };
        if (array_key_exists('acc_institucionales_vocacion',$datos_dncs)) {
            $datos_dncs['acc_institucionales'] = $datos_dncs['acc_institucionales']. "\r\n".
            "Vocación de Servicio.";
            unset($datos_dncs['acc_institucionales_vocacion']);
        };
        if (array_key_exists('acc_institucionales_vocacion',$datos_dncs)) {
            $datos_dncs['acc_institucionales'] = $datos_dncs['acc_institucionales']. "\r\n".
            "Vocación de Servicio.";
            unset($datos_dncs['acc_institucionales_vocacion']);
        };
        if (array_key_exists('acc_des_humano_solucion',$datos_dncs)) {
            $datos_dncs['acc_des_humano'] = 
            "Solución de conflictos.";
            unset($datos_dncs['acc_des_humano_solucion']);
        };
        if (array_key_exists('acc_des_humano_como',$datos_dncs)) {
            $datos_dncs['acc_des_humano'] = $datos_dncs['acc_des_humano']. "\r\n".
            "Como afrontar las dificultades laborales.";
            unset($datos_dncs['acc_des_humano_como']);
        };
        if (array_key_exists('acc_des_humano_comunicacion',$datos_dncs)) {
            $datos_dncs['acc_des_humano'] = $datos_dncs['acc_des_humano']. "\r\n".
            "Comunicación consciente.";
            unset($datos_dncs['acc_des_humano_comunicacion']);
        };
        if (array_key_exists('acc_des_humano_importancia',$datos_dncs)) {
            $datos_dncs['acc_des_humano'] = $datos_dncs['acc_des_humano']. "\r\n".
            "La importancia de aceptarse a sí mismos.";
            unset($datos_dncs['acc_des_humano_importancia']);
        };
        if (array_key_exists('acc_des_humano_inteligencia',$datos_dncs)) {
            $datos_dncs['acc_des_humano'] = $datos_dncs['acc_des_humano']. "\r\n".
            "Inteligencia emocional.";
            unset($datos_dncs['acc_des_humano_inteligencia']);
        };
        if (array_key_exists('acc_administrativas_actualizacion',$datos_dncs)) {
            $datos_dncs['acc_administrativas'] = 
            "Actualización de procedimientos, Mejora Continua.";
            unset($datos_dncs['acc_administrativas_actualizacion']);
        };
        if (array_key_exists('acc_administrativas_cumplimiento',$datos_dncs)) {
            $datos_dncs['acc_administrativas'] = $datos_dncs['acc_administrativas']. "\r\n".
            "Cumplimiento de objetivos y metas Institucionales.";
            unset($datos_dncs['acc_administrativas_cumplimiento']);
        };
        if (array_key_exists('acc_administrativas_administracion',$datos_dncs)) {
            $datos_dncs['acc_administrativas'] = $datos_dncs['acc_administrativas']. "\r\n".
            "Administración efectiva del tiempo.";
            unset($datos_dncs['acc_administrativas_administracion']);
        };
        if (array_key_exists('acc_administrativas_clima',$datos_dncs)) {
            $datos_dncs['acc_administrativas'] = $datos_dncs['acc_administrativas']. "\r\n".
            "Clima laboral.";
            unset($datos_dncs['acc_administrativas_clima']);
        };
        if (array_key_exists('acc_administrativas_modernizacion',$datos_dncs)) {
            $datos_dncs['acc_administrativas'] = $datos_dncs['acc_administrativas']. "\r\n".
            "Modernización administrativa y diseño organizacional.";
            unset($datos_dncs['acc_administrativas_modernizacion']);
        };
        if (array_key_exists('acc_administrativas_recursos',$datos_dncs)) {
            $datos_dncs['acc_administrativas'] = $datos_dncs['acc_administrativas']. "\r\n".
            "Administración de recursos humanos.";
            unset($datos_dncs['acc_administrativas_recursos']);
        };
        if (array_key_exists('acc_administrativas_materiales',$datos_dncs)) {
            $datos_dncs['acc_administrativas'] = $datos_dncs['acc_administrativas']. "\r\n".
            "Administración de recursos materiales.";
            unset($datos_dncs['acc_administrativas_materiales']);
        };
        if (array_key_exists('acc_administrativas_sistema',$datos_dncs)) {
            $datos_dncs['acc_administrativas'] = $datos_dncs['acc_administrativas']. "\r\n".
            "Sistema de calidad.";
            unset($datos_dncs['acc_administrativas_sistema']);
        };
        if (array_key_exists('acc_administrativas_otro',$datos_dncs)) {
            $datos_dncs['acc_administrativas'] = $datos_dncs['acc_administrativas']. "\r\n".
            "Otro.";
            unset($datos_dncs['acc_administrativas_otro']);
        };
        //dd( $datos_dncs);        
        return ($datos_dncs);
    }
    public function edit( $id)
    {             
        $this->model = $this->model->FindOrFail( $id);
        //dd( $this->model->getAttribute('word_init'));
        $arreglo = $this->model->getAttributes();
        //dd( $arreglo);
        if ( strpos( $arreglo['word_int'], "Tablas en Word.") !== false) {
            $this->model->setAttribute('word_int_tablas',"1");            
        }
        if ( strpos( $arreglo['word_ava'], "Combinación de Correspondencia.") !== false) {
            $this->model->setAttribute('word_ava_correspondencia',"1");            
        }
        if ( strpos( $arreglo['excel_int'], "Gráficos en Excel.") !== false) {
            $this->model->setAttribute("excel_int_graficos","1");            
        }
        if ( strpos( $arreglo['excel_int'], "Formulas Básicas en Excel.") !== false) {
            $this->model->setAttribute("excel_int_formulas","1");            
        }
        if ( strpos( $arreglo['excel_ava'], "Herramientas de visualización de datos.") !== false) {
            $this->model->setAttribute("excel_ava_herramientas","1");            
        }
        if ( strpos( $arreglo['excel_ava'], "Funciones y herramientas avanzadas.") !== false) {
            $this->model->setAttribute("excel_ava_funciones","1");
        }
        if ( strpos( $arreglo['power_point'], "Las Cualidades de la Presentaciones.") !== false) {
            $this->model->setAttribute("power_point_cualidades","1");
        }
        if ( strpos( $arreglo['nuevas_tec'], "Competencia comunicativa a través de la competencia digital.") !== false) {
            $this->model->setAttribute("nuevas_tec_competencia","1");
        }
        if ( strpos( $arreglo['nuevas_tec'], "Nuevas tecnologías (zoom).") !== false) {
            $this->model->setAttribute("nuevas_tec_zoom","1");
        }
        if ( strpos( $arreglo['acc_institucionales'], "Ética e Integridad en el Servicio Público.") !== false) {
            $this->model->setAttribute("acc_institucionales_etica","1");
        }
        if ( strpos( $arreglo['acc_institucionales'], "Valores Gubernamentales.") !== false) {
            $this->model->setAttribute("acc_institucionales_valores","1");
        }
        if ( strpos( $arreglo['acc_institucionales'], "Responsabilidades Administrativas de las personas servidoras públicas.") !== false) {
            $this->model->setAttribute("acc_institucionales_responsabilidades","1");
        }
        if ( strpos( $arreglo['acc_institucionales'], "Metodología de las 5´s.") !== false) {
            $this->model->setAttribute("acc_institucionales_metodologia","1");
        }
        if ( strpos( $arreglo['acc_institucionales'], "Identificación Institucional.") !== false) {
            $this->model->setAttribute("acc_institucionales_identificacion","1");
        }
        if ( strpos( $arreglo['acc_institucionales'], "Violencia ver, conocer y reconocer.") !== false) {
            $this->model->setAttribute("acc_institucionales_violencia","1");
        }
        if ( strpos( $arreglo['acc_institucionales'], "Seguridad con perspectiva de género.") !== false) {
            $this->model->setAttribute("acc_institucionales_seguridad","1");
        }
        if ( strpos( $arreglo['acc_institucionales'], "Seguridad con perspectiva de género.") !== false) {
            $this->model->setAttribute("acc_institucionales_seguridad","1");
        }
        if ( strpos( $arreglo['acc_institucionales'], "Norma 025.Igualdad laboral.") !== false) {
            $this->model->setAttribute("acc_institucionales_norma","1");
        }
        if ( strpos( $arreglo['acc_institucionales'], "Inducción al Servicio Público.") !== false) {
            $this->model->setAttribute("acc_institucionales_induccion","1");
        }
        if ( strpos( $arreglo['acc_institucionales'], "Actualización en Gestión archivística, un camino hacia la transparencia y rendición de cuentas.") !== false) {
            $this->model->setAttribute("acc_institucionales_actualizacion","1");
        }
        if ( strpos( $arreglo['acc_institucionales'], "Documentos Administrativos.") !== false) {
            $this->model->setAttribute("acc_institucionales_documentos","1");
        }
        if ( strpos( $arreglo['acc_institucionales'], "Políticas públicas y el Ciudadano.") !== false) {
            $this->model->setAttribute("acc_institucionales_politicas","1");
        }
        if ( strpos( $arreglo['acc_institucionales'], "Correcto manejo de Información.") !== false) {
            $this->model->setAttribute("acc_institucionales_correcto","1");
        }
        if ( strpos( $arreglo['acc_institucionales'], "Protocolos de Atención y Servicio.") !== false) {
            $this->model->setAttribute("acc_institucionales_protocolos","1");
        }
        if ( strpos( $arreglo['acc_institucionales'], "Vocación de Servicio.") !== false) {
            $this->model->setAttribute("acc_institucionales_vocacion","1");
        }
        if ( strpos( $arreglo['acc_des_humano'], "Solución de conflictos.") !== false) {
            $this->model->setAttribute("acc_des_humano_solucion","1");
        }
        if ( strpos( $arreglo['acc_des_humano'], "Como afrontar las dificultades laborales.") !== false) {
            $this->model->setAttribute("acc_des_humano_como","1");
        }
        if ( strpos( $arreglo['acc_des_humano'], "Comunicación consciente.") !== false) {
            $this->model->setAttribute("acc_des_humano_comunicacion","1");
        }
        if ( strpos( $arreglo['acc_des_humano'], "La importancia de aceptarse a sí mismos.") !== false) {
            $this->model->setAttribute("acc_des_humano_importancia","1");
        }
        if ( strpos( $arreglo['acc_des_humano'], "Inteligencia emocional.") !== false) {
            $this->model->setAttribute("acc_des_humano_inteligencia","1");
        }
        if ( strpos( $arreglo['acc_administrativas'], "Actualización de procedimientos, Mejora Continua.") !== false) {
            $this->model->setAttribute("acc_administrativas_actualizacion","1");
        }
        if ( strpos( $arreglo['acc_administrativas'], "Cumplimiento de objetivos y metas Institucionales.") !== false) {
            $this->model->setAttribute("acc_administrativas_cumplimiento","1");
        }
        if ( strpos( $arreglo['acc_administrativas'], "Administración efectiva del tiempo.") !== false) {
            $this->model->setAttribute("acc_administrativas_administracion","1");
        }
        if ( strpos( $arreglo['acc_administrativas'], "Clima laboral.") !== false) {
            $this->model->setAttribute("acc_administrativas_clima","1");
        }
        if ( strpos( $arreglo['acc_administrativas'], "Modernización administrativa y diseño organizacional.") !== false) {
            $this->model->setAttribute("acc_administrativas_modernizacion","1");
        }
        if ( strpos( $arreglo['acc_administrativas'], "Administración de recursos humanos.") !== false) {
            $this->model->setAttribute("acc_administrativas_recursos","1");
        }
        if ( strpos( $arreglo['acc_administrativas'], "Administración de recursos materiales.") !== false) {
            $this->model->setAttribute("acc_administrativas_materiales","1");
        }
        if ( strpos( $arreglo['acc_administrativas'], "Sistema de calidad.") !== false) {
            $this->model->setAttribute("acc_administrativas_sistema","1");
        }        
        if ( strpos( $arreglo['acc_administrativas'], "Otro.") !== false) {
            $this->model->setAttribute("acc_administrativas_otro","1");
        }
        //dd( $this->model);
        return ( $this->model );
    }
    public function save(Request $request, $id)
    {
        $campos=        $this->get_campos_val();
        $mensajes=      $this->get_mensajes_val();
        $this->validate( $request, $campos, $mensajes);
        $datos_dncs = $this->fix_datos_dncs( $request);
        //dd($datos_dncs);
        $this->model->where('id', '=', $id)->update( $datos_dncs);
    }
    public function get_campos_val()
    {
        $campos=[
            'fk_cve_periodo'=> 'required|string|max:3|min:1',
            'num_emp'=> 'required|digits_between:1,999999999999',
            'nombre_completo'=> 'required|string|max:80|min:5',
            'dep_o_ent'=> 'required|string|max:180|min:5',
            'unidad_admva'=> 'required|string|max:180|min:1',
            'area'=> 'required|string|max:180|min:5',
            'grado_est'=> 'required|string|max:80|min:5',
            'correo'=> 'required|string|max:80|min:5',
            'telefono'=> 'required|string|max:40|min:10',
            'funciones'=> 'required|string|max:500|min:10',
        ];
        return $campos;
    }
    public function get_mensajes_val()
    {
        $mensajes=[            
            'fk_cve_periodo.required'=>'El Periodo es requerido, debe contener al menos 1 caracter.',
            'fk_cve_periodo.min'=>'El Periodo debe contener al menos 1 caracter.',
            'fk_cve_periodo.max'=>'El Periodo debe contener máximo 3 caracteres.',
            'num_emp.required'=>'El Número de Empleado es requerido y debe ser numérico',
            'num_emp.min'=>'El Periodo debe ser numérico, entero y mayor que cero.',
            'num_emp.max'=>'El Periodo debe ser numérico, entero y menor o igual a 999999999.',
            'nombre_completo.required'=>'El Nombre de Empleado es requerido y debe iniciar por los apellidos',
            'nombre_completo.min'=>'El Nombre del Empleado debe tener al menos 5 caracteres.',
            'nombre_completo.max'=>'El Nombre del Empleado debe tener como máximo 80 caracteres.',
            'dep_o_ent.required'=>'La Dependencia o Entidad es requerida',
            'dep_o_ent.min'=>'La Dependencia o Entidad debe tener al menos 5 caracteres.',
            'dep_o_ent.max'=>'La Dependencia o Entidad debe tener como máximo 180 caracteres.',
            'unidad_admva.required'=>'La Unidad Administrativa es requerida',
            'unidad_admva.min'=>'La Unidad Administrativa debe tener al menos 1 caracter.',
            'unidad_admva.max'=>'La Unidad Administrativa debe tener como máximo 180 caracteres.',
            'area.required'=>'El Area es requerida',
            'area.min'=>'El Area debe tener al menos 5 caracteres.',
            'area.max'=>'El Area debe tener como máximo 180 caracteres.',
            'grado_est.required'=>'El Grado de Estudios es requerida',
            'grado_est.min'=>'El Grado de Estudios debe tener al menos 5 caracteres.',
            'grado_est.max'=>'El Grado de Estudios debe tener como máximo 80 caracteres.',
            'correo.required'=>'El Correo Electrónico es requerida',
            'correo.min'=>'El Correo Electrónico debe tener al menos 5 caracteres.',
            'correo.max'=>'El Correo Electrónico debe tener como máximo 80 caracteres.',
            'telefono.required'=>'El Número de Teléfono es requerido',
            'telefono.min'=>'El Número de Teléfono debe tener al menos 10 caracteres e inclupir el area.',
            'telefono.max'=>'El Número de Teléfono debe tener como máximo 40 caracteres e inclupir el area.',
            'funciones.required'=>'Las Funciones son requeridas',
            'funciones.min'=>'Las Funciones deben tener al menos 10 caracteres.',
            'funciones.max'=>'Las Funciones deben tener como máximo 500 caracteres.',        
        ];
        return $mensajes;
    }
    public function import(Request $request) 
    {
      $datos= $this->get_user_data();
      //dd("hey");          
      $clean = $request->clean;
      if ($clean == 'Limpiar')
      {
          DB::table('dncs')->where('id', '>', 1)->delete();
          return back()->with('success', 'Tabla de Formatos DNC limpiada, excepto el primer registro.');
      } // end if ($clean)
      else 
      {
        $this->validate($request, 
          [ 'select_file'  => 'required|mimes:xls,xlsx'   ], 
          [ 'select_file.required'=>'Se pide un archivo de Excel con extensión .xls o .xlsx' ]
        );
         $path1 = $request->file('select_file')->store('temp'); 
         $path = storage_path('app').'/'.$path1;          
         try {
          //dd($path1);
          $data = Excel::toCollection(new DncsImport, $path);          
          $existentes = 0;          
          if($data->count() > 0)
          {
           foreach($data->toArray() as $key => $value)
           {            
            foreach($value as $row)
            {
              //dd(count($row) );
              if (! (               
                isset($row['cve_plantilla']) &&
                isset($row['cve_periodo']) &&
                isset($row['num_emp']) &&
                isset($row['nombre_completo']) &&
                isset($row['dep_o_ent']) &&
                isset($row['unidad_admva']) &&
                isset($row['area']) &&
                isset($row['grado_est']) &&
                isset($row['correo']) &&
                isset($row['telefono']) &&
                isset($row['funciones']) 
                ))
              {                 
                  return back()->with('success', 
                  'Error: El archivo de Excel de Formatos de DNC debe tener las columnas siguientes : '.
                  "cve_plantilla, cve_periodo, num_emp, nombre_completo, dep_o_ent, unidad_admva, ".
                  "area, grado_est, correo, telefono, funciones. ".
                  "Alguno de ellos esta faltando. ".
                  "Vea la documentación Técnica para importar formatos DNC llenos y vacíos."
                   );                
              } // end if(!)
              //dd($row);
              $dncs = DB::table('dncs')
                ->where('num_emp', $row['num_emp'])
                ->where('fk_cve_periodo', $row['cve_periodo'])
                ->get();
              if ( $dncs->isNotEmpty()) 
              {
                $existentes= $existentes + 1;
              }
              else 
              { 
               if (isset($row['word_int'])) {
                $insert_data[] = array(                
                    'fk_id_plantillas'    => $row['cve_plantilla'],
                    'fk_cve_periodo'      => $row['cve_periodo'],
                    'num_emp'             => $row['num_emp'],
                    'nombre_completo'     => $row['nombre_completo'],
                    'dep_o_ent'           => $row['dep_o_ent'],
                    'unidad_admva'        => $row['unidad_admva'],
                    'area'                => $row['area'],
                    'grado_est'           => $row['grado_est'],
                    'correo'              => $row['correo'],
                    'telefono'            => $row['telefono'],
                    'funciones'           => $row['funciones'],
                    'word_int'            => $row['word_int'],
                    'word_ava'            => $row['word_ava'],
                    'excel_int'           => $row['excel_int'],
                    'excel_ava'           => $row['excel_ava'],
                    'power_point'         => $row['power_point'],
                    'nuevas_tec'          => $row['nuevas_tec'],
                    'acc_institucionales' => $row['acc_institucionales'],
                    'acc_des_humano'      => $row['acc_des_humano'],
                    'acc_administrativas' => $row['acc_administrativas'],
                    'otro_curso'          => $row['otro_curso'],
                    'interes_instructor'  => $row['interes_instructor'],
                    'tema'                => $row['tema']
                    );                  
               } // end if isset($row['word_int'])
               else
               {
                $insert_data[] = array(                
                    'fk_id_plantillas'    => $row['cve_plantilla'],
                    'fk_cve_periodo'      => $row['cve_periodo'],
                    'num_emp'             => $row['num_emp'],
                    'nombre_completo'     => $row['nombre_completo'],
                    'dep_o_ent'           => $row['dep_o_ent'],
                    'unidad_admva'        => $row['unidad_admva'],
                    'area'                => $row['area'],
                    'grado_est'           => $row['grado_est'],
                    'correo'              => $row['correo'],
                    'telefono'            => $row['telefono'],
                    'funciones'           => $row['funciones']);
               } //end else isset($row['word_int'])
              } // end if( $row)
            } // end foreach($value as $row)
           } // end foreach($data->toArray() as $key => $value)
           $suma = 0;
           if(!empty($insert_data))
           {
            //dd($insert_data);
            $suma = count($insert_data);
            //DB::table('dncs')->insert($insert_data);
            foreach (array_chunk($insert_data,1000) as $t) 
            {
                DB::table('dncs')->insert($t);
            }
           } // end if(!empty)
          } // end if($data)
          return back()->with('success', 
            'El archivo de Formatos DNC de Excel se subió con éxito. '.
            "Se repitieron ".$existentes." registro(s)".
            " y se subieron ".$suma. " registro(s).");         
          //$data = Excel::import(new UsersImport,$path);
          //return back()->with('success', 'El archivo de Uusarios de Excel se subió con éxito.');
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return back()->with('success', 'Ocurrió un error:  '.$e->errorInfo[2]);
        } // end catch
      } // end else $clean == 'Limpiar'
    } // end import function  
 
    public function export( $action) 
    {
        if ($action== "1") {
            return Excel::download(new UsersExport, 'usuarios.xlsx');
        }
        if ($action== "2") {
            return Excel::download(new DncsExport, 'dncs.xlsx');
        }
        if ($action== "3") {
            return Excel::download(new PlantillasExport, 'plantillas.xlsx');        
        }
        return ('Opción Inválida'); 
    }

    public function reportes( $repo) 
    {
    $periodos           = $this->periodos();
    //$dncs               = $this->all();
    if ($repo == "1")
          {
            return "En proceso reporte de Usuarios";
          }
    if ($repo == "2")
          {            
            return $this->repo_dnc();
          }
    if ($repo == "3")
          {
            return "En proceso reporte de Plantillas";
         }          
    }

    public function dependencias()
    {           
        return Dncs::all()->sortBy("dep_o_ent")->unique("dep_o_ent");
    }
    public function unidades()
    {   
        return Dncs::all()->sortBy("unidad_admva")->unique("unidad_admva");
    }
    public function areas()
    {   
        return Dncs::all()->sortBy("area")->unique("area");
    }
    public function First()
    {             
        return( $this->model->First());
    }
    public function repo_dnc()
    {           
        $dncs =  $this->First();

        $dependencia = $this->dependencias();
        $unidad = $this->unidades();
        $area = $this->areas();

        $periodo = $this->periodos();
            
        $periodo_ini = $periodo->First()->cve_periodo;
        $periodo_fin = $periodo->Last()->cve_periodo;
    
        $dependencia_ini = $dependencia->First()->dep_o_ent;
        $dependencia_fin = $dependencia->Last()->dep_o_ent;
        //dd($dependencia_ini);
        $unidad_ini = $unidad->First()->unidad_admva;
        $unidad_fin = $unidad->Last()->unidad_admva;
    
        $area_ini = $area->First()->area;
        $area_fin = $area->Last()->area;

        //dd("ok");
        return view('admin/Dncsrepos',
            compact('dependencia','unidad','area','dncs','periodo',
            'periodo_ini','periodo_fin',
            'dependencia_ini','dependencia_fin',
            'unidad_ini','unidad_fin',
            'area_ini','area_fin'
            ));        
    } 
    
    public function dncsrepodet( Request $request)
    {
        if ($request->num_emp> "0") 
        {            
            $dncs = DB::table('dncs')
            ->join('plantillas', 'plantillas.id', '=', 'dncs.fk_id_plantillas')
            ->join('periodos', 'periodos.cve_periodo', '=', 'dncs.fk_cve_periodo')            
            ->orderBy('dncs.num_emp', 'ASC')
            ->orderBy('dncs.fk_cve_periodo', 'DESC')
            ->where('dncs.fk_cve_periodo', '>=',$request->periodoini)
            ->where('dncs.fk_cve_periodo', '<=',$request->periodofin)
            ->where('dncs.dep_o_ent', '>=',$request->dependenciaini)
            ->where('dncs.dep_o_ent', '<=',$request->dependenciafin)
            ->where('dncs.unidad_admva', '>=',$request->unidadini)
            ->where('dncs.unidad_admva', '<=',$request->unidadfin)
            ->where('dncs.area', '>=',$request->areaini)
            ->where('dncs.area', '<=',$request->areafin)
            ->where('dncs.num_emp', '=',$request->num_emp)
            ->select(
                'dncs.id',
                'dncs.fk_id_plantillas',
                'dncs.fk_cve_periodo',
                'dncs.num_emp',
                'dncs.nombre_completo',
                'dncs.dep_o_ent',
                'dncs.unidad_admva',
                'dncs.area',
                'dncs.grado_est',
                'dncs.correo',
                'dncs.telefono',
                'dncs.funciones',
                'dncs.word_int',
                'dncs.word_ava',
                'dncs.excel_int',
                'dncs.excel_ava',
                'dncs.power_point',
                'dncs.nuevas_tec',
                'dncs.acc_institucionales',
                'dncs.acc_des_humano',
                'dncs.acc_administrativas',
                'dncs.otro_curso',
                'dncs.tema',
                'dncs.activo',            
                'periodos.descripcion as periodo_descripcion')                
            ->get();
            //dd($request->unidad_fin);
            //dd($dncs);

        } else 
        {                
            $dncs = DB::table('dncs')
            ->join('plantillas', 'plantillas.id', '=', 'dncs.fk_id_plantillas')
            ->join('periodos', 'periodos.cve_periodo', '=', 'dncs.fk_cve_periodo')            
            ->orderBy('dncs.num_emp', 'ASC')
            ->orderBy('dncs.fk_cve_periodo', 'DESC')
            ->where('dncs.fk_cve_periodo', '>=',$request->periodoini)
            ->where('dncs.fk_cve_periodo', '<=',$request->periodofin)
            ->where('dncs.dep_o_ent', '>=',$request->dependenciaini)
            ->where('dncs.dep_o_ent', '<=',$request->dependenciafin)
            ->where('dncs.unidad_admva', '>=',$request->unidadini)
            ->where('dncs.unidad_admva', '<=',$request->unidadfin)
            ->where('dncs.area', '>=',$request->areaini)
            ->where('dncs.area', '<=',$request->areafin)
            ->select(
                'dncs.id',
                'dncs.fk_id_plantillas',
                'dncs.fk_cve_periodo',
                'dncs.num_emp',
                'dncs.nombre_completo',
                'dncs.dep_o_ent',
                'dncs.unidad_admva',
                'dncs.area',
                'dncs.grado_est',
                'dncs.correo',
                'dncs.telefono',
                'dncs.funciones',
                'dncs.word_int',
                'dncs.word_ava',
                'dncs.excel_int',
                'dncs.excel_ava',
                'dncs.power_point',
                'dncs.nuevas_tec',
                'dncs.acc_institucionales',
                'dncs.acc_des_humano',
                'dncs.acc_administrativas',
                'dncs.otro_curso',
                'dncs.tema',
                'dncs.activo',            
                'periodos.descripcion as periodo_descripcion')
            ->get();            
        } // ENDIF
        //dd($dncs);
        if(count($dncs) < 1) 
        {
            $err = 'Error: No se encontró ningún Formato DNC con las condiciones: No. de empleado='. 
                $request->num_emp. 
                ", dependencia>=". $request->dependenciaini.
                " y dependencia<=".$request->dependenciafin. 
                ", UA >=".$request->unidadini.
                "y  UA <=".$request->unidadfin.
                ", area >=".$request->areani.
                "y  area <=".$request->areafin.
                ", periodo inicial >=".
                $request->periodoini." y periodo final<=".$request->periodofin;
            return back()->with('mensaje', $err);
        } else 
        {
            return view('admin/Dncsreporte',compact('dncs'));
        }
    }
    public function dncsrepo( Request $request)
    {
        // clic en reporte detallado?
        if (isset($request->repodet)) {
            return $this->dncsrepodet( $request);
        } else {
            return $this->dncsrepodep( $request);            
        }   
    }  
    public function dncsrepodep( Request $request)
    {
       $dncs = DB::table('dncs')
            ->where('dncs.fk_cve_periodo', '>=',$request->periodoini)
            ->where('dncs.fk_cve_periodo', '<=',$request->periodofin)
            ->where('dncs.dep_o_ent', '>=',$request->dependenciaini)
            ->where('dncs.dep_o_ent', '<=',$request->dependenciafin)
            ->where('dncs.unidad_admva', '>=',$request->unidadini)
            ->where('dncs.unidad_admva', '<=',$request->unidadfin)
            ->where('dncs.area', '>=',$request->areaini)
            ->where('dncs.area', '<=',$request->areafin)
            ->GroupBy('dep_o_ent')
            ->selectRaw('count(id) as total, dep_o_ent')
            ->get();

        if(count($dncs) < 1) 
        {
            $err = 'Error: No se encontró ningún Formato DNC con las condiciones: '.
                " dependencia>=". $request->dependenciaini.
                " y dependencia<=".$request->dependenciafin. 
                ", UA >=".$request->unidadini.
                "y  UA <=".$request->unidadfin.
                ", area >=".$request->areani.
                "y  area <=".$request->areafin.
                ", periodo inicial >=".
                $request->periodoini." y periodo final<=".$request->periodofin;
            return back()->with('mensaje', $err);
        } else 
        {
            return view('admin/Dncsrepodep',compact('dncs'));
        }
    }
}