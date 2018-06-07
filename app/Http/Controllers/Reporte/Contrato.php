<?php
namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Mantenimiento\Contratos;

class Contrato extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  //Esto debe activarse cuando estemos con sessión
    }

    public function detalle(Request $r )
    {
        if ( $r->ajax() ) {
            $result = Contratos::listContratos($r);
            $return['rst'] = 1;
            $return['data'] = $result;
            $return['msj'] = "No hay registros aún";    
            return response()->json($return);   
        }
    }

}
