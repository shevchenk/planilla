<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class Regimen extends Model
{
    protected   $table = 'm_regimenes';

    public static function runEditStatus($r)
    {
        $regimen = Regimen::find($r->id);
        $regimen->estado = trim( $r->estadof );
        $regimen->persona_id_updated_at=Auth::user()->id;
        $regimen->save();
    }

    public static function runNew($r)
    {
        $regimen = new Regimen;
        $regimen->tipo_regimen_id = trim( $r->tipo_respuesta_id );
        $regimen->regimen = trim( $r->respuesta );
        $regimen->aporte =trim( $r->aporte );
        $regimen->comision = trim( $r->comision );
        $regimen->prima = trim( $r->prima );
        $regimen->seguro = trim( $r->seguro );
        $regimen->estado = trim( $r->estado );
        $regimen->persona_id_created_at=Auth::user()->id;
        $regimen->save();
    }

    public static function runEdit($r)
    {
        $regimen = Regimen::find($r->id);
        $regimen->tipo_regimen_id = trim( $r->tipo_respuesta_id );
        $regimen->regimen = trim( $r->respuesta );
        $regimen->aporte =trim( $r->aporte );
        $regimen->comision = trim( $r->comision );
        $regimen->prima = trim( $r->prima );
        $regimen->seguro = trim( $r->seguro );
        $regimen->estado = trim( $r->estado );
        $regimen->persona_id_updated_at=Auth::user()->id;
        $regimen->save();
    }


    public static function runLoad($r)
    {
        $sql=Regimen::select('m_regimenes.id','m_regimenes.regimen','m_regimenes.tipo_regimen','m_regimenes.aporte',
                'm_regimenes.comision','m_regimenes.prima','m_regimenes.seguro','m_regimenes.estado',
                DB::raw('CASE m_regimenes.tipo_regimen  WHEN 1 THEN "Flujo" WHEN 2 THEN "Mixto" END AS tipo_regimen_nombre'))
            ->where( 
                    
                function($query) use ($r){
                    if( $r->has("regimen") ){
                        $pregunta_id=trim($r->pregunta_id);
                        if( $pregunta_id !='' ){
                           $query->where('m_regimenes.pregunta_id','=',$pregunta_id);
                        }
                    }
                    if( $r->has("tipo_regimen") ){
                        $pregunta=trim($r->pregunta);
                        if( $pregunta !='' ){
                            $query->where('vp.pregunta','like','%'.$pregunta.'%');
                        }   
                    }
                    if( $r->has("aporte") ){
                        $alternativa_correcta=trim($r->alternativa_correcta);
                        if( $alternativa_correcta !='' ){
                            $query->where('m_regimenes.correcto','=',$r->alternativa_correcta);
                        }   
                    }
                    if( $r->has("comision") ){
                        $respuesta=trim($r->respuesta);
                        if( $respuesta !='' ){
                            $query->where('m_regimenes.respuesta','like','%'.$respuesta.'%');
                        }   
                    }
                    if( $r->has("puntaje") ){
                        $puntaje=trim($r->puntaje);
                        if( $puntaje !='' ){
                            $query->where('m_regimenes.puntaje','like','%'.$puntaje.'%');
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
