<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class Cargo extends Model
{
    protected   $table = 'm_cargos';
    
    public static function runEditStatus($r)
    {
        $regimen = Cargo::find($r->id);
        $regimen->estado = trim( $r->estadof );
        $regimen->persona_id_updated_at=Auth::user()->id;
        $regimen->save();
    }

    public static function runNew($r)
    {
        $regimen = new Cargo;
        $regimen->cargo = trim( $r->cargo );
        $regimen->sueldo_mensual_base =trim( $r->sueldo_mensual_base );
        $regimen->monto_adicional_base = trim( $r->monto_adicional_base );
        $regimen->estado = trim( $r->estado );
        $regimen->persona_id_created_at=Auth::user()->id;
        $regimen->save();
    }

    public static function runEdit($r)
    {
        $regimen = Cargo::find($r->id);
        $regimen->cargo = trim( $r->cargo );
        $regimen->sueldo_mensual_base =trim( $r->sueldo_mensual_base );
        $regimen->monto_adicional_base = trim( $r->monto_adicional_base );
        $regimen->estado = trim( $r->estado );
        $regimen->persona_id_updated_at=Auth::user()->id;
        $regimen->save();
    }


    public static function runLoad($r)
    {
        $sql=Cargo::select('m_cargos.id','m_cargos.cargo','m_cargos.sueldo_mensual_base','m_cargos.monto_adicional_base',
                'm_cargos.estado')
            ->where( 
                    
                function($query) use ($r){
                    if( $r->has("cargo") ){
                        $cargo=trim($r->cargo);
                        if( $cargo !='' ){
                           $query->where('m_cargos.cargo','like','%'.$cargo.'%');
                        }
                    }
                    if( $r->has("sueldo_mensual_base") ){
                        $sueldo_mensual_base=trim($r->sueldo_mensual_base);
                        if( $sueldo_mensual_base !='' ){
                            $query->where('m_cargos.sueldo_mensual_base','like','%'.$sueldo_mensual_base.'%');
                        }   
                    }
                    if( $r->has("monto_adicional_base") ){
                        $monto_adicional_base=trim($r->monto_adicional_base);
                        if( $monto_adicional_base !='' ){
                            $query->where('m_cargos.monto_adicional_base','like','%'.$monto_adicional_base.'%');
                        }   
                    }                    
                    if( $r->has("estado") ){
                        $estado=trim($r->estado);
                        if( $estado !='' ){
                            $query->where('m_cargos.estado','=',''.$estado.'');
                        }
                    }
                }
            );
        $result = $sql->orderBy('m_cargos.id','asc')->paginate(10);
        return $result;
    }

    // --
    public static function ListCargo($r){
        $sql=Cargo::select('id','cargo','estado')
            ->where('estado','=','1');
        $result = $sql->orderBy('cargo','asc')->get();
        return $result;
    }
    
    public static function SueldoCargo($r){
        $sql=Cargo::select('id','sueldo_mensual_base','sueldo_produccion_base')
            ->where('estado','=','1')
            ->where('id','=',$r->cargo_id);
        $result = $sql->orderBy('cargo','asc')->get();
        return $result;
    }
    

}
