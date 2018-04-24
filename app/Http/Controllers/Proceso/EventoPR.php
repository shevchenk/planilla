<?php
namespace App\Http\Controllers\Proceso;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proceso\Evento;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EventoPR extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  //Esto debe activarse cuando estemos con sessión
    } 

    public function EditStatus(Request $r )
    {
        if ( $r->ajax() ) {
            Evento::runEditStatus($r);
            $return['rst'] = 1;
            $return['msj'] = 'Registro actualizado';
            return response()->json($return);
        }
    }
    
    public function EditStatusMaster(Request $r )
    {
        if ( $r->ajax() ) {
            Evento::runEditStatusMaster($r);
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
                'persona_contrato_id' => 
                       ['required',
//                        Rule::unique('m_regimenes','regimen')->where(function ($query) use($r) {
//                                $query->where('pregunta_id',$r->pregunta_id );
//                        }),
                        ],
            );

            
            $validator=Validator::make($r->all(), $rules,$mensaje);

            if ( !$validator->fails() ) {
                Evento::runNew($r);
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
                'persona_contrato_id' => 
                       ['required',
//                        Rule::unique('m_regimenes','regimen')->ignore($r->id)->where(function ($query) use($r) {
                              //  $query->where('pregunta_id',$r->pregunta_id );
//                        }),
                        ],
            );

            $validator=Validator::make($r->all(), $rules,$mensaje);

            if ( !$validator->fails() ) {
                Evento::runEdit($r);
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
            $renturnModel = Evento::runLoad($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";    
            return response()->json($return);   
        }
    }


}
