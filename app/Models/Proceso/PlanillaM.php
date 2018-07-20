<?php
namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use DB;

class PlanillaM extends Model{

    protected   $table = 'p_planilla';

    public function __construct($x=''){
        if($x!='')$this->table=$x;
    }

    public static function infoPlanilla(){


      $ultimaPlanilla = PlanillaM::ultimaPlanilla();

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

      $cr = PlanillaM::crearPlanilla($data);

      return $cr;

    }



    private static function crearPlanilla($data){
        
        $iData=array();
        $totalBruto =0;
        $totalNeto = 0;
        $totalAporte = 0;
        $trabajadores = 0;
        $descuentos = 0;


        $fechaUtimaPlanilla = PlanillaM::ultimaPlanilla();
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

        $fechaUtimaPlanillaAux=$fechaUtimaPlanilla;

        while(strtotime($fechaUtimaPlanillaAux) <= strtotime($end)){
            $day_num = date('d', strtotime($fechaUtimaPlanillaAux));
            $fechaUtimaPlanillaAux = date("Y-m-d", strtotime("+1 day", strtotime($fechaUtimaPlanillaAux)));
            $rangoDias++;
            $diasEnElMes[date("N", strtotime($fechaUtimaPlanillaAux))]++;
        }

        foreach ($data as $key => $value) {

            $dh = explode(",",$value->dias_en_horario);
            $totalDiasMes=0;

            foreach ($dh as $da) {
                $totalDiasMes+=$diasEnElMes[$da];
            }

            //$valorPorJornada = $value->sueldo_mensual / $totalDiasMes;
            $valorPorJornada = $value->sueldo_mensual / 30;

            $pagoBruto = $value->rangoDias*$valorPorJornada;

            $diasNoLaborados = ($totalDiasMes-$value->dias_laborados);
            $descuentoDias = $valorPorJornada*$value->dias_laborados;
            //$descuentoDias = $valorPorJornada*$diasNoLaborados;
            $aporte = $value->sueldo_mensual * ($value->aporte/100);
            $comision = $value->sueldo_mensual * ($value->comision/100);
            $prima = $value->sueldo_mensual * ($value->prima/100);
            $seguro = $value->sueldo_mensual * ($value->seguro/100);
            $regimen = $value->regimen_id;

            $descuentoTotal = $aporte+$comision+$prima+$seguro+$descuentoDias;

            $iDataTmp = (object) [
                'planilla_id'=>0,
                'persona_id' => $value->persona_id,
                'contrato_id' => $value->contrato_id,
                'sueldo_bruto' => $value->sueldo_mensual,
                'sueldo_neto' => $pagoBruto-$descuentoTotal,
                'aporte' => $aporte,
                'comision' => $comision,
                'prima' => $prima,
                'seguro' => $seguro,
                'valor_por_jornada' => $valorPorJornada,
                'estado' => 1,
                'descuento' => $descuentoTotal,
                'total_tardanza' => number_format($value->totalTardanzas,2),
                'dias_laborados' => $value->dias_laborados,
                'dias_no_laborados' => $diasNoLaborados,
                'tipo_regimen' => $regimen
            ];


            if($value->dias_laborados > 0){
              $iData[] = $iDataTmp;               
              $totalBruto += $value->sueldo_mensual;
              $totalNeto += $value->sueldo_mensual-$descuentoTotal;
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
            $planilla->generado_por  = Auth::user()->id;
            $planilla->save();


            foreach ($iData as $key => $value) {
              $value->planilla_id = $planilla->id;
              PlanillaM::crearDetallePlanilla($value);
            }
            return true;
          }else{
            return false;
          }




    }

    private static function ultimaPlanilla(){

      $x = DB::select( DB::raw("SELECT fecha_final FROM p_planilla ORDER BY fecha_generada DESC LIMIT 1"))[0]->fecha_final;
      
      return $x;

    } 


    public static function listPlanillas(){
        return DB::select(DB::raw("SELECT * FROM p_planilla WHERE estado = 1"));
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
