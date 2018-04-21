<?php
namespace App\Http\Controllers\Mantenimiento;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mantenimiento\Consorcio;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Excel;

class ConsorcioMA extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  //Esto debe activarse cuando estemos con sessión
    } 

    public function EditStatus(Request $r )
    {
        if ( $r->ajax() ) {
            Consorcio::runEditStatus($r);
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
                'unique'        => ':attribute solo debe ser único',
            );

            $rules = array(
                'consorcio' => 
                       ['required',
                        Rule::unique('m_consorcios','consorcio'),
                        ],
            );

            
            $validator=Validator::make($r->all(), $rules,$mensaje);

            if ( !$validator->fails() ) {
                Consorcio::runNew($r);
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
                'consorcio' => 
                       ['required',
                        Rule::unique('m_consorcios','consorcio')->ignore($r->id),
                        ],
            );

            $validator=Validator::make($r->all(), $rules,$mensaje);

            if ( !$validator->fails() ) {
                Consorcio::runEdit($r);
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
            $renturnModel = Consorcio::runLoad($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";
            return response()->json($return);
        }
    }
    
    public function ListConsorcio (Request $r )
    {
        if ( $r->ajax() ) {
            $renturnModel = Consorcio::ListConsorcio($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";
            return response()->json($return);
        }
    }
    
    public function ListConsorcioandusuario (Request $r )
    {
        if ( $r->ajax() ) {
            $renturnModel = Consorcio::ListConsorcioandUsuario($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";
            return response()->json($return);
        }
    }

    // Export
    public function ExportConsorcio(Request $r )
    {
        $renturnModel = Consorcio::runExport($r);
        
        Excel::create('Consorcio', function($excel) use($renturnModel) {
        
        $excel->setTitle('Reporte de Consorcioes')
              ->setCreator('Jorge Salcedo')
              ->setCompany('JS Soluciones')
              ->setDescription('ODE o Consorcioes');

        $excel->sheet('Consorcio', function($sheet) use($renturnModel) {
            $sheet->setOrientation('landscape');
            $sheet->setPageMargin(array(
                0.25, 0.30, 0.25, 0.30
            ));

            $sheet->setStyle(array(
                'font' => array(
                    'name'      =>  'Bookman Old Style',
                    'size'      =>  8,
                    'bold'      =>  false
                )
            ));

            $sheet->cell('A1', function($cell) {
                $cell->setValue('REPORTE DE SEDES');
                $cell->setFont(array(
                    'family'     => 'Bookman Old Style',
                    'size'       => '20',
                    'bold'       =>  true
                ));
            });
            $sheet->mergeCells('A1:'.$renturnModel['max'].'1');
            $sheet->cells('A1:'.$renturnModel['max'].'1', function($cells) {
                $cells->setBorder('solid', 'none', 'none', 'solid');
                $cells->setAlignment('center');
                $cells->setValignment('center');
            });
            
            $sheet->setWidth($renturnModel['length']);
            $sheet->fromArray(array(
                array(''),
                $renturnModel['cabecera']
            ));
            
            $data=json_decode(json_encode($renturnModel['data']), true);
            $sheet->rows($data);
            
            $sheet->cells('A3:'.$renturnModel['max'].'3', function($cells) {
                $cells->setBorder('solid', 'none', 'none', 'solid');
                $cells->setAlignment('center');
                $cells->setValignment('center');
                $cells->setFont(array(
                    'family'     => 'Bookman Old Style',
                    'size'       => '10',
                    'bold'       =>  true
                ));
            });

            $count = $sheet->getHighestRow();

            $sheet->setBorder('A3:'.$renturnModel['max'].$count, 'thin');

        });
        
        })->export('xlsx');
    }

}
