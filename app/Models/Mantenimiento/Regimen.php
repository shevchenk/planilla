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
        $regimen->tipo_regimen = trim( $r->tipo_regimen_id );
        $regimen->regimen = trim( $r->regimen );
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
        $regimen->tipo_regimen = trim( $r->tipo_regimen_id );
        $regimen->regimen = trim( $r->regimen );
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
                        $regimen=trim($r->regimen);
                        if( $regimen !='' ){
                           $query->where('m_regimenes.regimen','=',$regimen);
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
    
    public static function ListRegimen($r){
        $sql=Regimen::select('id','regimen','estado')
            ->where('estado','=','1');
        $result = $sql->orderBy('regimen','asc')->get();
        return $result;
    }
    

}
