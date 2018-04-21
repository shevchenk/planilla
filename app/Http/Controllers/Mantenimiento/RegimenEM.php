<?php
namespace App\Http\Controllers\Mantenimiento;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mantenimiento\Regimen;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegimenEM extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  //Esto debe activarse cuando estemos con sessión
    } 

    public function EditStatus(Request $r )
    {
        if ( $r->ajax() ) {
            Regimen::runEditStatus($r);
            $return['rst'] = 1;
            $return['msj'] = 'Registro actualizado';
            return response()->json($return);
        }
    }

   public function New(Request $r )
    {
        if ( $r->ajax() ) {

            $mensaje= array(
                'required'    => ':attribute es requerido',
                'unique'      => ':attribute solo debe ser único',
            );

            $rules = array(
                'respuesta' => 
                       ['required',
                        Rule::unique('v_respuestas','respuesta')->where(function ($query) use($r) {
                                $query->where('pregunta_id',$r->pregunta_id );
                        }),
                        ],
            );

            
            $validator=Validator::make($r->all(), $rules,$mensaje);

            if ( !$validator->fails() ) {
                Regimen::runNew($r);
                $return['rst'] = 1;
                $return['msj'] = 'Registro creado';
            }
            else{
                $return['rst'] = 2;
                $return['msj'] = $validator->errors()->all()[0];
            }
            return response()->json($return);
        }
    }

    public function Edit(Request $r )
    {
        if ( $r->ajax() ) {
            $mensaje= array(
                'required'    => ':attribute es requerido',
                'unique'        => ':attribute solo debe ser único',
            );

            $rules = array(
                'respuesta' => 
                       ['required',
                        Rule::unique('v_respuestas','respuesta')->ignore($r->id)->where(function ($query) use($r) {
                                $query->where('pregunta_id',$r->pregunta_id );
                        }),
                        ],
            );

            $validator=Validator::make($r->all(), $rules,$mensaje);

            if ( !$validator->fails() ) {
                Regimen::runEdit($r);
                $return['rst'] = 1;
                $return['msj'] = 'Registro actualizado';
            }
            else{
                $return['rst'] = 2;
                $return['msj'] = $validator->errors()->all()[0];
            }
            return response()->json($return);
        }
    }

    public function Load(Request $r )
    {
        if ( $r->ajax() ) {
            $renturnModel = Regimen::runLoad($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";    
            return response()->json($return);   
        }
    }
    
    public function ListPregunta (Request $r )
    {
        if ( $r->ajax() ) {
            $renturnModel = Pregunta::ListPregunta($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";
            return response()->json($return);
        }
    }
    
        public function ListTipoRegimen (Request $r )
    {
        if ( $r->ajax() ) {
            $renturnModel = TipoRegimen::ListTipoRegimen($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";
            return response()->json($return);
        }
    }

}
