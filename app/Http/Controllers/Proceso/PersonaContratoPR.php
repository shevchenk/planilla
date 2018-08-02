<?php
namespace App\Http\Controllers\Proceso;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proceso\PersonaContrato;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PDF;

class PersonaContratoPR extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  //Esto debe activarse cuando estemos con sessión
    } 

    public function EditStatus(Request $r )
    {
        if ( $r->ajax() ) {
            PersonaContrato::runEditStatus($r);
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
                'persona_id' => 
                       ['required',
//                        Rule::unique('m_regimenes','regimen')->where(function ($query) use($r) {
//                                $query->where('pregunta_id',$r->pregunta_id );
//                        }),
                        ],
            );

            
            $validator=Validator::make($r->all(), $rules,$mensaje);

            if ( !$validator->fails() ) {
                PersonaContrato::runNew($r);
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
                'persona_id' => 
                       ['required',
//                        Rule::unique('m_regimenes','regimen')->ignore($r->id)->where(function ($query) use($r) {
                              //  $query->where('pregunta_id',$r->pregunta_id );
//                        }),
                        ],
            );

            $validator=Validator::make($r->all(), $rules,$mensaje);

            if ( !$validator->fails() ) {
                PersonaContrato::runEdit($r);
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
            $renturnModel = PersonaContrato::runLoad($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";    
            return response()->json($return);   
        }
    }
    
        public function LoadPersonaContrato (Request $r )
    {
        if ( $r->ajax() ) {
            $renturnModel = PersonaContrato::runLoadPersonaContrato($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";
            return response()->json($return);
        }
    }

        public function LoadReporteHorario (Request $r )
    {
        if ( $r->ajax() ) {
            $renturnModel = PersonaContrato::runLoadReporteHorario($r);
            
            $return['rst'] = 1;
            $return['data'] = $renturnModel['result'];
            $return['cabecera'] = $renturnModel['cabecera'];
            $return['msj'] = "No hay registros aún";
            return response()->json($return);
        }
    }
    
        public function LoadBoleta (Request $r )
    {
        if ( $r->ajax() ) {
            $renturnModel = PersonaContrato::runLoadBoleta($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";
            return response()->json($return);
        }
    }
    
    public function GenerarPDF(Request $r) {

        $renturnModel = PersonaContrato::runLoadBoletaFind($r);
//        $HeadBallotPdf=Balotario::runHeadBallotPdf($r);
        
        $data = ['boletas' => $renturnModel];

	$pdf = PDF::Make();
        $pdf->SetHeader('TELESUP|Boletas|{PAGENO}');
        $pdf->SetFooter('TELESUP');

	$pdf->loadView('mantenimiento.plantilla.boletapdf', $data);
	return $pdf->Stream('document.pdf');

    }
}
