<?php

namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class PersonaContratoHistorico extends Model
{
    protected   $table = 'p_personas_contratos_historicos';

    public static function runNew($r)
    {
        DB::beginTransaction();
        PersonaContratoHistorico::where('persona_id', '=', $r->persona_id)
                        ->update(
                            array(
                                'ultimo_registro' => 0,
                                'persona_id_updated_at' => Auth::user()->id
                            ));
        
        $personacontrato = new PersonaContratoHistorico;
        $personacontrato->persona_id = trim( $r->persona_id );
        $personacontrato->sede_id = trim( $r->sede_id );
        $personacontrato->consorcio_id =trim( $r->consorcio_id );
        $personacontrato->cargo_id = trim( $r->cargo_id );
        $personacontrato->regimen_id = trim( $r->regimen_id );
        $personacontrato->estado_contrato = trim( $r->estado_contrato );
        $personacontrato->tipo_contrato = trim( $r->tipo_contrato );
        $personacontrato->modalidad_contrato = trim( $r->modalidad_contrato );
        $personacontrato->fecha_ini_contrato = trim( $r->fecha_ini_contrato );
        $personacontrato->fecha_fin_contrato = trim( $r->fecha_fin_contrato );
        $personacontrato->sueldo_mensual = trim( $r->sueldo_mensual );
        $personacontrato->monto_adicional = trim( $r->monto_adicional );
        $personacontrato->asignacion_familiar = trim( $r->asignacion_familiar );
        $personacontrato->estado = trim( $r->estado );
        $personacontrato->persona_id_created_at=Auth::user()->id;
        $personacontrato->save();
        DB::commit();
    }

    public static function runLoad($r)
    {
        $sql=PersonaContratoHistorico::select('m_regimenes.id','m_regimenes.regimen','m_regimenes.tipo_regimen','m_regimenes.aporte',
                'm_regimenes.comision','m_regimenes.prima','m_regimenes.seguro','m_regimenes.estado',
                DB::raw('CASE m_regimenes.tipo_regimen  WHEN 1 THEN "Flujo" WHEN 2 THEN "Mixto" END AS tipo_regimen_nombre'))
            ->where( 
                    
                function($query) use ($r){
                    if( $r->has("regimen") ){
                        $personacontrato=trim($r->regimen);
                        if( $personacontrato !='' ){
                           $query->where('m_regimenes.regimen','=',$personacontrato);
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
    

}
