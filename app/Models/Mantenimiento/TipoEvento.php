<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class TipoEvento extends Model
{
    protected   $table = 'm_eventos_tipos';

    public static function runEditStatus($r)
    {
        $tipoevento = TipoEvento::find($r->id);
        $tipoevento->estado = trim( $r->estadof );
        $tipoevento->persona_id_updated_at=Auth::user()->id;
        $tipoevento->save();
    }

    public static function runNew($r)
    {
        $tipoevento = new TipoEvento;
        $tipoevento->evento_tipo = trim( $r->evento_tipo );
        $tipoevento->aplica_dscto = trim( $r->aplica_dscto );
        $tipoevento->estado = trim( $r->estado );
        $tipoevento->persona_id_created_at=Auth::user()->id;
        $tipoevento->save();
    }

    public static function runEdit($r)
    {
        $tipoevento = TipoEvento::find($r->id);
        $tipoevento->evento_tipo = trim( $r->evento_tipo );
        $tipoevento->aplica_dscto = trim( $r->aplica_dscto );
        $tipoevento->estado = trim( $r->estado );
        $tipoevento->persona_id_updated_at=Auth::user()->id;
        $tipoevento->save();
    }


    public static function runLoad($r)
    {
        $sql=TipoEvento::select('m_eventos_tipos.id',
                                'm_eventos_tipos.evento_tipo',
                                'm_eventos_tipos.aplica_dscto', 
                                'm_eventos_tipos.estado',
                                DB::raw('CASE m_eventos_tipos.aplica_dscto  WHEN 1 THEN "SI" WHEN 0 THEN "NO" END AS descuento'))
                            ->where( 
                                    
                                function($query) use ($r){
                                    if( $r->has("evento_tipo") ){
                                        $evento_tipo=trim($r->evento_tipo);
                                        if( $evento_tipo !='' ){
                                           $query->where('m_eventos_tipos.evento_tipo','=',$evento_tipo);
                                        }
                                    }
                                    if( $r->has("aplica_dscto") ){
                                        $aplica_dscto=trim($r->aplica_dscto);
                                        if( $aplica_dscto !='' ){
                                            $query->where('m_eventos_tipos.aplica_dscto','=',$aplica_dscto);
                                        }   
                                    }                    
                                    if( $r->has("estado") ){
                                        $estado=trim($r->estado);
                                        if( $estado !='' ){
                                            $query->where('m_eventos_tipos.estado','=',''.$estado.'');
                                        }
                                    }
                                }
                            );
        $result = $sql->orderBy('m_eventos_tipos.id','asc')->paginate(10);
        return $result;
    }
    

}
