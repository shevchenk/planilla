<?php

namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class HorarioProgramado extends Model
{
    protected   $table = 'p_horarios_programados';

    public static function runEditStatus($r)
    {
        DB::table('p_horarios_programados')
            ->where('horario_plantilla_id', $r->id)
            ->update(['estado' => trim( $r->estadof),
                        'updated_at' => date('Y-m-d H:i:s'), 
                        'persona_id_updated_at' => Auth::user()->id]);        
    }

    public static function runNew($r)
    {
        $horarioprogramdo = new HorarioProgramado;
        $horarioprogramdo->persona_contrato_id = trim( $r->persona_contrato_id );
        $horarioprogramdo->dia_id = trim( $r->dia_id );
        $horarioprogramdo->horario_plantilla_id = trim( $r->horario_plantilla_id );
        $horarioprogramdo->hora_inicio = trim( $r->hora_inicio );
        $horarioprogramdo->hora_fin = trim( $r->hora_fin );
        $horarioprogramdo->horario_amanecida = trim( $r->horario_amanecida );
        $horarioprogramdo->tolerancia = trim( $r->tolerancia );
        $horarioprogramdo->estado = 1;
        $horarioprogramdo->persona_id_created_at=Auth::user()->id;
        $horarioprogramdo->save();
    }

    public static function runEdit($r)
    {
        $horarioprogramdo = HorarioProgramado::find($r->id);
        $horarioprogramdo->estado = trim( $r->estado );
        $horarioprogramdo->persona_id_updated_at=Auth::user()->id;
        $horarioprogramdo->save();
    }


    public static function runLoad($r)
    {
        /*
        $sql= HorarioProgramado::select('p_horarios_programados.horario_plantilla_id',
                                DB::raw('(REPLACE(GROUP_CONCAT(d.dia, "-", p_horarios_programados.hora_inicio, "-", hp.hora_fin, "-", p_horarios_programados.tolerancia), ",", "|")) as horas_programadas'),
                                'p_horarios_programados.estado')
            ->join('a_dias as d','d.id','=','p_horarios_programados.dia_id')
            ->join('m_horarios_plantillas as hp','hp.id','=','p_horarios_programados.horario_plantilla_id')
            ->where('p_horarios_programados.estado','=','1')
            ->groupBy('p_horarios_programados.horario_plantilla_id', 
                            'p_horarios_programados.hora_inicio',
                        'p_horarios_programados.estado');
        $result = $sql->orderBy('p_horarios_programados.id','asc')->get();
        return $result;
        */
        
        $sql= HorarioProgramado::select('p_horarios_programados.horario_plantilla_id',
                                DB::raw('GROUP_CONCAT(d.dia, "-", p_horarios_programados.hora_inicio, "-", hp.hora_fin, "-", p_horarios_programados.tolerancia  SEPARATOR "|") as horas_programadas'),
                                'p_horarios_programados.estado')
            ->join('a_dias as d','d.id','=','p_horarios_programados.dia_id')
            ->join('m_horarios_plantillas as hp','hp.id','=','p_horarios_programados.horario_plantilla_id')
            ->where('p_horarios_programados.estado','=','1')
            ->where('p_horarios_programados.persona_contrato_id','=',$r->persona_contrato_id)
            ->groupBy('p_horarios_programados.horario_plantilla_id',
                            'p_horarios_programados.hora_inicio',
                        'p_horarios_programados.estado');
        $result = $sql->get();
        return $result;
    }    
    

}
