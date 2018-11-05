<?php
namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\Models\Mantenimiento\Consorcio;

use DB;

class PlanillaM extends Model{

    protected   $table = 'p_planillas';

    public function __construct($x=''){
        if($x!='')$this->table=$x;
    }

    public static function infoPlanilla($consorcio,$fecha){

      $cf = PlanillaM::ultimaPlanilla($consorcio,$fecha);

      $config = PlanillaM::loadConfig();
      $mes = substr($fecha, 5,2);

      $fi = $fecha.'-'.str_pad($cf->dia_ciclo,2,'0',STR_PAD_LEFT);
      $ff = date("Y-m-d",strtotime($fi." +1 month -1 day"));

      $essalud = $config->essalud;
      $asignacion_familiar = $config->asig_familiar;

      $sql = "
        SELECT 
            trab.persona_id, contrato_id, sueldo_bruto
            , remuneracion_basica, ingreso_asig_familiar, dias_laborados, ingreso_dias_laborados, vacaciones, ingreso_vacaciones, horas_extras, ingreso_horas_extras, bonos, bonos_detalle
            , dias_no_laborados, dscto_dias_no_laborados, total_tardanza, dscto_total_tardanza, dscto_permisos, dscto_prestamo
            , pla.acu_dscto_quinta, pla.acu_sueldo_neto
            , IFNULL((SELECT ROUND(((rq.dscto_proyectado_acumulado
                                    +( (remuneracion_basica*(12-$mes+1)+IFNULL(pla.acu_sueldo_neto,0)) - (7*4040)
                                    -rq.importe_minimo_calculado+1)*rq.descuento)
                                    -IFNULL(pla.acu_dscto_quinta,0))/(12-$mes+1),2)
                FROM a_renta_quinta rq 
                WHERE remuneracion_basica*(12-$mes+1)+IFNULL(acu_sueldo_neto,0)-(7*4040) BETWEEN rq.importe_minimo_calculado AND rq.importe_maximo_calculado ),0) dscto_quinta
            , ROUND(seguro*remuneracion_basica,2) dscto_regimen_seguro
            , ROUND(aporte*remuneracion_basica,2) dscto_regimen_aporte, ROUND(comision*remuneracion_basica,2) dscto_regimen_comision
            , ROUND(prima*remuneracion_basica,2) dscto_regimen_prima, ROUND(essalud*remuneracion_basica,2) aporte_essalud

             FROM
            (SELECT pc.persona_id, pc.id contrato_id
            , pc.regimen_id, IF(pc.asignacion_familiar=1,$asignacion_familiar,0) ingreso_asig_familiar, pc.tipo_contrato, r.seguro, r.aporte, r.comision, r.prima, $essalud essalud
            , IF(pc.tipo_contrato=1 OR pc.tipo_contrato=2,pc.sueldo_mensual,0) sueldo_bruto
            , IF(pc.tipo_contrato=2, 
                    ROUND(pc.sueldo_mensual-((pc.sueldo_mensual/30) * COUNT( IF(a.asistencia_estado_fin>=2,1,NULL) )),2)
                    - ROUND(SUM(TIME_TO_SEC(a.total_hora_tardanza))/60*(pc.sueldo_mensual/(30*8*60)),2)
                    + IF(pc.horaextra=1,
                                ROUND((SUM(
                                    IF(hp.horario_amanecida=0 AND a.hora_salida>hp.hora_fin AND a.fecha_salida=a.fecha_ingreso,
                                        TIME_TO_SEC(TIMEDIFF(a.hora_salida,hp.hora_fin))
                                        ,IF(hp.horario_amanecida=0 AND a.hora_salida>hp.hora_fin AND a.fecha_salida>a.fecha_ingreso,
                                            TIME_TO_SEC(a.hora_salida) + TIME_TO_SEC(TIMEDIFF('24:00:00',hp.hora_fin)) 
                                            ,IF(hp.horario_amanecida=1 AND a.hora_salida>hp.hora_fin AND a.fecha_salida>a.fecha_ingreso,
                                                TIME_TO_SEC(TIMEDIFF(a.hora_salida,hp.hora_fin)),0
                                        ))))/60)*(pc.sueldo_mensual/(30*8*60)),2)
                            ,0)
                    +    pc.monto_adicional
                    ,IF(pc.tipo_contrato=1, 
                    ROUND(pc.sueldo_mensual-((pc.sueldo_mensual/count(hp.id))* COUNT( IF(a.asistencia_estado_fin>=2,1,NULL) )),2)
                    - ROUND((SUM(TIME_TO_SEC(a.total_hora_tardanza))/60)*(pc.sueldo_mensual/(count(hp.id)*8*60)),2)
                    + IF(pc.horaextra=1,
                                ROUND((SUM(
                                    IF(hp.horario_amanecida=0 AND a.hora_salida>hp.hora_fin AND a.fecha_salida=a.fecha_ingreso,
                                        TIME_TO_SEC(TIMEDIFF(a.hora_salida,hp.hora_fin))
                                        ,IF(hp.horario_amanecida=0 AND a.hora_salida>hp.hora_fin AND a.fecha_salida>a.fecha_ingreso,
                                            TIME_TO_SEC(a.hora_salida) + TIME_TO_SEC(TIMEDIFF('24:00:00',hp.hora_fin)) 
                                            ,IF(hp.horario_amanecida=1 AND a.hora_salida>hp.hora_fin AND a.fecha_salida>a.fecha_ingreso,
                                                TIME_TO_SEC(TIMEDIFF(a.hora_salida,hp.hora_fin)),0
                                        ))))/60)*(pc.sueldo_mensual/(count(hp.id)*8*60)),2)
                            ,0)
                    + pc.monto_adicional
                    ,IF(pc.tipo_contrato=3, 
                    ROUND(SUM((TIME_TO_SEC(TIMEDIFF(hp.hora_fin,hp.hora_inicio))/60)*(hp.monto_hora/60)) ,2)
                    - ROUND((SUM( (TIME_TO_SEC(a.total_hora_tardanza)/60)*(hp.monto_hora/60) )),2)
                    + IF(pc.horaextra=1,
                                ROUND((SUM(
                                    IF(hp.horario_amanecida=0 AND a.hora_salida>hp.hora_fin AND a.fecha_salida=a.fecha_ingreso,
                                        (TIME_TO_SEC(TIMEDIFF(a.hora_salida,hp.hora_fin))/60) * (hp.monto_hora/60)
                                        ,IF(hp.horario_amanecida=0 AND a.hora_salida>hp.hora_fin AND a.fecha_salida>a.fecha_ingreso,
                                            ((TIME_TO_SEC(a.hora_salida) + TIME_TO_SEC(TIMEDIFF('24:00:00',hp.hora_fin)))/60) * (hp.monto_hora/60)
                                            ,IF(hp.horario_amanecida=1 AND a.hora_salida>hp.hora_fin AND a.fecha_salida>a.fecha_ingreso,
                                                (TIME_TO_SEC(TIMEDIFF(a.hora_salida,hp.hora_fin))/60) * (hp.monto_hora/60),0
                                        ))))),2)
                            ,0)
                    + pc.monto_adicional        
                ,0
            ))) remuneracion_basica
            , (SUM(TIME_TO_SEC(a.total_hora_tardanza))/60) total_tardanza
            , ROUND(IF(pc.tipo_contrato=2, 
                    SUM(TIME_TO_SEC(a.total_hora_tardanza))/60*(pc.sueldo_mensual/(30*8*60))
                    ,IF(pc.tipo_contrato=1,
                    (SUM(TIME_TO_SEC(a.total_hora_tardanza))/60)*(pc.sueldo_mensual/(count(hp.id)*8*60))
                    ,IF(pc.tipo_contrato=3,
                    (SUM( (TIME_TO_SEC(a.total_hora_tardanza)/60)*(hp.monto_hora/60) )),0
            ))),2) dscto_total_tardanza

            , COUNT(IF(et.id=1,ea.id,NULL)) vacaciones
            , ROUND(IF(pc.tipo_contrato=2, 
                    (pc.sueldo_mensual/30) * COUNT(IF(et.id=1,ea.id,NULL))
                    ,IF(pc.tipo_contrato=1,
                    (pc.sueldo_mensual/count(hp.id))* COUNT(IF(et.id=1,ea.id,NULL))
                    ,IF(pc.tipo_contrato=3,
                    SUM((TIME_TO_SEC(IF(et.id=1,TIMEDIFF(hp.hora_fin,hp.hora_inicio),0))/60)*(hp.monto_hora/60)),0
            ))),2) ingreso_vacaciones
            , IF(pc.tipo_contrato=2,
                30-COUNT( IF(a.asistencia_estado_fin>=2,1,NULL) )- COUNT(IF(et.id=1,ea.id,NULL)),
                IF(pc.tipo_contrato=1 OR pc.tipo_contrato=3,
                COUNT( IF(a.asistencia_estado_fin<2,1,NULL) )- COUNT(IF(et.id=1,ea.id,NULL)),0
            )) dias_laborados
            , ROUND(IF(pc.tipo_contrato=2, 
                    (pc.sueldo_mensual/30) * (30-COUNT( IF(a.asistencia_estado_fin>=2,1,NULL) ) - COUNT(IF(et.id=1,ea.id,NULL))) 
                    ,IF(pc.tipo_contrato=1,
                    (pc.sueldo_mensual/count(hp.id))* (COUNT( IF(a.asistencia_estado_fin<2,1,NULL) ) - COUNT(IF(et.id=1,ea.id,NULL)))
                    ,IF(pc.tipo_contrato=3,
                    SUM((TIME_TO_SEC(TIMEDIFF(hp.hora_fin,hp.hora_inicio))/60)*(hp.monto_hora/60))- SUM((TIME_TO_SEC(IF(et.id=1,TIMEDIFF(hp.hora_fin,hp.hora_inicio),0))/60)*(hp.monto_hora/60)),0
            ))),2) ingreso_dias_laborados
            , IF(pc.tipo_contrato=2 OR pc.tipo_contrato=1,
                COUNT( IF(a.asistencia_estado_fin>=2,1,NULL) ),0) dias_no_laborados    
            , ROUND(IF(pc.tipo_contrato=2, 
                    ((pc.sueldo_mensual/30) * COUNT( IF(a.asistencia_estado_fin>=2,1,NULL) ))
                    ,IF(pc.tipo_contrato=1,
                    ((pc.sueldo_mensual/count(hp.id))* COUNT( IF(a.asistencia_estado_fin>=2,1,NULL) ))
                    ,IF(pc.tipo_contrato=3,
                    0,0
            ))),2) dscto_dias_no_laborados
            , (SUM(
                    IF(hp.horario_amanecida=0 AND a.hora_salida>hp.hora_fin AND a.fecha_salida=a.fecha_ingreso,
                        TIME_TO_SEC(TIMEDIFF(a.hora_salida,hp.hora_fin))
                        ,IF(hp.horario_amanecida=0 AND a.hora_salida>hp.hora_fin AND a.fecha_salida>a.fecha_ingreso,
                            TIME_TO_SEC(a.hora_salida) + TIME_TO_SEC(TIMEDIFF('24:00:00',hp.hora_fin)) 
                            ,IF(hp.horario_amanecida=1 AND a.hora_salida>hp.hora_fin AND a.fecha_salida>a.fecha_ingreso,
                                TIME_TO_SEC(TIMEDIFF(a.hora_salida,hp.hora_fin)),0
                        ))))/60) horas_extras
            , ROUND(IF(pc.tipo_contrato=2, 
                    (SUM(
                    IF(hp.horario_amanecida=0 AND a.hora_salida>hp.hora_fin AND a.fecha_salida=a.fecha_ingreso,
                        TIME_TO_SEC(TIMEDIFF(a.hora_salida,hp.hora_fin))
                        ,IF(hp.horario_amanecida=0 AND a.hora_salida>hp.hora_fin AND a.fecha_salida>a.fecha_ingreso,
                            TIME_TO_SEC(a.hora_salida) + TIME_TO_SEC(TIMEDIFF('24:00:00',hp.hora_fin)) 
                            ,IF(hp.horario_amanecida=1 AND a.hora_salida>hp.hora_fin AND a.fecha_salida>a.fecha_ingreso,
                                TIME_TO_SEC(TIMEDIFF(a.hora_salida,hp.hora_fin)),0
                        ))))/60)*(pc.sueldo_mensual/(30*8*60))
                    ,IF(pc.tipo_contrato=1,
                    (SUM(
                    IF(hp.horario_amanecida=0 AND a.hora_salida>hp.hora_fin AND a.fecha_salida=a.fecha_ingreso,
                        TIME_TO_SEC(TIMEDIFF(a.hora_salida,hp.hora_fin))
                        ,IF(hp.horario_amanecida=0 AND a.hora_salida>hp.hora_fin AND a.fecha_salida>a.fecha_ingreso,
                            TIME_TO_SEC(a.hora_salida) + TIME_TO_SEC(TIMEDIFF('24:00:00',hp.hora_fin)) 
                            ,IF(hp.horario_amanecida=1 AND a.hora_salida>hp.hora_fin AND a.fecha_salida>a.fecha_ingreso,
                                TIME_TO_SEC(TIMEDIFF(a.hora_salida,hp.hora_fin)),0
                        ))))/60)*(pc.sueldo_mensual/(count(hp.id)*8*60))
                    ,IF(pc.tipo_contrato=3,
                    (SUM(
                    IF(hp.horario_amanecida=0 AND a.hora_salida>hp.hora_fin AND a.fecha_salida=a.fecha_ingreso,
                        (TIME_TO_SEC(TIMEDIFF(a.hora_salida,hp.hora_fin))/60)*(hp.monto_hora/60)
                        ,IF(hp.horario_amanecida=0 AND a.hora_salida>hp.hora_fin AND a.fecha_salida>a.fecha_ingreso,
                            ((TIME_TO_SEC(a.hora_salida) + TIME_TO_SEC(TIMEDIFF('24:00:00',hp.hora_fin)) )/60) * (hp.monto_hora/60)
                            ,IF(hp.horario_amanecida=1 AND a.hora_salida>hp.hora_fin AND a.fecha_salida>a.fecha_ingreso,
                                (TIME_TO_SEC(TIMEDIFF(a.hora_salida,hp.hora_fin))/60)*(hp.monto_hora/60),0
                        ))))),0
            ))),2) ingreso_horas_extras
            , IFNULL((SELECT SUM(pp.monto_programado) FROM m_personas_prestamos pp WHERE MONTH(pp.mes_programado)=$mes AND pp.estado=1),0) dscto_prestamo
            , pc.monto_adicional bonos, pc.conceptos_adicionales bonos_detalle
            , 0 dscto_permisos
            , p.dni
            FROM m_personas p
            INNER JOIN p_personas_contratos pc ON pc.persona_id=p.id
            INNER JOIN m_regimenes r ON r.id=pc.regimen_id
            INNER JOIN fechas f
            LEFT JOIN p_horarios_programados hp ON hp.persona_contrato_id=pc.id AND hp.dia_id=f.dia AND hp.estado=1
            LEFT JOIN p_asistencias a ON a.persona_contrato_id=pc.id AND f.fecha=a.fecha_ingreso AND a.estado=1
            LEFT JOIN p_eventos_asistencias ea ON ea.asistencia_id=a.id AND ea.estado=1
            LEFT JOIN p_eventos e ON e.id=ea.evento_id AND e.estado=1
            LEFT JOIN m_eventos_tipos et ON et.id=e.evento_tipo_id
            AND a.estado=1 AND a.fecha_ingreso BETWEEN '$fi' AND '$ff' 
            WHERE pc.consorcio_id='$consorcio'
            GROUP BY pc.id,pc.persona_id,pc.regimen_id,pc.asignacion_familiar,pc.tipo_contrato,r.seguro,r.aporte,r.comision,r.prima,pc.sueldo_mensual,
            pc.horaextra,pc.monto_adicional,pc.conceptos_adicionales, p.dni
            ) trab
            LEFT JOIN (
                SELECT pd.persona_id, SUM(pd.dscto_quinta) AS acu_dscto_quinta, SUM(pd.remuneracion_basica) AS acu_sueldo_neto
                FROM p_planillas_detalles pd
                INNER JOIN p_planillas p ON p.id=pd.planilla_id AND p.estado=1
                WHERE YEAR(p.fecha_generada)=YEAR(CURDATE()) AND pd.estado=1
                GROUP BY pd.persona_id
            ) pla ON pla.persona_id=trab.persona_id
            LEFT JOIN (
                SELECT pd.persona_id
                FROM p_planillas_detalles pd
                INNER JOIN p_planillas p ON p.id=pd.planilla_id AND p.estado=1
                WHERE p.consorcio_id = $consorcio 
                AND p.fecha_inicial = '$fi' 
                AND p.fecha_final = '$ff' 
            ) as PG ON PG.persona_id=trab.persona_id 
            WHERE PG.persona_id IS NULL
            /*
            Probar cuando lleva un dia sin programacion
            Probar las programaciones con 2 a mas veces al dia
            Probar las tardanzas de amanecida y sus eventos
            */
      ";

        $data = DB::select( DB::raw($sql));

        $total_trabajadores = 0;
        $total_aporte = 0;
        $total_bruto = 0;
        $total_neto = 0;
        $total_descuentos = 0;

        if(count($data) > 0){

            $planilla = new PlanillaM("p_planillas");
            $planilla->total_trabajadores = $total_trabajadores;
            $planilla->total_aporte = $total_aporte;
            $planilla->total_bruto = $total_bruto;
            $planilla->total_neto = $total_neto;
            $planilla->fecha_inicial = $fi;
            $planilla->fecha_final = $ff;
            $planilla->total_descuentos = $total_descuentos;
            $planilla->consorcio_id = $consorcio;
            $planilla->estado = 1;
            $planilla->fecha_generada  = date("Y-m-d");
            $planilla->generado_por = Auth::user()->id;
            $planilla->save();


            foreach ($data as $key => $value) {
                
                $total_trabajadores++;
                $total_aporte += $value->aporte_essalud;
                $total_bruto += $value->sueldo_bruto;

                $descuentos = $value->dscto_prestamo+$value->dscto_quinta+$value->dscto_regimen_seguro+$value->dscto_regimen_aporte+$value->dscto_regimen_comision+$value->dscto_regimen_prima;
                $total_descuentos += $descuentos;
                $neto = $value->remuneracion_basica-$descuentos;
                $total_neto += $neto;

                $iDataTmp = (object) [
                    'planilla_id'=>$planilla->id,
                    'persona_id' => $value->persona_id,
                    'contrato_id' => $value->contrato_id,
                    'sueldo_bruto' => $value->sueldo_bruto,
                    'remuneracion_basica' => $value->remuneracion_basica,
                    'ingreso_asig_familiar' => $value->ingreso_asig_familiar,
                    'dias_laborados' => $value->dias_laborados,
                    'ingreso_dias_laborados' => $value->ingreso_dias_laborados,
                    'vacaciones' => $value->vacaciones,
                    'ingreso_vacaciones' => $value->ingreso_vacaciones,
                    'horas_extras' => $value->horas_extras,
                    'ingreso_horas_extras' => $value->ingreso_horas_extras,
                    'bonos' => $value->bonos,
                    'bonos_detalle' => $value->bonos_detalle,
                    'dias_no_laborados' => $value->dias_no_laborados,
                    'dscto_dias_no_laborados' => $value->dscto_dias_no_laborados,
                    'total_tardanza' => $value->total_tardanza,
                    'dscto_total_tardanza' => $value->dscto_total_tardanza,
                    'dscto_permisos' => $value->dscto_permisos,
                    'dscto_prestamo' => $value->dscto_prestamo,
                    'acu_dscto_quinta' => $value->acu_dscto_quinta,
                    'acu_sueldo_neto' => $value->acu_sueldo_neto,
                    'dscto_quinta' => $value->dscto_quinta,
                    'dscto_regimen_seguro' => $value->dscto_regimen_seguro,
                    'dscto_regimen_aporte' => $value->dscto_regimen_aporte,
                    'dscto_regimen_comision' => $value->dscto_regimen_comision,
                    'dscto_regimen_prima' => $value->dscto_regimen_prima,
                    'aporte_essalud' => $value->aporte_essalud,
                    'estado' => 1,
                ];

                PlanillaM::crearDetallePlanilla($iDataTmp);

            }

                $planilla->total_trabajadores = $total_trabajadores;
                $planilla->total_aporte = $total_aporte;
                $planilla->total_bruto = $total_bruto;
                $planilla->total_neto = $total_neto;
                $planilla->total_descuentos = $total_descuentos;
                $planilla->save();

                $actConsorcio = Consorcio::find($consorcio);
                $actConsorcio->fecha_ultima_planilla = date("Y-m-d");
                $actConsorcio->save();

        }else{
            return false;
        }
        
      return true;

    }




