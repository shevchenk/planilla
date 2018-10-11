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
        
        if($personacontrato){
            PersonaContratoHistorico::runNew($personacontrato);
        }
    }

    public static function runNew($r)
    {

        $buscar= PersonaContrato::where('persona_id','=',$r->persona_id)->first();
        if($buscar){
            PersonaContrato::runEdit($r);
        }else{


        $conceptos = array();
        if(is_array($r->nombre_extra))foreach ($r->nombre_extra as $index => $nombre) {
            $conceptos[]=array('n'=>$nombre,'m'=>$r->monto_extra[$index]);
        }


        $personacontrato = new PersonaContrato;
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
        $personacontrato->estado = 1;
        $personacontrato->conceptos_adicionales = json_encode($conceptos);
        $personacontrato->persona_id_created_at=Auth::user()->id;
        $personacontrato->save();

            if($personacontrato){
                PersonaContratoHistorico::runNew($r);
            }
        }
    }

    public static function runEdit($r)
    {
        

        $conceptos = array();
        if(is_array($r->nombre_extra))foreach ($r->nombre_extra as $index => $nombre) {
            $conceptos[]=array('n'=>$nombre,'m'=>$r->monto_extra[$index]);
        }

        $personacontrato = PersonaContrato::where('persona_id','=',$r->persona_id)->first();
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
        $personacontrato->estado = 1;
        $personacontrato->conceptos_adicionales = json_encode($conceptos);
        $personacontrato->persona_id_updated_at=Auth::user()->id;
        $personacontrato->save();
        
        if($personacontrato){
            PersonaContratoHistorico::runNew($r);
        }
    }


    public static function runLoad($r){
        
        $sql=PersonaContrato::select('ms.sede','mc.consorcio','p_personas_contratos.id','p_personas_contratos.persona_id','p_personas_contratos.sede_id','p_personas_contratos.consorcio_id','p_personas_contratos.conceptos_adicionales',
                'p_personas_contratos.cargo_id','p_personas_contratos.regimen_id','p_personas_contratos.estado_contrato','p_personas_contratos.tipo_contrato','p_personas_contratos.modalidad_contrato',
                'p_personas_contratos.fecha_ini_contrato','p_personas_contratos.fecha_fin_contrato','p_personas_contratos.sueldo_mensual'
                ,'p_personas_contratos.monto_adicional','p_personas_contratos.asignacion_familiar','p_personas_contratos.estado',
                DB::raw('CASE p_personas_contratos.estado_contrato  WHEN 1 THEN "Vigente" WHEN 2 THEN "Vacaciones" WHEN 3 THEN "Cesante" END AS estado_contrato_nombre'),
                DB::raw('CASE p_personas_contratos.tipo_contrato  WHEN 1 THEN "Producción" WHEN 2 THEN "Regular"  END AS tipo_contrato_nombre'),
                DB::raw('CASE p_personas_contratos.modalidad_contrato  WHEN 1 THEN "Tiempo Completo" WHEN 2 THEN "Tiempo Parcial"  END AS modalidad_contrato_nombre'),
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
                    if( $r->has("persona") ){
                        $persona=trim($r->persona);
                        if( $persona !='' ){
                           $query->where(DB::raw('CONCAT_WS(" ",mp.paterno,mp.materno,mp.nombre)'),"like", "%".$persona."%");
                        }
                    }
                    if( $r->has("sede") ){
                        $sede=trim($r->sede);
                        if( $sede !='' ){
                            $query->where('ms.sede',"like","%".$sede."%");
                        }   
                    }
                    if( $r->has("consorcio") ){
                        $consorcio=trim($r->consorcio);
                        if( $consorcio !='' ){
                            $query->where('mc.consorcio','like','%'.$consorcio.'%');
                        }   
                    }
                    if( $r->has("estado_contrato") ){
                        $estado_contrato=trim($r->estado_contrato);
                        if( $estado_contrato !='' ){
                            $query->where('p_personas_contratos.estado_contrato','=',$estado_contrato);
                        }   
                    }
                    if( $r->has("tipo_contrato") ){
                        $tipo_contrato=trim($r->tipo_contrato);
                        if( $tipo_contrato !='' ){
                            $query->where('p_personas_contratos.tipo_contrato','=',$tipo_contrato);
                        }   
                    }
                    if( $r->has("modalidad_contrato") ){
                        $modalidad_contrato=trim($r->modalidad_contrato);
                        if( $modalidad_contrato !='' ){
                            $query->where('p_personas_contratos.modalidad_contrato','=',$modalidad_contrato);
                        }   
                    }
                    
                    $query->where('p_personas_contratos.estado','=',1);
             
                }
            );
        $result = $sql->orderBy('p_personas_contratos.id','asc')->paginate(10);
        return $result;
    }
    
    public static function runLoadPersonaContrato($r){
        
        $sql= PersonaContrato::select('p_personas_contratos.id','mp.paterno','mp.materno','mp.nombre','mp.dni','mp.estado','mp.id as persona_id')
            ->join("m_personas as mp","p_personas_contratos.persona_id","=","mp.id")
            ->where(
                function($query) use ($r){
                    if( $r->has("paterno") ){
                        $paterno=trim($r->paterno);
                        if( $paterno !='' ){
                            $query->where('mp.paterno','like','%'.$paterno.'%');
                        }
                    }
                    if( $r->has("materno") ){
                        $materno=trim($r->materno);
                        if( $materno !='' ){
                            $query->where('mp.materno','like','%'.$materno.'%');
                        }
                    }
                    if( $r->has("nombre") ){
                        $nombre=trim($r->nombre);
                        if( $nombre !='' ){
                            $query->where('mp.nombre','like','%'.$nombre.'%');
                        }
                    }
                    if( $r->has("dni") ){
                        $dni=trim($r->dni);
                        if( $dni !='' ){
                            $query->where('mp.dni','like','%'.$dni.'%');
                        }
                    }
                    if( $r->has("email") ){
                        $email=trim($r->email);
                        if( $email !='' ){
                            $query->where('mp.email','like','%'.$email.'%');
                        }
                    }
                    if( $r->has("estado") ){
                        $estado=trim($r->estado);
                        if( $estado !='' ){
                            $query->where('mp.estado','=',$estado);
                        }
                    }
                }
            );
        $result = $sql->orderBy('mp.paterno','asc')->paginate(10);
        return $result;
    }
    
    public static function runLoadReporteHorario($r){
        $cabecera=array();
        $key=0;
        $array_groupby=array('p_personas_contratos.id','ms.sede','mc.consorcio','mp.dni','mp.paterno','mp.materno','mp.nombre');
        
        $sql= PersonaContrato::select(DB::raw('CONCAT_WS(" ",mp.paterno,mp.materno,mp.nombre) as persona'),'ms.sede','mc.consorcio','mp.dni','p_personas_contratos.id')
            ->join('m_personas AS mp', function($join){
                $join->on('mp.id','=','p_personas_contratos.persona_id');
            })
            ->join('m_sedes AS ms', function($join){
                $join->on('ms.id','=','p_personas_contratos.sede_id');
            })
            ->join('m_consorcios AS mc', function($join){
                $join->on('mc.id','=','p_personas_contratos.consorcio_id');
            });
            
            for($i=$r->fecha_inicio;$i<=$r->fecha_final;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
                $sql->addSelect(DB::raw("IF(pa$key.id!='',1,0) as pa$key"))
                    ->leftjoin('p_asistencias as pa'.$key, function($join)use($i,$key){
                        $join->where('pa'.$key.'.fecha_ingreso','=',$i)
                             ->on('pa'.$key.'.persona_contrato_id','=','p_personas_contratos.id');
                    });
                array_push($array_groupby,"pa$key.id");
                array_push($cabecera,$i);
                $key++;
            }
            
            $sql->addSelect(DB::raw("COUNT(pat.id) as pat"))
                    ->leftjoin('p_asistencias as pat', function($join)use($r){
                        $join->whereBetween('pat.fecha_ingreso',[$r->fecha_inicio, $r->fecha_final])
                             ->on('pat.persona_contrato_id','=','p_personas_contratos.id');
                    });
                    
            $sql->where(
                function($query) use ($r){
                    if( $r->has("consorcio_id") ){
                        $consorcio_id=trim($r->consorcio_id);
                        if( $consorcio_id !='0' ){
                            $query->where('p_personas_contratos.consorcio_id','=',$consorcio_id);
                        }
                    }
                    if( $r->has("sede_id") ){
                        $sede_id=trim($r->sede_id);
                        if( $sede_id !='0' ){
                            $query->where('p_personas_contratos.sede_id','=',$sede_id);
                        }
                    }
                }
            );
        $result = $sql->orderBy('mp.paterno','asc')
                      ->groupBy($array_groupby)->get();
        $r['result']=$result;
        $r['cabecera']=$cabecera;
        return $r;
    }
    
    public static function runLoadBoleta($r){
        $sql= DB::table("p_planillas_detalles as ppd")
            ->select('ppd.*')
            ->join("p_planillas as pp","pp.id","=","ppd.planilla_id")
            ->where(
                function($query) use ($r){
                    if( $r->has("persona_id") ){
                        $persona_id=trim($r->persona_id);
                        if( $persona_id !='' ){
                            $query->where('ppd.persona_id','=',$persona_id);
                        }
                    }
                    if( $r->has("fecha_inicio") AND $r->has("fecha_final") ){
                        $fecha_inicio=trim($r->fecha_inicio);
                        $fecha_final=trim($r->fecha_final);
                        if( $fecha_inicio !='' AND  $fecha_final!=''){
                            $query->whereRaw(" DATE_FORMAT(pp.fecha_generada,'%Y-%m') BETWEEN '$fecha_inicio' AND '$fecha_final'");
                        }
                    }
                    if( $r->has("sueldo_bruto") ){
                        $sueldo_bruto=trim($r->sueldo_bruto);
                        if( $sueldo_bruto !='' ){
                            $query->where('ppd.sueldo_bruto','like','%'.$sueldo_bruto.'%');
                        }
                    }
                    if( $r->has("sueldo_neto") ){
                        $sueldo_neto=trim($r->sueldo_neto);
                        if( $sueldo_neto !='' ){
                            $query->where('ppd.sueldo_neto','like','%'.$sueldo_neto.'%');
                        }
                    }
                    if( $r->has("descuento") ){
                        $descuento=trim($r->descuento);
                        if( $descuento !='' ){
                            $query->where('ppd.descuento','like','%'.$descuento.'%');
                        }
                    }
                }
            );
        $result = $sql->orderBy('ppd.id','asc')->paginate(10);
        return $result;
        
    }
    
    public static function runLoadBoletaFind($r){
        $sql= DB::table("p_planillas_detalles as ppd")
            ->select('ppd.*','mp.dni',DB::raw("CONCAT_WS(' ',mp.paterno,mp.materno,mp.nombre) as colaborador"))
            ->join("m_personas as mp","ppd.persona_id","=","mp.id")
            ->where(
                function($query) use ($r){
                    if( $r->has("persona_id") ){
                        $persona_id=trim($r->persona_id);
                        if( $persona_id !='' ){
                            $query->where('ppd.persona_id','=',$persona_id);
                        }
                    }
                    if( $r->has("id") ){
                        $id=trim($r->id);
                        if( $id !='' ){
                            $query->where('ppd.id','=',$id);
                        }
                    }
                }
            );
        $result = $sql->orderBy('ppd.id','asc')->get();
        return $result;
        
    }
    
}
