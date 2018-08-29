<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class Bono extends Model
{
    protected   $table = 'm_bonos';

    public static function runEditStatus($r)
    {
        $certificadoestadoe = Auth::user()->id;
        $certificadoestado = Bono::find($r->id);
        $certificadoestado->estado = trim( $r->estadof );
        $certificadoestado->persona_id_updated_at=$certificadoestadoe;
        $certificadoestado->save();
    }

    public static function runNew($r)
    {
        $nBono = new Bono;
        $nBono->nombre=trim( $r->nombre );
        $nBono->monto=$r->monto;
        $nBono->monto_variable=$r->monto_variable;
        $nBono->auto_aplicable=$r->auto_aplicable;
        $nBono->activo=$r->estado;
        $nBono->estado=1;
        $nBono->persona_id_created_at=Auth::user()->id;
        $nBono->save();
    }

    public static function runEdit($r)
    {
        $nBono = Bono::find($r->idi);
        $nBono->nombre=trim( $r->nombre );
        $nBono->monto=$r->monto;
        $nBono->monto_variable=$r->monto_variable;
        $nBono->auto_aplicable=$r->auto_aplicable;
        $nBono->activo=$r->estado;
        $nBono->persona_id_updated_at=Auth::user()->id;
        $nBono->save();
    }

    public static function runLoad($r)
    {

        $sql=Bono::select('id','nombre','monto','monto_variable','auto_aplicable','estado')
            ->where( 
                function($query) use ($r){
                    if( $r->has("nombre") ){
                        $nombre=trim($r->nombre);
                        if( $nombre !='' ){
                            $query->where('nombre','like','%'.$nombre.'%');
                        }
                    }
                    if( $r->has("auto_aplicable") ){
                        $auto_aplicable=trim($r->auto_aplicable);
                        if( $auto_aplicable !='' ){
                            $query->where('auto_aplicable','like','%'.$auto_aplicable.'%');
                        }
                    }
                    if( $r->has("estado") ){
                        $estado=trim($r->estado);
                        if( $estado !='' ){
                            $query->where('estado','=',$estado);
                        }
                    }
                }
            );


        $result = $sql->orderBy('id','asc')->paginate(10);
        return $result;
    }

    

}
