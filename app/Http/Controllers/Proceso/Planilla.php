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

            $param_data = array('programacion_unica_id' => $r->programacion_unica_id);


            $x = PlanillaM::infoPlanilla();

            $return['rst'] = 1;
            $return['data'] = ( $x ? array('result'=>1) : array('result'=>0) );
            $return['msj'] = ( $x ? 'Planilla generada correctamente' : 'No se ha generado la planilla.' );
            return response()->json($return);

        }
    }


    public function verPlanillas(Request $r ){
        if ( $r->ajax() ) {
            $idcliente = session('idcliente');
            $list = PlanillaM::listPlanillas();

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

<table width="100%" border=1>
	<tr>
		<th width="20%">Fecha Inicial</th>
		<th width="20%">Fecha Final</th>
		<th width="20%">Fecha Generado</th>
		<th width="20%">Total Pagado</th>
		<th width="20%">Total Aporte</th>
		<th width="20%">Total Descuentos</th>
	</tr>
</table>


<?php

		$html="<tr><td>Fecha generada</td><td>Fecha inicial</td><td>Fecha final</td><td></td><td></td></tr>";

echo "AS";

		$html .="<table border=1>";





		if(count($list['detalle'])>0){


			$html .= '<tr><th>'.implode("</th><th>", array_keys((array)$list['data'][0])).'</th></tr>';
			$html .= '<tr><th>'.implode("</th><th>", ((array)$list['data'][0])).'</th></tr>';



			$html .= '<tr><th></th><th>v</th></tr>';

			

			$html .= '<tr><th>'.implode("</th><th>", array_keys((array)$list['detalle'][0])).'</th></tr>';

			foreach ($list['detalle'] as $key => $value) {
				$html .= '<tr><td>'.implode("</td><td>", (array)$value).'</td></tr>';
			}

		}else{
			$html.="<tr><td>Sin registros</td></tr>";
		}

		$html.="</table>";

        return $html;
        
    }



}