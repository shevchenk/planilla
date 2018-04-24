<?php

namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class AsistenciaHistorico extends Model
{
    protected   $table = 'p_asistencias_historicos';

    public static function runNew($r)
    {
        DB::beginTransaction();
//        AsistenciaHistorico::where('persona_id', '=', $r->persona_id)
//                        ->update(
//                            array(
//                                'ultimo_registro' => 0,
//                                'persona_id_updated_at' => Auth::user()->id
//                            ));
        
        $asistencia = new AsistenciaHistorico;
        $asistencia->asistencia_id = trim( $r->id );
        $asistencia->persona_contrato_id = trim( $r->persona_contrato_id );
        $asistencia->horario_programado_id =trim( $r->horario_programado_id );
        $asistencia->fecha_ingreso = trim( $r->fecha_ingreso );
        $asistencia->fecha_salida = trim( $r->fecha_salida );
        $asistencia->hora_ingreso = trim( $r->hora_ingreso );
        $asistencia->hora_salida = trim( $r->hora_salida );
        $asistencia->total_hora_tardanza = trim( $r->total_hora_tardanza );
        $asistencia->total_hora = trim( $r->total_hora );
        $asistencia->asistencia_estado_ini = trim( $r->asistencia_estado_ini );
        $asistencia->asistencia_estado_fin = trim( $r->asistencia_estado_fin );
        $asistencia->estado = trim( $r->estado );
        $asistencia->persona_id_created_at=Auth::user()->id;
        $asistencia->save();
        DB::commit();
    }

    public static function runLoad($r)
    {
        $sql=AsistenciaHistorico::select('m_regimenes.id','m_regimenes.regimen','m_regimenes.tipo_regimen','m_regimenes.aporte',
                'm_regimenes.comision','m_regimenes.prima','m_regimenes.seguro','m_regimenes.estado',
                DB::raw('CASE m_regimenes.tipo_regimen  WHEN 1 THEN "Flujo" WHEN 2 THEN "Mixto" END AS tipo_regimen_nombre'))
            ->where( 
                    
                function($query) use ($r){
                    if( $r->has("regimen") ){
                        $asistencia=trim($r->regimen);
                        if( $asistencia !='' ){
                           $query->where('m_regimenes.regimen','=',$asistencia);
                        }
                    }
                    if( $r->has("tipo_regimen") ){
                        $tipo_regimen=trim($r->tipo_regimen);
                        if( $tipo_regimen !='' ){
                            $query->where('m_regimenes.tipo_regimen','=',$tipo_regimen);
                        }   
                    }
                    if( $r->has("aporte") ){
                        $aporte=trim($r->aporte);
                        if( $aporte !='' ){
                            $query->where('m_regimenes.aporte','like','%'.$aporte.'%');
                        }   
                    }
                    if( $r->has("comision") ){
                        $comision=trim($r->comision);
                        if( $comision !='' ){
                            $query->where('m_regimenes.comision','like','%'.$comision.'%');
                        }   
                    }
                    if( $r->has("prima") ){
                        $prima=trim($r->prima);
                        if( $prima !='' ){
                            $query->where('m_regimenes.prima','like','%'.$prima.'%');
                        }   
                    }
                    if( $r->has("seguro") ){
                        $seguro=trim($r->seguro);
                        if( $seguro !='' ){
                            $query->where('m_regimenes.seguro','like','%'.$seguro.'%');
                        }   
                    }
                    if( $r->has("estado") ){
                        $estado=trim($r->estado);
                        if( $estado !='' ){
                            $query->where('m_regimenes.estado','=',''.$estado.'');
                        }
                    }
                }
            );
        $result = $sql->orderBy('m_regimenes.id','asc')->paginate(10);
        return $result;
    }
    

}
