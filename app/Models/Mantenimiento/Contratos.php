<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class Contratos extends Model
{
    protected   $table = 'p_personas_contratos_historicos AS ch';

    public static function listContratos($r)
    {

        $sql=Contratos::select(
        'ch.id',
        'ms.sede',
        'mco.consorcio',
        'mca.cargo',
        'mr.regimen',
        'ch.estado_contrato as estado',
        'ch.fecha_ini_contrato',
        'ch.sueldo_mensual',
        'ch.monto_adicional',
        'ch.asignacion_familiar',
        'ch.tipo_contrato',
        'mp.dni',
        'mp.sexo',
        DB::raw('CONCAT(mp.nombre,\' \',mp.materno,\' \',mp.materno) as nombre'),
        'ch.fecha_fin_contrato')->
        join("m_sedes as ms","ms.id","ch.sede_id")->
        join("m_consorcios as mco","mco.id","ch.consorcio_id")->
        join("m_cargos as mca","mca.id","ch.cargo_id")->
        join("m_personas as mp","mp.id","ch.persona_id")->
        join("m_regimenes as mr","mr.id","ch.regimen_id")
        ->whereRaw('ch.persona_id='.$r->persona);
        $result = $sql->orderBy('ch.id','desc')->get();

        return $result;
    }
}
