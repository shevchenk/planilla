<?php
namespace App\Http\Controllers\Proceso;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proceso\Asistencia;
use App\Models\Proceso\EventoAsistencia;

class AsistenciaPR extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  //Esto debe activarse cuando estemos con sessión
    } 

    public function LoadAsistencia(Request $r )
    {
        if ( $r->ajax() ) {
            $renturnModel = Asistencia::runLoadAsistencia($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";    
            return response()->json($return);   
        }
    }
    
        public function LoadEvento(Request $r )
    {
        if ( $r->ajax() ) {
            $renturnModel = EventoAsistencia::runLoadEvento($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";    
            return response()->json($return);   
        }
    }


}
