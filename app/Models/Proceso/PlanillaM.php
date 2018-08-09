<?php
namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\Models\Mantenimiento\Consorcio;

use DB;

class PlanillaM extends Model{

    protected   $table = 'p_planilla';

    public function __construct($x=''){
        if($x!='')$this->table=$x;
    }

    public static function infoPlanilla($consorcio,$fecha){

      $ultimaPlanilla = PlanillaM::ultimaPlanilla($consorcio,$fecha);

      $sql = "
        SELECT 
          PC.persona_id,
          PC.id as contrato_id,
          P.nombre,
          P.paterno,
          P.materno,
          PC.tipo_contrato,
          PC.regimen_id,
          PC.cargo_id,
          PC.consorcio_id,
          PC.sede_id,
          PC.sueldo_mensual,
          R.aporte,
          R.comision,
          R.prima,
          R.seguro,
          R.tipo_regimen,
          PC.sueldo_produccion,
          GROUP_CONCAT(DISTINCT(dia_id)) as dias_en_horario,
          COUNT(PA.id) as dias_laborados,
          SUM(UNIX_TIMESTAMP(CONCAT(DATE(NOW()),' ',PA.total_hora_tardanza)) - UNIX_TIMESTAMP(CONCAT(DATE(NOW()),' 00:00:00'))) / 60 / 60 as totalTardanzas
        FROM 
          planilla.p_personas_contratos as PC 
          INNER JOIN m_personas as P ON P.id = PC.persona_id
          INNER JOIN m_regimenes as R ON R.id = PC.regimen_id 
          INNER JOIN p_horarios_programados as HP ON HP.persona_contrato_id = PC.id
          LEFT JOIN p_asistencias as PA ON PA.asistencia_estado_fin IN (0,1) AND PA.persona_contrato_id = PC.id
          AND PA.estado = 1
          AND PA.fecha_ingreso between DATE('$ultimaPlanilla') AND DATE(NOW())
        WHERE 
          PC.estado_contrato = 1 
          AND PC.consorcio_id = $consorcio
          AND PC.estado = 1
        GROUP BY PC.persona_id,PC.id ,
          P.nombre,
          P.paterno,
          P.materno,
          PC.tipo_contrato,
          PC.regimen_id,
          PC.cargo_id,
          PC.consorcio_id,
          PC.sede_id,
          PC.sueldo_mensual,
          R.aporte,
          R.comision,
          R.prima,
          R.seguro,
          R.tipo_regimen,
          PC.sueldo_produccion  
      ";

      $data = DB::select( DB::raw($sql));

      $cr = PlanillaM::crearPlanilla($data,$consorcio,$fecha);

      return $cr;

    }



