<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class Dias extends Model
{
    protected   $table = 'a_dias';

    public static function runLoad($r)
    {
        $sql=Dias::select('a_dias.id',
                                'a_dias.dia');
        $result = $sql->orderBy('a_dias.id','asc')->paginate(10);
        return $result;
    }
    
    public static function ListDias($r)
    {
        $sql=Dias::select('id','dia')
            ->where('estado','=','1');
        $result = $sql->orderBy('id','asc')->get();
        return $result;
    }
}
