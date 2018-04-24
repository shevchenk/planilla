<?php

namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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

    public static function runNew($r)
    {

        $evento = new Evento;
        $evento->evento_tipo_id = trim( $r->persona_id );
        $evento->persona_contrato_id = trim( $r->sede_id );
        $evento->evento_descripcion =trim( $r->consorcio_id );
        $evento->fecha_inicio = trim( $r->cargo_id );
        $evento->fecha_fin = trim( $r->regimen_id );
        $evento->hora_inicio = trim( $r->estado_contrato );
        $evento->hora_fin = trim( $r->tipo_contrato );
        $evento->estado = trim( $r->estado );
        $evento->persona_id_created_at=Auth::user()->id;
        $evento->save();

    }

    public static function runLoad($r)
    {
        $sql=Evento::select('p_eventos.id','p_eventos.evento_tipo_id','p_eventos.persona_contrato_id','p_eventos.evento_descripcion',
                'p_eventos.fecha_inicio','p_eventos.fecha_fin','p_eventos.hora_inicio','p_eventos.hora_fin',
                'p_eventos.estado','met.evento_tipo')
            ->join('m_eventos_tipos AS met', function($join){
                $join->on('met.id','=','p_eventos.evento_tipo_id');
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
                    $query->where('p_eventos.estado','=',1);
             
                }
            );
        $result = $sql->orderBy('p_eventos.id','asc')->paginate(10);
        return $result;
    }

}
