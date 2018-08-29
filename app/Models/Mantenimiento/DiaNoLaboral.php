<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class DiaNoLaboral extends Model
{
    protected   $table = 'm_dias_no_laborables';

    public static function runEditStatus($r)
    {
        $dianolaboral = DiaNoLaboral::find($r->id);
        $dianolaboral->estado = trim( $r->estadof );
        $dianolaboral->persona_id_updated_at=Auth::user()->id;
        $dianolaboral->save();
    }

    public static function runNew($r)
    {
        $dianolaboral = new DiaNoLaboral;
        $dianolaboral->fecha = trim( $r->fecha );
        $dianolaboral->estado = trim( $r->estado );
        $dianolaboral->pago = trim( $r->pago );
        $dianolaboral->persona_id_created_at=Auth::user()->id;
        $dianolaboral->save();
        $sedes = $r->sede_ids;

        // GRABA MULTIPLE
        $dianolaboral = DiaNoLaboral::find($dianolaboral->id);
        $sede_ids = '';
        for($i=0;$i<count($sedes);$i++)
        {
            if($i == 0)
                $sede_ids = $sedes[$i];
            else
                $sede_ids .= ','.$sedes[$i];
        }
        $dianolaboral->sede_ids = $sede_ids;
        $dianolaboral->save();        
        // --
    }

    public static function runEdit($r)
    {
        $dianolaboral = DiaNoLaboral::find($r->id);
        $dianolaboral->fecha = trim( $r->fecha );
        $dianolaboral->estado = trim( $r->estado );
        $dianolaboral->pago = trim( $r->pago );
        $dianolaboral->persona_id_updated_at=Auth::user()->id;
        //$dianolaboral->save();

        // --
        $sedes = $r->sede_ids;
        $sede_ids = '';
        for($i=0;$i<count($sedes);$i++)
        {
            if($i == 0)
                $sede_ids = $sedes[$i];
            else
                $sede_ids .= ','.$sedes[$i];
        }
        $dianolaboral->sede_ids = $sede_ids;
        $dianolaboral->save();        
        // --
    }


    public static function runLoad($r)
    {
        $sql=DiaNoLaboral::select('m_dias_no_laborables.id',
                                'm_dias_no_laborables.fecha',
                                'm_dias_no_laborables.sede_ids',
                                'm_dias_no_laborables.pago',
                                DB::raw('(SELECT GROUP_CONCAT(sede) FROM m_sedes s WHERE FIND_IN_SET(s.id, sede_ids)) sede'), 
                                'm_dias_no_laborables.estado')
                            ->where( 
                                    
                                function($query) use ($r){
                                    if( $r->has("fecha") ){
                                        $fecha=trim($r->fecha);
                                        if( $fecha !='' ){
                                           $query->where('m_dias_no_laborables.fecha','like','%'.$fecha.'%');
                                        }
                                    }                   
                                    if( $r->has("estado") ){
                                        $estado=trim($r->estado);
                                        if( $estado !='' ){
                                            $query->where('m_dias_no_laborables.estado','=',''.$estado.'');
                                        }
                                    }
                                }
                            );
        $result = $sql->orderBy('m_dias_no_laborables.id','asc')->paginate(10);
        return $result;
    }
    

}
