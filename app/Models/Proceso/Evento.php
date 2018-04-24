<?php

namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Mantenimiento\TipoEvento;
use DB;

class Evento extends Model
{
    protected   $table = 'p_eventos';

    public static function runEditStatus($r)
    {
        $evento = Evento::find($r->id);
        $evento->estado = trim( $r->estadof );
        $evento->persona_id_updated_at=Auth::user()->id;
        $evento->save();
        
    }
    
        public static function runEditStatusMaster($r)
    {
        DB::beginTransaction();
        $evento = Evento::find($r->id);
        $evento->estado = trim( $r->estadof );
        $evento->persona_id_updated_at=Auth::user()->id;
        $evento->save();
        
        $tipoevento= TipoEvento::find($evento->evento_tipo_id);
        
        if($tipoevento->aplica_cambio==0){
            $eveasi= EventoAsistencia::where('evento_id','=',$evento->id)
                    ->get();
            foreach ($eveasi as $r){
                $eveasi= EventoAsistencia::find($r->id);
                $eveasi->estado=0;
                $eveasi->persona_id_updated_at=Auth::user()->id;
                $eveasi->save();
                
                $asistencia= Asistencia::find($eveasi->asistencia_id);
                $asistencia->estado=0;
                $asistencia->persona_id_updated_at=Auth::user()->id;
                $asistencia->save();
                
                if($asistencia){
                    AsistenciaHistorico::runNew($asistencia);
                }
            }
                
        }else if($tipoevento->aplica_cambio==1){
            
        }
        DB::commit();
        
    }

    public static function runNew($r)
    {

        $evento = new Evento;
        $evento->evento_tipo_id = trim( $r->evento_tipo_id );
        $evento->persona_contrato_id = trim( $r->persona_contrato_id );
        $evento->evento_descripcion =trim( $r->evento_descripcion );
        $evento->fecha_inicio = trim( $r->fecha_inicio );
        $evento->fecha_fin = trim( $r->fecha_fin );
        $evento->hora_inicio = trim( $r->hora_inicio );
        $evento->hora_fin = trim( $r->hora_fin );
        $evento->estado = trim( $r->estado );
        $evento->persona_id_created_at=Auth::user()->id;
        $evento->save();

    }

    public static function runLoad($r)
    {
        $sql=Evento::select('p_eventos.id','p_eventos.evento_tipo_id','p_eventos.persona_contrato_id','p_eventos.evento_descripcion',
                'p_eventos.fecha_inicio','p_eventos.fecha_fin','p_eventos.hora_inicio','p_eventos.hora_fin','pea.id as evento_asistencia_id',
                'p_eventos.estado','met.evento_tipo')
            ->join('m_eventos_tipos AS met', function($join){
                $join->on('met.id','=','p_eventos.evento_tipo_id');
            })
            ->leftjoin('p_eventos_asistencias AS pea', function($join){
                $join->on('pea.evento_id','=','p_eventos.id');
            })
            ->where("p_eventos.persona_contrato_id","=",$r->persona_contrato_id)
            ->where( 
                    
                function($query) use ($r){
                    if( $r->has("evento_tipo") ){
                        $evento_tipo=trim($r->evento_tipo);
                        if( $evento_tipo !='' ){
                           $query->where('met.evento_tipo',"like", "%".$evento_tipo."%");
                        }
                    }
                    if( $r->has("evento_descripcion") ){
                        $evento_descripcion=trim($r->evento_descripcion);
                        if( $evento_descripcion !='' ){
                            $query->where('p_eventos.evento_descripcion',"like","%".$evento_descripcion."%");
                        }   
                    }
                    if( $r->has("persona_contrato_id") ){
                        $persona_contrato_id=trim($r->persona_contrato_id);
                        if( $persona_contrato_id !='' ){
                            $query->where('p_eventos.persona_contrato_id',"=",$persona_contrato_id);
                        }   
                    }
                    if( $r->has("fecha_inicio") ){
                        $fecha_inicio=trim($r->fecha_inicio);
                        if( $fecha_inicio !='' ){
                            $query->where('p_eventos.fecha_inicio',"like","%".$fecha_inicio."%");
                        }   
                    }
                    if( $r->has("fecha_fin") ){
                        $fecha_fin=trim($r->fecha_fin);
                        if( $fecha_fin !='' ){
                            $query->where('p_eventos.fecha_fin',"like","%".$fecha_fin."%");
                        }   
                    }
                    $query->where('p_eventos.estado','=',1);
             
                }
            );
        $result = $sql->orderBy('p_eventos.id','asc')->paginate(10);
        return $result;
    }

}
