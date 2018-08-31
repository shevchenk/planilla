<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use DB;

class Carrera extends Model
{
    protected   $table = 'm_carreras';

    public static function runLoad($r)
    {

        $sql=DB::table('m_carreras AS me')
            ->leftJoin('m_cursos_carreras AS mce',function($join){
                $join->on('mce.carrera_id','=','me.id')
                ->where('mce.estado','=',1);
            })
            ->leftJoin('m_cursos AS mc',function($join){
                $join->on('mc.id','=','mce.curso_id')
                ->where('mc.estado','=',1);
            })
            ->select(
            'me.id',
            'me.carrera',
//            'me.certificado_carrera',
            'me.estado',
            DB::raw('GROUP_CONCAT(mc.curso ORDER BY curso) cursos'),
            DB::raw('GROUP_CONCAT(mc.id) curso_id')
            )
            ->where( 
                function($query) use ($r){
                    if( $r->has("carrera") ){
                        $carrera=trim($r->carrera);
                        if( $carrera !='' ){
                            $query->where('me.carrera','like','%'.$carrera.'%');
                        }
                    }
//                    if( $r->has("certificado_carrera") ){
//                        $certificado_carrera=trim($r->certificado_carrera);
//                        if( $certificado_carrera !='' ){
//                            $query->where('me.certificado_carrera','like','%'.$certificado_carrera.'%');
//                        }
//                    }

                    if( $r->has("estado") ){
                        $estado=trim($r->estado);
                        if( $estado !='' ){
                            $query->where('me.estado','like','%'.$estado.'%');
                        }
                    }
                }
            )
            ->groupBy('me.id','me.carrera','me.estado');
        $result = $sql->orderBy('me.carrera','asc')->paginate(10);
        return $result;
    }


    public static function runEditStatus($r)
    {
        $carrera_id = Auth::user()->id;
        $carrera = Carrera::find($r->id);
        $carrera->estado = trim( $r->estadof );
        $carrera->persona_id_updated_at=$carrera_id;
        $carrera->save();
    }

    public static function runNew($r)
    {
        $carrera_id = Auth::user()->id;
        $carrera = new Carrera;
        $carrera->carrera = trim( $r->carrera );
//        $carrera->certificado_carrera = trim( $r->certificado_carrera );
        $carrera->estado = trim( $r->estado );
        $carrera->persona_id_created_at=$carrera_id;
        $carrera->save();
        $curso = $r->curso_id;

        //ESTO HACE QUE GRABE EN LA TABLE DETALLE LOS CURSOS, LO QUE SE ESCOJE EN EL COMBO CURSO
        for($i=0;$i<count($curso);$i++)
        {
            $curso_carrera = new CursoCarrera;
            $curso_carrera->curso_id = $curso[$i];
            $curso_carrera->carrera_id = $carrera -> id;
            $curso_carrera->persona_id_created_at = Auth::user()->id;
            $curso_carrera->save();
        }
    }

    public static function runEdit($r)
    {
        $carrera_id = Auth::user()->id;
        $carrera = Carrera::find($r->id);
        $carrera->carrera = trim( $r->carrera );
//        $carrera->certificado_carrera = trim( $r->certificado_carrera );
        $carrera->estado = trim( $r->estado );
        $carrera->persona_id_updated_at=$carrera_id;
        $carrera->save();
        $curso = $r->curso_id;

        //ESTO HACE QUE GRABE EN LA TABLE DETALLE LOS CURSOS, LO QUE SE ESCOJE EN EL COMBO CURSO
        if( count($curso)>0 ){
            DB::table('m_cursos_carreras')
            ->where('carrera_id', '=', $carrera->id)
            ->update(
                array(
                    'estado' => 0,
                    'persona_id_updated_at' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                    )
                );
        }
        for($i=0;$i<count($curso);$i++)
        {
            $curso_carrera=DB::table('m_cursos_carreras')
            ->where('carrera_id', '=', $carrera->id)
            ->where('curso_id', '=', $curso[$i])
            ->first();
            if( count($curso_carrera)==0 ){
                $curso_carrera = new CursoCarrera;
                $curso_carrera->curso_id = $curso[$i];
                $curso_carrera->carrera_id = $carrera->id;
                $curso_carrera->persona_id_created_at = Auth::user()->id;
            }
            else{
                $curso_carrera = CursoCarrera::find($curso_carrera->id);
                $curso_carrera->estado = 1;
                $curso_carrera->persona_id_updated_at = Auth::user()->id;
            }
            $curso_carrera->save();
        }
    }    

    
    public static function ListCarrera($r)
    {
        $sql=Carrera::select('id','carrera','certificado_carrera','estado')
            ->where('estado','=','1');
        $result = $sql->orderBy('carrera','asc')->get();
        return $result;
    }
    
}
