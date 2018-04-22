<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class Persona extends Model
{
    protected   $table = 'm_personas';



    public static function runEditStatus($r)
    {
        $persona_id = Auth::user()->id;
        $persona = Persona::find($r->id);
        $persona->estado = trim( $r->estadof );
        $persona->persona_id_updated_at=$persona_id;
        $persona->save();
    }

    public static function runNew($r)
    {
        DB::beginTransaction();
        $persona_id = Auth::user()->id;
        $persona = new Persona;
        $persona->paterno = trim( $r->paterno );
        $persona->materno = trim( $r->materno );
        $persona->nombre = trim( $r->nombre );
        $persona->dni = trim( $r->dni );
        $persona->sexo = trim( $r->sexo );
        $persona->email = trim( $r->email );
        $bcryptpassword = bcrypt($r->password);
        $persona->password=$bcryptpassword;
        $persona->telefono = trim( $r->telefono );
        $persona->celular = trim( $r->celular );
        if(trim( $r->fecha_nacimiento )!=''){
        $persona->fecha_nacimiento = trim( $r->fecha_nacimiento );}
        else {
        $persona->fecha_nacimiento = null;
        }
        $persona->estado = trim( $r->estado );
        $persona->persona_id_created_at=$persona_id;
        $persona->save();

        if ($r->cargos_selec) {
                $privilegios = explode(',', $r->cargos_selec);
                if (is_array($privilegios)) {
                    for ($i=0; $i<count($privilegios); $i++) {

                        $sedes = implode(',', $r['sedes'.$privilegios[$i]]);
                        $consorcios = implode(',', $r['consorcios'.$privilegios[$i]]);
                        $fecha_ingreso = $r['fecha_ingreso'.$privilegios[$i]];
                        $fecha_salida = $r['fecha_salida'.$privilegios[$i]];
                        DB::table('m_sedes_privilegios_personas')->insert(
                            array(
                                'sede_ids' => $sedes,
                                'consorcio_ids' => $consorcios,
                                'privilegio_id' => $privilegios[$i],
                                'persona_id' => $persona->id,
                                'fecha_ingreso' => $fecha_ingreso,
                                'fecha_salida' => $fecha_salida,
                                'created_at'=> date('Y-m-d h:m:s'),
                                'persona_id_created_at'=> Auth::user()->id,
                                'estado' => 1,
                            )
                        );
                        
                    }
                }
            }
        DB::commit();
    }

    public static function runEdit($r)
    {
        var_dump("");exit();
        DB::beginTransaction();
        $persona_id = Auth::user()->id;
        $persona = Persona::find($r->id);
        $persona->paterno = trim( $r->paterno );
        $persona->materno = trim( $r->materno );
        $persona->nombre = trim( $r->nombre );
        $persona->dni = trim( $r->dni );
        $persona->sexo = trim( $r->sexo );
        $persona->email = trim( $r->email );
        if(trim( $r->password )!=''){
        $persona->password=bcrypt($r->password);}

        $persona->telefono = trim( $r->telefono );
        $persona->celular = trim( $r->celular );

        if(trim( $r->fecha_nacimiento )!='')
        {
        $persona->fecha_nacimiento = trim( $r->fecha_nacimiento );
        }
        else
        {
        $persona->fecha_nacimiento = null;
        }

        $persona->estado = trim( $r->estado );
        $persona->persona_id_updated_at=$persona_id;
        $persona->save();

        DB::table('m_sedes_privilegios_personas')
                ->where('persona_id', $r->id)
                ->update(array('estado' => 0,
                    'persona_id_updated_at' => Auth::user()->id));
        
        if ($r->cargos_selec) {
            $privilegios = explode(',', $r->cargos_selec);
            if (is_array($privilegios)) {
                for ($i=0; $i<count($privilegios); $i++) {
                    
                    $sedes = implode(',', $r['sedes'.$privilegios[$i]]);
                    $consorcios = implode(',', $r['consorcios'.$privilegios[$i]]);
                    $fecha_ingreso = $r['fecha_ingreso'.$privilegios[$i]];
                    $fecha_salida = $r['fecha_salida'.$privilegios[$i]];
                            
                    $privilegioPersona=DB::table('m_sedes_privilegios_personas')
                            ->where('privilegio_id', $privilegios[$i])
                            ->where('persona_id', $r->id)
                            ->first();
                    
                    if (is_null($privilegioPersona)) {
                        
                        DB::table('m_sedes_privilegios_personas')->insert(
                            array(
                                'sede_ids' => $sedes,
                                'consorcio_ids' => $consorcios,
                                'privilegio_id' => $privilegios[$i],
                                'persona_id' => $persona->id,
                                'fecha_ingreso' => $fecha_ingreso,
                                'fecha_salida' => $fecha_salida,
                                'created_at'=> date('Y-m-d h:m:s'),
                                'persona_id_created_at'=> Auth::user()->id,
                                'estado' => 1,
                            )
                        );
                    } else {
                        DB::table('m_sedes_privilegios_personas')
                        ->where('persona_id', '=', $r->id)
                        ->where('privilegio_id', '=', $privilegios[$i])
                        ->update(
                            array(
                                'sede_ids' => $sedes,
                                'consorcio_ids' => $consorcios,
                                'fecha_ingreso' => $fecha_ingreso,
                                'fecha_salida' => $fecha_salida,
                                'estado' => 1,
                                'persona_id_updated_at' => Auth::user()->id
                            ));
                    }
                   

                }
            }
        }
        DB::commit();
    }


    public static function runLoad($r)
    {
        $sql=Persona::select('id','paterno','materno','nombre','dni',
            'email',DB::raw('IFNULL(fecha_nacimiento,"") as fecha_nacimiento'),'sexo','telefono',
            'celular','password','estado')
            ->where(
                function($query) use ($r){
                    if( $r->has("paterno") ){
                        $paterno=trim($r->paterno);
                        if( $paterno !='' ){
                            $query->where('paterno','like','%'.$paterno.'%');
                        }
                    }
                    if( $r->has("materno") ){
                        $materno=trim($r->materno);
                        if( $materno !='' ){
                            $query->where('materno','like','%'.$materno.'%');
                        }
                    }
                    if( $r->has("nombre") ){
                        $nombre=trim($r->nombre);
                        if( $nombre !='' ){
                            $query->where('nombre','like','%'.$nombre.'%');
                        }
                    }
                    if( $r->has("dni") ){
                        $dni=trim($r->dni);
                        if( $dni !='' ){
                            $query->where('dni','like','%'.$dni.'%');
                        }
                    }
                    if( $r->has("email") ){
                        $email=trim($r->email);
                        if( $email !='' ){
                            $query->where('email','like','%'.$email.'%');
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
        $result = $sql->orderBy('paterno','asc')->paginate(10);
        return $result;
    }

     public static function getAreas($personaId) {
        $sql = DB::table('m_sedes_privilegios_personas as mspp')
                   ->select('mspp.privilegio_id','mspp.sede_ids',"mp.privilegio",
                           'mspp.consorcio_ids','mspp.fecha_ingreso','mspp.fecha_salida')
                   ->join("m_privilegios as  mp","mp.id","=","mspp.privilegio_id")
                   ->where('mspp.persona_id','=',$personaId)
                   ->where('mspp.estado','=',1)
                    ->get();
        
        return $sql;
    }



}
