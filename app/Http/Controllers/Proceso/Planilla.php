<?php
namespace App\Http\Controllers\Proceso;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Api;
use App\Models\Proceso\PlanillaM;
use Illuminate\Support\Facades\Auth; 
use DB;

class Planilla extends Controller{
    private $api;

    public function __construct(){
        $this->api = new Api();
        $this->middleware('auth');  //Esto debe activarse cuando estemos con sessión
        
    }


    public function generar(Request $r ){
        if ( $r->ajax() ) {

            $idcliente = session('idcliente');

            if(!isset($r->consorcio)){
                die("Petición invalida.");
            }

            $x = PlanillaM::infoPlanilla($r->consorcio,$r->fecha);
                
            $return['rst'] = 1;
            $return['data'] = ( $x ? array('result'=>1) : array('result'=>0) );
            $return['msj'] = ( $x ? 'Planilla generada correctamente' : 'No hay trabajadores pendientes por generar en el mes seleccionado.' );
            return response()->json($return);

        }
    }


    public function verPlanillas(Request $r ){
        if ( $r->ajax() ) {
            $idcliente = session('idcliente');
            $mfilt = array();

            if(isset($r->fconsorcio) && $r->fconsorcio!='' && $r->fconsorcio!='0'){
                $mfilt['consorcio'] = $r->fconsorcio;
            }
            if(isset($r->ffecha_ini) && $r->ffecha_ini!='' && $r->ffecha_ini!='0'){                
                $mfilt['fini'] = $r->ffecha_ini;
                $mfilt['ffin'] = $r->ffecha_fin;
            }

            $list = PlanillaM::listPlanillas($mfilt);

            $months = array('01' => 'Enero','02' => 'Febrero','03' => 'Marzo','04' => 'Abril','05' => 'Mayo','06' => 'Junio','07' => 'Julio','08' => 'Agosto','09' => 'Septiembre','10' => 'Octubre','11' => 'Noviembre','12' => 'Diciembre');

            function nxFormat($str){$x=explode(",",$str);return $x[0].'</b>,<small>'.$x[1].'</small>';}

            foreach ($list as $key => $value) {
                $date = explode('-',date("Y-m-d",strtotime($value->fecha_generada)));
                $list[$key]->fecha_generada = $date[2].' de '.$months[$date[1]].' de '.$date[0];
                $list[$key]->total_neto = nxFormat(number_format($list[$key]->total_neto,2,',','.'));
                $list[$key]->total_descuentos = nxFormat(number_format($list[$key]->total_descuentos,2,',','.'));
            }

            return response()->json($list);

        }
    }

    public function verConsorcios(Request $r ){
        if ( $r->ajax() ) {
            $idcliente = session('idcliente');
            $list = PlanillaM::listConsorcios();

            $months = array('01' => 'Enero','02' => 'Febrero','03' => 'Marzo','04' => 'Abril','05' => 'Mayo','06' => 'Junio','07' => 'Julio','08' => 'Agosto','09' => 'Septiembre','10' => 'Octubre','11' => 'Noviembre','12' => 'Diciembre');  

            return response()->json($list);
        }
    }



