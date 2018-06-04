<?php
namespace App\Http\Controllers\Proceso;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Models\Proceso\HorarioProgramado;

class HorarioProgramadoPR extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  //Esto debe activarse cuando estemos con sessión
    } 

    public function EditStatus(Request $r )
    {
        if ( $r->ajax() ) {
            HorarioProgramado::runEditStatus($r);
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
                        ],
            );

            $validator=Validator::make($r->all(), $rules,$mensaje);

            if ( !$validator->fails() ) {
                

                if(count($r->horario_plantilla) > 0)
                {
                    foreach ($r->horario_plantilla as $key => $hp) {                    
                        $t_hp = DB::table('m_horarios_plantillas')->select('id', 'dia_ids', 'hora_inicio', 'hora_fin')->where('id', '=', $hp)->first();
                        $arr_dias = explode(',', $t_hp->dia_ids);
                        if(count($arr_dias) > 0)
                        {
                            foreach ($arr_dias as  $dia) {
                                $tolerancia = 'tolerancia'.$hp.$dia;
                                //if(($r->$tolerancia*1) > 0) {
                                if($r->$tolerancia != '') {
                                    //echo $hp.'.'.$dia.'.'.$t_hp->hora_inicio.'.'.$r->$tolerancia.' - ';
                                    $r['dia_id'] = $dia;
                                    $r['horario_plantilla_id'] = $hp;
                                    $r['hora_inicio'] = $t_hp->hora_inicio;
                                    $r['hora_fin'] = $t_hp->hora_fin;
                                    $r['tolerancia'] = $r->$tolerancia;
                                    HorarioProgramado::runNew($r);
                                }
                            }
                        }
                    }
                    $return['rst'] = 1;
                    $return['msj'] = 'Registro creado';
                }                
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
                        ],
            );

            $validator=Validator::make($r->all(), $rules,$mensaje);

            if ( !$validator->fails() ) {
                HorarioProgramado::runEdit($r);
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
            $renturnModel = HorarioProgramado::runLoad($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";    
            return response()->json($return);   
        }
    }

}
