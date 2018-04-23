<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class Cargo extends Model
{
    protected   $table = 'm_cargos';
    
    public static function ListCargo($r){
        $sql=Cargo::select('id','cargo','estado')
            ->where('estado','=','1');
        $result = $sql->orderBy('cargo','asc')->get();
        return $result;
    }
    
    public static function SueldoCargo($r){
        $sql=Cargo::select('id','sueldo_mensual_base','sueldo_produccion_base')
            ->where('estado','=','1')
            ->where('id','=',$r->cargo_id);
        $result = $sql->orderBy('cargo','asc')->get();
        return $result;
    }
    

}
