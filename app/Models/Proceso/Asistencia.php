<?php

namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model{
    
    protected   $table = 'p_asistencias';
    
        public static function runLoadAsistencia($r){
        
        $sql= Asistencia::select('p_asistencias.id','p_asistencias.fecha_ingreso','p_asistencias.hora_ingreso','p_asistencias.fecha_salida','p_asistencias.hora_salida','pea.id as evento_asistencia_id')
            ->leftjoin("p_eventos_asistencias as pea","pea.asistencia_id","=","p_asistencias.id")
            ->where('p_asistencias.asistencia_estado_fin','!=',2)
            ->where(
                function($query) use ($r){
                    if( $r->has("fecha") ){
                        $fecha=trim($r->fecha);
                        if( $fecha !='' ){
                            $query->where('p_asistencias.fecha_ingreso','=',$fecha);
                        }
                    }
                    if( $r->has("persona_contrato_id") ){
                        $persona_contrato_id=trim($r->persona_contrato_id);
                        if( $persona_contrato_id !='' ){
                            $query->where('p_asistencias.persona_contrato_id','=',$persona_contrato_id);
                        }
                    }
                    if( $r->has("estado") ){
                        $estado=trim($r->estado);
                        if( $estado !='' ){
                            $query->where('p_asistencias.estado','=',$estado);
                        }
                    }
                    if( $r->has("fecha_ingreso") ){
                        $fecha_ingreso=trim($r->fecha_ingreso);
                        if( $fecha_ingreso !='' ){
                            $query->where('p_asistencias.fecha_ingreso','like','%'.$fecha_ingreso.'%');
                        }
                    }
                    if( $r->has("hora_ingreso") ){
                        $hora_ingreso=trim($r->hora_ingreso);
                        if( $hora_ingreso !='' ){
                            $query->where('p_asistencias.hora_ingreso','like','%'.$hora_ingreso.'%');
                        }
                    }
                    if( $r->has("fecha_salida") ){
                        $fecha_salida=trim($r->fecha_salida);
                        if( $fecha_salida !='' ){
                            $query->where('p_asistencias.fecha_salida','like','%'.$fecha_salida.'%');
                        }
                    }
                    if( $r->has("hora_salida") ){
                        $hora_salida=trim($r->hora_salida);
                        if( $hora_salida !='' ){
                            $query->where('p_asistencias.hora_salida','like','%'.$hora_salida.'%');
                        }
                    }
                }
            );
        $result = $sql->orderBy('p_asistencias.id','asc')
                      ->groupBy('p_asistencias.id','p_asistencias.fecha_ingreso','p_asistencias.hora_ingreso','p_asistencias.fecha_salida','p_asistencias.hora_salida','pea.id')->paginate(10);
        return $result;
    }
    
}