    private static function crearPlanilla($data,$consorcio,$fecha){
        
        $iData=array();
        $totalBruto =0;
        $totalNeto = 0;
        $totalAporte = 0;
        $trabajadores = 0;
        $descuentos = 0;


        $fechaUtimaPlanilla = PlanillaM::ultimaPlanilla($consorcio,$fecha);
        $fecha_inicio = date("Y-m-d");
        
        $end = date('D-y-m');
        $rangoDias = 0;

        $diasEnElMes=array(
          1=>0, // LUNES
          2=>0,
          3=>0,
          4=>0,
          5=>0,
          6=>0,
          7=>0  //DOMINGO
        );

        $fechaIt=$fechaUtimaPlanilla;

        while(strtotime($fechaIt) <= strtotime($end)){
            $day_num = date('d', strtotime($fechaIt));
            $fechaIt = date("Y-m-d", strtotime("+1 day", strtotime($fechaIt)));
            $rangoDias++;
            $diasEnElMes[date("N", strtotime($fechaIt))]++;
        }

        foreach ($data as $key => $value) {

            $diasHorario = explode(",",$value->dias_en_horario);
            $totalDiasMes=0;

            foreach ($diasHorario as $diaNum) {
                $totalDiasMes+=$diasEnElMes[$diaNum];
            }

            $sueldo =0;

            if($value->tipo_contrato == 1){
              $sueldo =$value->sueldo_produccion;
              $valorPorJornada = $sueldo / $totalDiasMes;
              $pagoBruto = $totalDiasMes*$valorPorJornada;
            }else{
              $sueldo = $value->sueldo_mensual;
              $valorPorJornada = $sueldo / 30;
              $pagoBruto = $rangoDias*$valorPorJornada;
            }


            $diasNoLaborados = ($totalDiasMes-$value->dias_laborados);

            //$descuentoDias = $valorPorJornada*$value->dias_laborados;
            
            $descuentoDias = $valorPorJornada*$diasNoLaborados;

            $aporte = $pagoBruto * ($value->aporte/100);
            $comision = $pagoBruto * ($value->comision/100);
            $prima = $pagoBruto * ($value->prima/100);
            $seguro = $pagoBruto * ($value->seguro/100);
            $regimen = $value->regimen_id;

            $descuentoTotal = $comision+$prima+$seguro+$descuentoDias;

            $iDataTmp = (object) [
                'planilla_id'=>0,
                'persona_id' => $value->persona_id,
                'contrato_id' => $value->contrato_id,
                'sueldo_bruto' => $pagoBruto,
                'sueldo_neto' => $pagoBruto-$descuentoTotal,
                'aporte' => $aporte,
                'comision' => $comision,
                'prima' => $prima,
                'seguro' => $seguro,
                'valor_por_jornada' => $valorPorJornada,
                'estado' => 1,
                'descuento' => $descuentoDias,
                'total_tardanza' => number_format($value->totalTardanzas,2),
                'dias_laborados' => $value->dias_laborados,
                'dias_no_laborados' => $diasNoLaborados,
                'tipo_regimen' => $value->tipo_contrato
            ];


            if($value->dias_laborados > 0){
              $iData[] = $iDataTmp;               
              $totalBruto += $pagoBruto;
              $totalNeto += $pagoBruto-$descuentoTotal;
              $descuentos += $descuentoTotal;
              $totalAporte += $aporte;
              $trabajadores++;
            }

          }
          if($trabajadores > 0){

            $planilla = new PlanillaM("p_planilla");
            $planilla->fecha_inicial = $fechaUtimaPlanilla;
            $planilla->fecha_final = date("Y-m-d");
            $planilla->fecha_generada  = date("Y-m-d");
            $planilla->total_trabajadores  = $trabajadores;
            $planilla->total_aporte  = $totalAporte;
            $planilla->total_bruto = $totalBruto;
            $planilla->total_neto  = $totalNeto;
            $planilla->total_descuentos  = $descuentos;
            $planilla->estado  = 1;
            $planilla->consorcio_id = $consorcio;
            $planilla->generado_por = Auth::user()->id;
            $planilla->save();

            $actConsorcio = Consorcio::find($consorcio);
            $actConsorcio->fecha_ultima_planilla = date("Y-m-d");
            $actConsorcio->save();

            foreach ($iData as $key => $value) {
              $value->planilla_id = $planilla->id;
              PlanillaM::crearDetallePlanilla($value);
            }
            return true;
          }else{
            return false;
          }

    }

    private static function ultimaPlanilla($consorcio,$fecha){

      $x = DB::select( DB::raw("SELECT fecha_ultima_planilla FROM planilla.m_consorcios WHERE estado = 1 AND id = '$consorcio';"));
      
      if(count($x)>0 && $x[0]->fecha_ultima_planilla != null){
        return $x[0]->fecha_ultima_planilla;
      }else{
        return $fecha;
      }
    } 

    public static function listPlanillas($filters){

      if(isset($filters['consorcio']) && isset($filters['fini']) && isset($filters['ffin']))
        $auxQry=" AND c.id = '".$filters['consorcio']."' AND p.fecha_generada BETWEEN DATE('".$filters['fini']."') AND DATE('".$filters['ffin']."')";
      else
        $auxQry ="";


      $qry = "SELECT p.*,c.consorcio,c.ruc FROM p_planilla as p INNER JOIN m_consorcios as c ON c.id = p.consorcio_id WHERE p.estado=1 $auxQry";

     // echo $qry;


        return DB::select(DB::raw($qry));
    }

    public static function listConsorcios(){
        return DB::select(DB::raw("SELECT `id`, `consorcio`, `consorcio_apocope`, `logo`, `ruc`, `fecha_ultima_planilla` FROM m_consorcios as p WHERE p.estado=1"));
    }

    public static function planillaDetalle($idPlanilla){
        return array(
          'data'=>DB::select(DB::raw("SELECT * FROM p_planilla WHERE id=$idPlanilla AND estado = 1")),
          'detalle'=>DB::select(DB::raw("SELECT pd.*, concat(mp.nombre,' ', mp.paterno,' ', mp.materno) as persona FROM p_planilla_detalle as pd INNER JOIN m_personas as mp WHERE planilla_id=$idPlanilla AND mp.estado = 1 AND pd.estado = 1 AND mp.id = pd.persona_id")),
        );
    }

    private static function crearDetallePlanilla($data){

        $ppd = new PlanillaM("p_planilla_detalle");
        foreach ($data as $key => $value) {
            $ppd->$key = $data->$key;
        }
        $ppd->save();
    }

    private static function diasTrabajados(){

    }


}
