<?php

namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Proceso\PersonaContratoHistorico;
use DB;

class PersonaContrato extends Model
{
    protected   $table = 'p_personas_contratos';

    public static function runEditStatus($r)
    {
        $personacontrato = PersonaContrato::find($r->id);
        $personacontrato->estado = trim( $r->estadof );
        $personacontrato->persona_id_updated_at=Auth::user()->id;
        $personacontrato->save();
    }

    public static function runNew($r)
    {
        $buscar= PersonaContrato::where('persona_id','=',$r->persona_id)->first();
        if($buscar){
            PersonaContrato::runEdit($r);
        }else{
        $personacontrato = new PersonaContrato;
        $personacontrato->persona_id = trim( $r->persona_id );
        $personacontrato->sede_id = trim( $r->sede_id );
        $personacontrato->consorcio_id =trim( $r->consorcio_id );
        $personacontrato->cargo_id = trim( $r->cargo_id );
        $personacontrato->regimen_id = trim( $r->regimen_id );
        $personacontrato->estado_contrato = trim( $r->estado_contrato );
        $personacontrato->tipo_contrato = trim( $r->tipo_contrato );
        $personacontrato->fecha_ini_contrato = trim( $r->fecha_ini_contrato );
        $personacontrato->fecha_fin_contrato = trim( $r->fecha_fin_contrato );
        $personacontrato->sueldo_mensual = trim( $r->sueldo_mensual );
        $personacontrato->sueldo_produccion = trim( $r->sueldo_produccion );
        $personacontrato->asignacion_familiar = trim( $r->asignacion_familiar );
        $personacontrato->estado = 1;
        $personacontrato->persona_id_created_at=Auth::user()->id;
        $personacontrato->save();

            if($personacontrato){
                PersonaContratoHistorico::runNew($r);
            }
        }
    }

    public static function runEdit($r)
    {
        $personacontrato = PersonaContrato::find($r->id);
        $personacontrato->sede_id = trim( $r->sede_id );
        $personacontrato->consorcio_id =trim( $r->consorcio_id );
        $personacontrato->cargo_id = trim( $r->cargo_id );
        $personacontrato->regimen_id = trim( $r->regimen_id );
        $personacontrato->estado_contrato = trim( $r->estado_contrato );
        $personacontrato->tipo_contrato = trim( $r->tipo_contrato );
        $personacontrato->fecha_ini_contrato = trim( $r->fecha_ini_contrato );
        $personacontrato->fecha_fin_contrato = trim( $r->fecha_fin_contrato );
        $personacontrato->sueldo_mensual = trim( $r->sueldo_mensual );
        $personacontrato->sueldo_produccion = trim( $r->sueldo_produccion );
        $personacontrato->asignacion_familiar = trim( $r->asignacion_familiar );
        $personacontrato->estado = 1;
        $personacontrato->persona_id_updated_at=Auth::user()->id;
        $personacontrato->save();
        
        if($personacontrato){
            PersonaContratoHistorico::runNew($r);
        }
    }


    public static function runLoad($r)
    {
        $sql=PersonaContrato::select('ms.sede','mc.consorcio','p_personas_contratos.id','p_personas_contratos.persona_id','p_personas_contratos.sede_id','p_personas_contratos.consorcio_id',
                'p_personas_contratos.cargo_id','p_personas_contratos.regimen_id','p_personas_contratos.estado_contrato','p_personas_contratos.tipo_contrato',
                'p_personas_contratos.fecha_ini_contrato','p_personas_contratos.fecha_fin_contrato','p_personas_contratos.sueldo_mensual'
                ,'p_personas_contratos.sueldo_produccion','p_personas_contratos.asignacion_familiar','p_personas_contratos.estado',
                DB::raw('CASE p_personas_contratos.estado_contrato  WHEN 1 THEN "Vigente" WHEN 2 THEN "Vacaciones" WHEN 3 THEN "Cesante" END AS estado_contrato_nombre'),
                DB::raw('CASE p_personas_contratos.tipo_contrato  WHEN 1 THEN "Producción" WHEN 2 THEN "Regular"  END AS tipo_contrato_nombre'),
                DB::raw('CONCAT_WS(" ",mp.paterno,mp.materno,mp.nombre) as persona'))
            ->join('m_personas AS mp', function($join){
                $join->on('mp.id','=','p_personas_contratos.persona_id');
            })
            ->join('m_sedes AS ms', function($join){
                $join->on('ms.id','=','p_personas_contratos.sede_id');
            })
            ->join('m_consorcios AS mc', function($join){
                $join->on('mc.id','=','p_personas_contratos.consorcio_id');
            })
            ->where( 
                    
                function($query) use ($r){
                    if( $r->has("regimen") ){
                        $personacontrato=trim($r->regimen);
                        if( $personacontrato !='' ){
                           $query->where('p_personas_contratos.regimen','=',$personacontrato);
                        }
                    }
                    if( $r->has("tipo_regimen") ){
                        $tipo_regimen=trim($r->tipo_regimen);
                        if( $tipo_regimen !='' ){
                            $query->where('p_personas_contratos.tipo_regimen','=',$tipo_regimen);
                        }   
                    }
                    if( $r->has("aporte") ){
                        $aporte=trim($r->aporte);
                        if( $aporte !='' ){
                            $query->where('p_personas_contratos.aporte','like','%'.$aporte.'%');
                        }   
                    }
                    if( $r->has("comision") ){
                        $comision=trim($r->comision);
                        if( $comision !='' ){
                            $query->where('p_personas_contratos.comision','like','%'.$comision.'%');
                        }   
                    }
                    if( $r->has("prima") ){
                        $prima=trim($r->prima);
                        if( $prima !='' ){
                            $query->where('p_personas_contratos.prima','like','%'.$prima.'%');
                        }   
                    }
                    if( $r->has("seguro") ){
                        $seguro=trim($r->seguro);
                        if( $seguro !='' ){
                            $query->where('p_personas_contratos.seguro','like','%'.$seguro.'%');
                        }   
                    }
                    if( $r->has("estado") ){
                        $estado=trim($r->estado);
                        if( $estado !='' ){
                            $query->where('p_personas_contratos.estado','=',''.$estado.'');
                        }
                    }
                }
            );
        $result = $sql->orderBy('p_personas_contratos.id','asc')->paginate(10);
        return $result;
    }
    

}
