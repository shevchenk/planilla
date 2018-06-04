<?php

namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Proceso\AsistenciaMarcacion;
use App\Models\Proceso\AsistenciaHistorico;
use App\Models\Proceso\EventoAsistencia;
use Auth;

class Asistencia extends Model
{
    protected   $table = 'p_asistencias';

    public static function Marcacion( $r )
    {
        $contrato=
        DB::table('p_personas_contratos AS ppc')
        ->join('m_personas AS mp',function($join){
            $join->on('mp.id','=','ppc.persona_id');
        })
        ->select('ppc.id')
        ->where('mp.dni',$r->dni)
        ->first();

        $fechahoy=date("Y-m-d");
        $horahoy=date("H:i:s");
        $diahoy=date("N");
        $return['rst'] = 1;
        $return['tittle'] = 'Gracias!!';
        $return['type'] = 'success';
        $return['msj'] = 'Se registró correctamente';

        if( count($contrato)>0 ){
            $horarioprogramado=
            DB::table('p_horarios_programados AS php')
            ->select('php.id','php.hora_inicio','php.hora_fin','php.horario_amanecida','php.tolerancia')
            ->where('php.persona_contrato_id',$contrato->id)
            ->where('php.dia_id',$diahoy)
            ->where('php.estado',1)
            ->first();

            $asistencia=
            DB::table('p_asistencias AS pa')
            ->select('pa.id','pa.fecha_ingreso','pa.asistencia_estado_fin')
            ->where('pa.persona_contrato_id',$contrato->id)
            ->orderBy('pa.fecha_ingreso','DESC')
            ->first();

            $evento=
            DB::table('p_eventos AS pe')
            ->join('m_eventos_tipos AS met',function($join){
                $join->on('met.id','=','pe.evento_tipo _id');
            })
            ->leftJoin('p_eventos_asistencias AS pea',function($join){
                $join->on('pea.evento_id','=','pe.id')
                ->where('pea.estado',1);
            })
            ->select('pe.id','met.aplica_cambio','pe.fecha_inicio','pe.fecha_fin','pe.hora_inicio','pe.hora_fin')
            ->where('pe.persona_contrato_id',$contrato->id)
            ->where('pe.estado',1)
            ->whereNull('pea.id')
            ->first();

            DB::beginTransaction();
            if( count($asistencia)>0 AND $asistencia->asistencia_estado_fin<2 AND $asistencia->fecha_ingreso==$diahoy AND count($horarioprogramado)>0 ){
                
                $asistencia['fecha_salida']=$fechahoy;
                $asistencia['hora_salida']=$horahoy;

                $asistencia_estado_fin=0;
                if( $horahoy>$horarioprogramado->hora_inicio ){
                    $tolerancia=date("H:i:s",strtotime($horarioprogramado->hora_inicio.' +'.$horarioprogramado->tolerancia.' minutes') );
                    $total_hora_tardanza=date("H:i:s",strtotime($horahoy." -".strtotime($horarioprogramado->hora_inicio)." seconds") );
                    if( $tolerancia>=$horahoy ){
                        $asistencia_estado_ini=1;
                    }
                    else{
                        $asistencia_estado_ini=2;
                    }
                }

                $asistencia['asistencia_estado_fin']=$asistencia_estado_fin;
                $asistencia['persona_id_created_at']=Auth::user()->id;
                $asistencia->save();
            }
            elseif( count($asistencia)==0 AND count($horarioprogramado)>0 AND count($evento)>0 AND $evento->aplica_cambio<2){
                $asistencia= new Asistencia;
                $asistencia['persona_contrato_id']=$contrato->id;
                $asistencia['horario_programado_id']=$horarioprogramado->id;

                $total_hora_tardanza=0;
                $asistencia_estado_ini=0;
                if( $evento->aplica_cambio==0 ){
                    $asistencia_estado_fin=0;
                    $asistencia['fecha_ingreso']=$evento->fecha_inicio;
                    $asistencia['hora_ingreso']=$evento->hora_inicio;
                    $asistencia['fecha_salida']=$evento->fecha_fin;
                    $asistencia['hora_salida']=$evento->hora_fin;
                    $asistencia['asistencia_estado_fin']=$asistencia_estado_fin;
                }
                else{
                    $asistencia['fecha_ingreso']=$evento->fecha_inicio;
                    $asistencia['hora_ingreso']=$evento->hora_inicio;

                    $evento['ini_marcado']=$fechahoy." ".$horahoy;
                    $evento['persona_id_updated_at']=Auth::user()->id;
                    $evento->save();
                }

                $asistencia['total_hora_tardanza']=$total_hora_tardanza;
                $asistencia['asistencia_estado_ini']=$asistencia_estado_ini;
                $asistencia['persona_id_created_at']=Auth::user()->id;
                $asistencia->save();

                $eventoasistencia= new EventoAsistencia;
                $eventoasistencia['asistencia_id']=$asistencia->id;
                $eventoasistencia['evento_id']=$evento->id;
                $eventoasistencia['persona_id_created_at']=Auth::user()->id;
                $eventoasistencia->save();
            }
            elseif( count($asistencia)==0 AND count($horarioprogramado)==0 AND count($evento)>0 AND $evento->aplica_cambio<2){
                $asistencia= new Asistencia;
                $asistencia['persona_contrato_id']=$contrato->id;
                $asistencia['fecha_ingreso']=$fechahoy;
                $asistencia['hora_ingreso']=$horahoy;
                $total_hora_tardanza=0;
                $asistencia_estado_ini=3; // 3 significa cancelado
                $asistencia_estado_fin=3; // 3 significa cancelado
                $asistencia['total_hora_tardanza']=$total_hora_tardanza;
                $asistencia['asistencia_estado_ini']=$asistencia_estado_ini;
                $asistencia['asistencia_estado_fin']=$asistencia_estado_fin;
                $asistencia['persona_id_created_at']=Auth::user()->id;
                $asistencia->save();

                $eventoasistencia= new EventoAsistencia;
                $eventoasistencia['asistencia_id']=$asistencia->id;
                $eventoasistencia['evento_id']=$evento->id;
                $eventoasistencia['persona_id_created_at']=Auth::user()->id;
                $eventoasistencia->save();
                $return['rst']='2';
                $return['tittle'] = 'Información!!';
                $return['type'] = 'warning';
                $return['msj']='Ud no cuenta con el horario programado para el día de hoy';
            }
            elseif( count($asistencia)==0 AND count($horarioprogramado)>0 ){
                $asistencia= new Asistencia;
                $asistencia['persona_contrato_id']=$contrato->id;
                $asistencia['horario_programado_id']=$horarioprogramado->id;
                $asistencia['fecha_ingreso']=$fechahoy;
                $asistencia['hora_ingreso']=$horahoy;

                $total_hora_tardanza=0;
                $asistencia_estado_ini=0;
                if( $horahoy>$horarioprogramado->hora_inicio ){
                    $tolerancia=date("H:i:s",strtotime($horarioprogramado->hora_inicio.' +'.$horarioprogramado->tolerancia.' minutes') );
                    $total_hora_tardanza=date("H:i:s",strtotime($horahoy." -".strtotime($horarioprogramado->hora_inicio)." seconds") );
                    if( $tolerancia>=$horahoy ){
                        $asistencia_estado_ini=1;
                    }
                    else{
                        $asistencia_estado_ini=2;
                    }
                }

                $asistencia['total_hora_tardanza']=$total_hora_tardanza;
                $asistencia['asistencia_estado_ini']=$asistencia_estado_ini;
                $asistencia['persona_id_created_at']=Auth::user()->id;
                $asistencia->save();
            }
            elseif( count($asistencia)==0 AND count($horarioprogramado)==0 ){
                $asistencia= new Asistencia;
                $asistencia['persona_contrato_id']=$contrato->id;
                $asistencia['fecha_ingreso']=$fechahoy;
                $asistencia['hora_ingreso']=$horahoy;
                $total_hora_tardanza=0;
                $asistencia_estado_ini=3; // 3 significa cancelado
                $asistencia_estado_fin=3; // 3 significa cancelado
                $asistencia['total_hora_tardanza']=$total_hora_tardanza;
                $asistencia['asistencia_estado_ini']=$asistencia_estado_ini;
                $asistencia['asistencia_estado_fin']=$asistencia_estado_fin;
                $asistencia['persona_id_created_at']=Auth::user()->id;
                $asistencia->save();
                $return['rst']='2';
                $return['tittle'] = 'Información!!';
                $return['type'] = 'warning';
                $return['msj']='Ud no cuenta con el horario programado para el día de hoy';
            }
            ////////////////////////////////////////////////////////////////////
            $asistenciahistorico= new AsistenciaHistorico;
            $asistenciahistorico['asistencia_id']=$asistencia->id;
            $asistenciahistorico['persona_contrato_id']=$asistencia->persona_contrato_id;
            $asistenciahistorico['horario_programado_id']=$asistencia->horario_programado_id;
            $asistenciahistorico['fecha_ingreso']=$asistencia->fecha_ingreso;
            $asistenciahistorico['fecha_salida']=$asistencia->fecha_salida;
            $asistenciahistorico['hora_ingreso']=$asistencia->hora_ingreso;
            $asistenciahistorico['hora_salida']=$asistencia->hora_salida;
            $asistenciahistorico['total_hora_tardanza']=$asistencia->total_hora_tardanza;
            $asistenciahistorico['total_hora']=$asistencia->total_hora;
            $asistenciahistorico['asistencia_estado_ini']=$asistencia->asistencia_estado_ini;
            $asistenciahistorico['asistencia_estado_fin']=$asistencia->asistencia_estado_fin;
            $asistenciahistorico['persona_id_created_at']=Auth::user()->id;
            $asistenciahistorico->save();
            ////////////////////////////////////////////////////////////////////
            $asistenciamarcacion= new AsistenciaMarcacion;
            $asistenciamarcacion['asistencia_id']=$asistencia->id;
            $asistenciamarcacion['persona_contrato_id']=$contrato->id;
            $asistenciamarcacion['fecha_marcada']=$fechahoy;
            $asistenciamarcacion['hora_marcada']=$horahoy;
            $asistenciamarcacion['persona_id_created_at']=Auth::user()->id;
            $asistenciamarcacion->save();
            DB::commit();
        }
        else{
            $return['rst']='2';
            $return['tittle'] = 'Información!!';
            $return['type'] = 'warning';
            $return['msj']='Ud no existe en los registros verifique su dni';
        }

        return $return;
    }
}
