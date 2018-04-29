<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class HorarioPlantilla extends Model
{
    protected   $table = 'm_horarios_plantillas';

    public static function runEditStatus($r)
    {
        $horarioplantilla = HorarioPlantilla::find($r->id);
        $horarioplantilla->estado = trim( $r->estadof );
        $horarioplantilla->persona_id_updated_at=Auth::user()->id;
        $horarioplantilla->save();
    }

    public static function runNew($r)
    {
        $horarioplantilla = new HorarioPlantilla;
        $horarioplantilla->plantilla_descripcion = trim( $r->plantilla_descripcion );
        $horarioplantilla->hora_inicio = trim( $r->hora_inicio );
        $horarioplantilla->hora_fin = trim( $r->hora_fin );
        $horarioplantilla->horario_amanecida = trim( $r->horario_amanecida );
        $horarioplantilla->estado = trim( $r->estado );
        $horarioplantilla->persona_id_created_at=Auth::user()->id;
        $horarioplantilla->save();
        $dias = $r->dia_ids;

        // GRABA MULTIPLE
        $horarioplantilla = HorarioPlantilla::find($horarioplantilla->id);
        $dia_ids = '';
        for($i=0;$i<count($dias);$i++)
        {
            if($i == 0)
                $dia_ids = $dias[$i];
            else
                $dia_ids .= ','.$dias[$i];
        }
        $horarioplantilla->dia_ids = $dia_ids;
        $horarioplantilla->save();        
        // --
    }

    public static function runEdit($r)
    {
        $horarioplantilla = HorarioPlantilla::find($r->id);
        $horarioplantilla->plantilla_descripcion = trim( $r->plantilla_descripcion );
        $horarioplantilla->hora_inicio = trim( $r->hora_inicio );
        $horarioplantilla->hora_fin = trim( $r->hora_fin );
        $horarioplantilla->horario_amanecida = trim( $r->horario_amanecida );
        $horarioplantilla->estado = trim( $r->estado );
        $horarioplantilla->persona_id_updated_at=Auth::user()->id;

        // --
        $dias = $r->dia_ids;
        $dia_ids = '';
        for($i=0;$i<count($dias);$i++)
        {
            if($i == 0)
                $dia_ids = $dias[$i];
            else
                $dia_ids .= ','.$dias[$i];
        }
        $horarioplantilla->dia_ids = $dia_ids;
        $horarioplantilla->save();        
        // --
    }


    public static function runLoad($r)
    {
        $sql=HorarioPlantilla::select('m_horarios_plantillas.id',
                                'm_horarios_plantillas.plantilla_descripcion',
                                'm_horarios_plantillas.dia_ids',
                                'm_horarios_plantillas.hora_inicio',
                                'm_horarios_plantillas.hora_fin',
                                'm_horarios_plantillas.horario_amanecida',
                                DB::raw('(SELECT GROUP_CONCAT(dia) FROM a_dias d WHERE FIND_IN_SET(d.id, dia_ids)) dia'),
                                DB::raw('CASE m_horarios_plantillas.horario_amanecida  WHEN 1 THEN "SI" WHEN 0 THEN "NO" END AS amanecida'),
                                'm_horarios_plantillas.estado')
                            ->where( 
                                    
                                function($query) use ($r){
                                    if( $r->has("plantilla_descripcion") ){
                                        $plantilla_descripcion=trim($r->plantilla_descripcion);
                                        if( $plantilla_descripcion !='' ){
                                           $query->where('m_horarios_plantillas.plantilla_descripcion','like','%'.$plantilla_descripcion.'%');
                                        }
                                    }
                                    if( $r->has("hora_inicio") ){
                                        $hora_inicio=trim($r->hora_inicio);
                                        if( $hora_inicio !='' ){
                                           $query->where('m_horarios_plantillas.hora_inicio','like','%'.$hora_inicio.'%');
                                        }
                                    }
                                    if( $r->has("hora_fin") ){
                                        $hora_fin=trim($r->hora_fin);
                                        if( $hora_fin !='' ){
                                           $query->where('m_horarios_plantillas.hora_fin','like','%'.$hora_fin.'%');
                                        }
                                    }
                                    if( $r->has("horario_amanecida") ){
                                        $horario_amanecida=trim($r->horario_amanecida);
                                        if( $horario_amanecida !='' ){
                                            $query->where('m_horarios_plantillas.horario_amanecida','=',$horario_amanecida);
                                        }   
                                    } 
                                    if( $r->has("estado") ){
                                        $estado=trim($r->estado);
                                        if( $estado !='' ){
                                            $query->where('m_horarios_plantillas.estado','=',''.$estado.'');
                                        }
                                    }
                                }
                            );
        $result = $sql->orderBy('m_horarios_plantillas.id','asc')->paginate(10);
        return $result;
    }
    
    public static function ListHorarioPlantilla($r)
    {
        $sql= HorarioPlantilla::select('m_horarios_plantillas.id',
                                'm_horarios_plantillas.plantilla_descripcion',
                                'm_horarios_plantillas.hora_inicio',
                                'm_horarios_plantillas.hora_fin',
                                'm_horarios_plantillas.horario_amanecida',
                                DB::raw('(SELECT REPLACE(GROUP_CONCAT(d.dia_apocope), ",", " - ") FROM a_dias d WHERE FIND_IN_SET(d.id, dia_ids)) dia_apocope'),
                                DB::raw('(SELECT GROUP_CONCAT(d.id, "-", d.dia) FROM a_dias d WHERE FIND_IN_SET(d.id, dia_ids)) dias'),
                                'm_horarios_plantillas.estado')
            ->where('m_horarios_plantillas.estado','=','1');
        $result = $sql->orderBy('m_horarios_plantillas.id','asc')->get();
        return $result;
    }
}