    private static function ultimaPlanilla($consorcio,$fecha){

      $x = DB::select( DB::raw("SELECT fecha_ultima_planilla,dia_ciclo FROM planilla.m_consorcios WHERE estado = 1 AND id = '$consorcio';"));
      
      if(count($x)>0 && $x[0]->fecha_ultima_planilla != null){
        return $x[0];
      }else{
        return $fecha;
      }
    } 

    private static function loadConfig(){

      $x = DB::select( DB::raw("SELECT * FROM planilla.a_config WHERE estado = 1"));
      return $x[0];
    } 

    public static function listPlanillas($filters){

      if(isset($filters['consorcio']) && isset($filters['fini']) && isset($filters['ffin']))
        $auxQry=" AND c.id = '".$filters['consorcio']."' AND p.fecha_generada BETWEEN DATE('".$filters['fini']."') AND DATE('".$filters['ffin']."')";
      else
        $auxQry ="";


      $qry = "SELECT p.*,c.consorcio,c.ruc FROM p_planillas as p INNER JOIN m_consorcios as c ON c.id = p.consorcio_id WHERE p.estado=1 $auxQry";

      //echo $qry;

        return DB::select(DB::raw($qry));
    }

    public static function listConsorcios(){
        return DB::select(DB::raw("SELECT `id`, `consorcio`, `consorcio_apocope`, `logo`, `ruc`, `fecha_ultima_planilla` FROM m_consorcios as p WHERE p.estado=1"));
    }

    public static function planillaDetalle($idPlanilla){
        return array(
          'data'=>DB::select(DB::raw("SELECT * FROM p_planillas WHERE id=$idPlanilla AND estado = 1")),
          'detalle'=>DB::select(DB::raw("SELECT pd.*, concat(mp.nombre,' ', mp.paterno,' ', mp.materno) as persona FROM p_planillas_detalles as pd INNER JOIN m_personas as mp WHERE planilla_id=$idPlanilla AND mp.estado = 1 AND pd.estado = 1 AND mp.id = pd.persona_id")),
        );
    }

    private static function crearDetallePlanilla($data){

        $ppd = new PlanillaM("p_planillas_detalles");
        foreach ($data as $key => $value) {
            $ppd->$key = $data->$key;
        }
        $ppd->save();
    }

    private static function diasTrabajados(){

    }


}
