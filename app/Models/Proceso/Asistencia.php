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
                }
            );
        $result = $sql->orderBy('p_asistencias.id','asc')
                      ->groupBy('p_asistencias.id','p_asistencias.fecha_ingreso','p_asistencias.hora_ingreso','p_asistencias.fecha_salida','p_asistencias.hora_salida','pea.id')->paginate(10);
        return $result;
    }
    
}
