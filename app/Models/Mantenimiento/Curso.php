<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use DB;

class Curso extends Model
{
    protected   $table = 'm_cursos';

    public static function runLoad($r)
    {

        $sql=Curso::select('id','curso','curso_apocope','estado')
            ->where( 
                function($query) use ($r){
                    if( $r->has("curso") ){
                        $curso=trim($r->curso);
                        if( $curso !='' ){
                            $query->where('curso','like','%'.$curso.'%');
                        }
                    }
//                    if( $r->has("certificado_curso") ){
//                        $certificado_curso=trim($r->certificado_curso);
//                        if( $certificado_curso !='' ){
//                            $query->where('certificado_curso','like','%'.$certificado_curso.'%');
//                        }
//                    }
                    if( $r->has("curso_apocope") ){
                        $curso_apocope=trim($r->curso_apocope);
                        if( $curso_apocope !='' ){
                            $query->where('curso_apocope','like','%'.$curso_apocope.'%');
                        }
                    }
//                    if( $r->has("tipo_curso") ){
//                        $tipo_curso=trim($r->tipo_curso);
//                        if( $tipo_curso !='' ){
//                            $query->where('tipo_curso','like',$tipo_curso.'%');
//                        }
//                    }
                    if( $r->has("estado") ){
                        $estado=trim($r->estado);
                        if( $estado !='' ){
                            $query->where('estado','=',$estado);
                        }
                    }
                }
            );
        $result = $sql->orderBy('curso','asc')->paginate(10);
        return $result;
    }


    public static function runEditStatus($r)
    {
        $cursoe = Auth::user()->id;
        $curso = Curso::find($r->id);
        $curso->estado = trim( $r->estadof );
        $curso->persona_id_updated_at=$cursoe;
        $curso->save();
    }

    public static function runNew($r)
    {
        $cursoe = Auth::user()->id;
        $curso = new Curso;
        $curso->curso = trim( $r->curso );
//        $curso->certificado_curso = trim( $r->certificado_curso );
//        $curso->tipo_curso = trim( $r->tipo_curso );
        $curso->curso_apocope = trim( $r->curso_apocope );
        $curso->estado = trim( $r->estado );
        $curso->persona_id_created_at=$cursoe;
        $curso->save();
    }

    public static function runEdit($r)
    {
        $cursoe = Auth::user()->id;
        $curso = Curso::find($r->id);
        $curso->curso = trim( $r->curso );
//        $curso->certificado_curso = trim( $r->certificado_curso );
//        $curso->tipo_curso = trim( $r->tipo_curso );
        $curso->curso_apocope = trim( $r->curso_apocope );
        $curso->estado = trim( $r->estado );
        $curso->persona_id_updated_at=$cursoe;
        $curso->save();
    }    

    
        public static function ListCurso($r)
    {
        $sql=Curso::select('id','curso','estado')
            ->where('estado','=','1')
            ->where( 
                function($query) use ($r){
                    if( $r->has("tipo_curso") ){
                        $tipo_curso=trim($r->tipo_curso);
                        if( $tipo_curso !='' ){
                            $query->where('tipo_curso','=',$tipo_curso);
                        }
                    }
                }
            );
        $result = $sql->orderBy('curso','asc')->get();
        return $result;
    }
    

}