    public function verPlanillaDetalle(Request $r, $idPlanilla){

        $idcliente = session('idcliente');
        $list = PlanillaM::planillaDetalle($idPlanilla);

		$months = array('01' => 'Enero','02' => 'Febrero','03' => 'Marzo','04' => 'Abril','05' => 'Mayo','06' => 'Junio','07' => 'Julio','08' => 'Agosto','09' => 'Septiembre','10' => 'Octubre','11' => 'Noviembre','12' => 'Diciembre');


		$date = explode('-',date("Y-m-d",strtotime($list['data'][0]->fecha_generada)));
		$list['data'][0]->fecha_generada = $date[2].' de '.$months[$date[1]].' de '.$date[0];

		$date = explode('-',date("Y-m-d",strtotime($list['data'][0]->fecha_inicial)));
		$list['data'][0]->fecha_inicial = $date[2].' de '.$months[$date[1]].' de '.$date[0];

		$date = explode('-',date("Y-m-d",strtotime($list['data'][0]->fecha_final)));
		$list['data'][0]->fecha_final = $date[2].' de '.$months[$date[1]].' de '.$date[0];



?>

<table width="100%" border=0>
    <tr align="center">
        <th width="20%">Fecha Inicial</th>
        <th width="20%">Fecha Final</th>
        <th width="20%">Fecha Generado</th>
        <th width="20%">Total Pagado</th>
        <th width="20%">Total Aporte</th>
        <th width="20%">Total Descuentos</th>
    </tr>




<?php


		$html="";

		if(count($list['detalle'])>0){

            $html.="<tr align=\"center\"><td>".$list['data'][0]->fecha_inicial."</td><td>".$list['data'][0]->fecha_final."</td><td>".$list['data'][0]->fecha_generada."</td><td>".$list['data'][0]->total_neto."</td><td>".$list['data'][0]->total_aporte."</td><td>".$list['data'][0]->total_descuentos."</td></tr></table>";

			//$html .= '<tr><th>'.implode("</th><th>", array_keys((array)$list['data'][0])).'</th></tr>';
			//$html .= '<tr><th>'.implode("</th><th>", ((array)$list['data'][0])).'</th></tr>';


			foreach ($list['detalle'] as $key => $value) {
				$html .= "<br><hr><br>



                <table width=\"100%\" border=\"0\" align=\"center\">
                    <tr style=\"background-color: #E5E5E5FF;\">
                        
                        <th colspan=\"11\">".strtoupper($value->persona)."</th>
                    </tr>
                    <tr>
                        <th>Sueldo Bruto</th>
                        <th>Remun. Basica</th>
                        <th>Ingreso Asignación familiar</th>
                        <th>Días laborados</th>
                        <th>Monto Días laborados</th>
                        <th>Vacac.</th>
                        <th>Ingreso Vacaciones</th>
                        <th>Horas extra</th>
                        <th>Ingreso horas extra</th>
                        <th>Bonos</th>
                        <th>EsSalud</th>
                    </tr>
                    <tr align=\"center\">
                        <td>".$value->sueldo_bruto."</td>
                        <td>".$value->remuneracion_basica."</td>
                        <td>".$value->ingreso_asig_familiar."</td>
                        <td>".$value->dias_laborados."</td>
                        <td>".$value->ingreso_dias_laborados."</td>
                        <td>".$value->vacaciones."</td>
                        <td>".$value->ingreso_vacaciones."</td>
                        <td>".$value->horas_extras."</td>
                        <td>".$value->ingreso_horas_extras."</td>
                        <td>".$value->bonos."</td>
                        <td>".$value->aporte_essalud."</td>
                    </tr>

                    </table>
                   <table width=\"100%\" border=\"0\">
                    <tr>
                        <th colspan=\"10\">BONOS</th>
                    </tr>



                    <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    </tr>


                    ";



                    $x = json_decode($value->bonos_detalle);
                    
                    $html .= "<tr>";
                    if(is_array($x)) for ($i=0; $i < count($x); $i++) {
                        if($x%10==0)
                            $html .= "</tr><tr align=\"center\">";
                        $html .= "<td width=\"10%\">".$x[$i]->m." [".$x[$i]->n."]</td>";
                    }


                    $html .= "</tr>
                </table>

                <table width=\"100%\" border=\"0\">
                        <th colspan=\"11\">DESCUENTOS</th>
                    </tr>
                    <tr>
                        <th>Días No laborados</th>
                        <th>Descuento días no laborados</th>
                        <th>Total tardanza</th>
                        <th>Desc. Tardanza</th>
                        <th>Desc. Permisos</th>
                        <th>Desc. Prestamo</th>
                        <th>Desc. 5ta.</th>
                        <th>Desc. Regimen Seguro</th>
                        <th>Desc. Regimen Aporte</th>
                        <th>Desc. Regimen Comisión</th>
                        <th>Desc. Regimen Prima</th>

                    </tr>
                    <tr  align=\"center\">
                        <td>".$value->dias_no_laborados."</td>
                        <td>".$value->dscto_dias_no_laborados."</td>
                        <td>".$value->total_tardanza."</td>
                        <td>".$value->dscto_total_tardanza."</td>
                        <td>".$value->dscto_permisos."</td>
                        <td>".$value->dscto_prestamo."</td>
                        <td>".$value->dscto_quinta."</td>
                        <td>".$value->dscto_regimen_seguro."</td>
                        <td>".$value->dscto_regimen_aporte."</td>
                        <td>".$value->dscto_regimen_comision."</td>
                        <td>".$value->dscto_regimen_prima."</td>
                    </tr>
                </table>";
			}


		}else{
			$html.="<tr><td>Sin registros</td></tr>";
		}

		$html.="</table>";

        return $html;
        
    }



}
