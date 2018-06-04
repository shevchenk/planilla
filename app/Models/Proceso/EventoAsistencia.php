<?php

namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;
use DB;
class EventoAsistencia extends Model
{
    protected   $table = 'p_eventos_asistencias';

    public static function runLoadEvento($r){

        $sql= EventoAsistencia::select('pe.id','pe.fecha_inicio','pe.hora_inicio','pe.fecha_fin','pe.hora_fin','pe.evento_descripcion','met.evento_tipo',
        DB::raw("CASE met.aplica_cambio WHEN 0 THEN 'TODO' WHEN 1 THEN 'FECHA INICIO' WHEN 2 THEN 'FECHA FIN' END as aplica_cambio"))
            ->join("p_eventos as pe","pe.id","=","p_eventos_asistencias.evento_id")
            ->join("m_eventos_tipos as met","met.id","=","pe.evento_tipo_id")
            ->where(
                function($query) use ($r){
                    if( $r->has("asistencia_id") ){
                        $asistencia_id=trim($r->asistencia_id);
                        if( $asistencia_id !='' ){
                            $query->where('p_eventos_asistencias.asistencia_id','=',$asistencia_id);
                        }
                    }
                    if( $r->has("fecha_inicio") ){
                        $fecha_inicio=trim($r->fecha_inicio);
                        if( $fecha_inicio !='' ){
                            $query->where('pe.fecha_inicio','=',$fecha_inicio);
                        }
                    }
                    if( $r->has("hora_inicio") ){
                        $hora_inicio=trim($r->hora_inicio);
                        if( $hora_inicio !='' ){
                            $query->where('pe.hora_inicio','=',$hora_inicio);
                        }
                    }
                    if( $r->has("fecha_fin") ){
                        $fecha_fin=trim($r->fecha_fin);
                        if( $fecha_fin !='' ){
                            $query->where('pe.fecha_fin','=',$fecha_fin);
                        }
                    }
                    if( $r->has("hora_fin") ){
                        $hora_fin=trim($r->hora_fin);
                        if( $hora_fin !='' ){
                            $query->where('pe.hora_fin','=',$hora_fin);
                        }
                    }
                    if( $r->has("evento_descripcion") ){
                        $evento_descripcion=trim($r->evento_descripcion);
                        if( $evento_descripcion !='' ){
                            $query->where('pe.evento_descripcion','=',$evento_descripcion);
                        }
                    }
                    if( $r->has("evento_tipo") ){
                        $evento_tipo=trim($r->evento_tipo);
                        if( $evento_tipo !='' ){
                            $query->where('met.evento_tipo','=',$evento_tipo);
                        }
                    }
                    if( $r->has("aplica_cambio") ){
                        $aplica_cambio=trim($r->aplica_cambio);
                        if( $aplica_cambio !='' ){
                            $query->where('met.aplica_cambio','=',$aplica_cambio);
                        }
                    }
                    if( $r->has("estado") ){
                        $estado=trim($r->estado);
                        if( $estado !='' ){
                            $query->where('p_eventos_asistencias.estado','=',$estado);
                        }
                    }
                }
            );
        $result = $sql->orderBy('pe.id','asc')->paginate(10);
        return $result;
    }
}
