<?php
namespace App\Http\Controllers\Mantenimiento;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Mantenimiento\HorarioPlantilla;

class HorarioPlantillaMA extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  //Esto debe activarse cuando estemos con sessión
    } 

    public function EditStatus(Request $r )
    {
        if ( $r->ajax() ) {
            HorarioPlantilla::runEditStatus($r);
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
                'plantilla_descripcion' => 
                       ['required',
                        Rule::unique('m_horarios_plantillas','plantilla_descripcion')->where(function ($query) use($r) {

                        }),
                        ],
            );
                        
            $validator=Validator::make($r->all(), $rules,$mensaje);

            if ( !$validator->fails() ) {

                if($r->horario_amanecida == 0) {
                    if($r->hora_inicio > $r->hora_fin) {
                        $return['rst'] = 2;
                        $return['msj'] = 'Hora inicio debe ser menor a Hora Fin';
                    } else {
                        HorarioPlantilla::runNew($r);
                        $return['rst'] = 1;
                        $return['msj'] = 'Registro creado';
                    }
                } else {
                    /*if($r->hora_fin > $r->hora_inicio) {
                        $return['rst'] = 2;
                        $return['msj'] = 'Hora Fin debe ser menor a Hora Inicio';
                    } else {
                        HorarioPlantilla::runNew($r);
                        $return['rst'] = 1;
                        $return['msj'] = 'Registro creado';
                    }*/
                    HorarioPlantilla::runNew($r);
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
                'plantilla_descripcion' => 
                       ['required',
                        Rule::unique('m_horarios_plantillas','plantilla_descripcion')->ignore($r->id)->where(function ($query) use($r) {
                        }),
                        ],
            );

            $validator=Validator::make($r->all(), $rules,$mensaje);

            if ( !$validator->fails() ) {
                                
                if($r->horario_amanecida == 0) {
                    if($r->hora_inicio > $r->hora_fin) {
                        $return['rst'] = 2;
                        $return['msj'] = 'Hora inicio debe ser menor a Hora Fin';
                    } else {
                        HorarioPlantilla::runEdit($r);
                        $return['rst'] = 1;
                        $return['msj'] = 'Registro actualizado';
                    }
                } else {
                    /*if($r->hora_fin > $r->hora_inicio) {
                        $return['rst'] = 2;
                        $return['msj'] = 'Hora Fin debe ser menor a Hora Inicio';
                    } else {
                        HorarioPlantilla::runEdit($r);
                        $return['rst'] = 1;
                        $return['msj'] = 'Registro actualizado';
                    }*/
                    HorarioPlantilla::runEdit($r);
                    $return['rst'] = 1;
                    $return['msj'] = 'Registro actualizado';
                }
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
            $renturnModel = HorarioPlantilla::runLoad($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";    
            return response()->json($return);   
        }
    }

    public function ListHorarioPlantilla (Request $r )
    {
        if ( $r->ajax() ) {
            $renturnModel = HorarioPlantilla::ListHorarioPlantilla($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";
            return response()->json($return);
        }
    }
}
