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

                    if($r['sedes'.$privilegios[$i]]){
                        $sedes = implode(',', $r['sedes'.$privilegios[$i]]);
                    }else{
                        $sedes='';
                    }
                    if($r['consorcios'.$privilegios[$i]]){
                        $consorcios = implode(',', $r['consorcios'.$privilegios[$i]]);
                    }else{
                        $consorcios='';
                    }
                    if($r['fecha_salida'.$privilegios[$i]]){
                        $fecha_salida = $r['fecha_salida'.$privilegios[$i]];
                    }else{
                        $fecha_salida=null;
                    }

                    $fecha_ingreso = $r['fecha_ingreso'.$privilegios[$i]];
                    
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

        // Tabla m_personas_grados
        if ($r->grados_selec) {
            $data = explode(',', $r->grados_selec);
            if (is_array($data)) {
                for ($i=0; $i<count($data); $i++) {
                    $universidad = $r['universidad'.$data[$i]];
                    $grado_instruccion = $r['grado_instruccion'.$data[$i]];
                    $anio = $r['anio'.$data[$i]];
                    
                    DB::table('m_personas_grados')->insert(
                        array(
                            'persona_id' => $persona->id,
                            'universidad' => $universidad,
                            'grado_instruccion' => $grado_instruccion,                            
                            'anio' => $anio,
                            'created_at'=> date('Y-m-d h:m:s'),
                            'persona_id_created_at'=> Auth::user()->id,
                            'estado' => 1,
                        )
                    );
                }
            }
        }
        // --

        // Tabla m_personas_investigaciones
        if ($r->investiga_selec) {
            $data = explode(',', $r->investiga_selec);
            if (is_array($data)) {
                for ($i=0; $i<count($data); $i++) {
                    $investiga = $r['investiga'.$data[$i]];
                    $anio = $r['anio'.$data[$i]];
                    
                    DB::table('m_personas_investigaciones')->insert(
                        array(
                            'persona_id' => $persona->id,
                            'investiga' => $universidad,
                            'anio' => $anio,
                            'created_at'=> date('Y-m-d h:m:s'),
                            'persona_id_created_at'=> Auth::user()->id,
                            'estado' => 1,
                        )
                    );
                }
            }
        }
        // --

        // Tabla m_personas_publicaciones
        if ($r->publica_selec) {
            $data = explode(',', $r->publica_selec);
            if (is_array($data)) {
                for ($i=0; $i<count($data); $i++) {
                    $publica = $r['publica'.$data[$i]];
                    $anio = $r['anio'.$data[$i]];
                    $revista = $r['revista'.$data[$i]];
                    
                    DB::table('m_personas_publicaciones')->insert(
                        array(
                            'persona_id' => $persona->id,
                            'publica' => $publica,
                            'anio' => $anio,
                            'revista' => $revista,
                            'created_at'=> date('Y-m-d h:m:s'),
                            'persona_id_created_at'=> Auth::user()->id,
                            'estado' => 1,
                        )
                    );
                }
            }
        }
        // --

        DB::commit();
    }

    public static function runEdit($r)
    {
        
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
                
        
        if ($r->cargos_selec) {
            
            DB::table('m_sedes_privilegios_personas')
                ->where('persona_id', $r->id)
                ->update(array('estado' => 0,
                    'persona_id_updated_at' => Auth::user()->id));
            
            $privilegios = explode(',', $r->cargos_selec);
            if (is_array($privilegios)) {
                for ($i=0; $i<count($privilegios); $i++) {
                    
                    if($r['sedes'.$privilegios[$i]]){
                        $sedes = implode(',', $r['sedes'.$privilegios[$i]]);
                    }else{
                        $sedes='';
                    }
                    if($r['consorcios'.$privilegios[$i]]){
                        $consorcios = implode(',', $r['consorcios'.$privilegios[$i]]);
                    }else{
                        $consorcios='';
                    }
                    if($r['fecha_salida'.$privilegios[$i]]){
                        $fecha_salida = $r['fecha_salida'.$privilegios[$i]];
                    }else{
                        $fecha_salida=null;
                    }
                    
                    $fecha_ingreso = $r['fecha_ingreso'.$privilegios[$i]];
                    
                            
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

        // Tabla m_personas_grados
        if ($r->grados_selec) {
            $data = explode(',', $r->grados_selec);
            if (is_array($data)) {
                for ($i=0; $i<count($data); $i++) {
                    $universidad = $r['universidad'.$data[$i]];
                    $grado_instruccion = $r['grado_instruccion'.$data[$i]];
                    $anio = $r['anio'.$data[$i]];
                    
                    if($universidad)
                    {
                        $persona_grados=DB::table('m_personas_grados')
                            ->where('id', $data[$i])
                            ->first();

                        if (is_null($persona_grados))
                        {
                            DB::table('m_personas_grados')->insert(
                                array(
                                    'persona_id' => $persona->id,
                                    'universidad' => $universidad,
                                    'grado_instruccion' => $grado_instruccion,                            
                                    'anio' => $anio,
                                    'created_at'=> date('Y-m-d h:m:s'),
                                    'persona_id_created_at'=> Auth::user()->id,
                                    'estado' => 1,
                                )
                            );
                        } 
                        else 
                        {
                            DB::table('m_personas_grados')
                                ->where('id', '=', $data[$i])
                                ->update(
                                    array(
                                        'universidad' => $universidad,
                                        'grado_instruccion' => $grado_instruccion,                            
                                        'anio' => $anio,
                                        'estado' => 1,
                                        'updated_at'=> date('Y-m-d h:m:s'),
                                        'persona_id_updated_at' => Auth::user()->id
                                    )
                            );
                        }
                        
                    }
                    
                }
            }
        }
        // --

        // Tabla m_personas_investigaciones
        if ($r->investiga_selec) {
            $data = explode(',', $r->investiga_selec);
            if (is_array($data)) {
                for ($i=0; $i<count($data); $i++) {
                    $investiga = $r['investiga'.$data[$i]];
                    $anio = $r['anio'.$data[$i]];
                    
                    if($investiga)
                    {
                        $persona_investiga=DB::table('m_personas_investigaciones')
                            ->where('id', $data[$i])
                            ->first();

                        if (is_null($persona_investiga))
                        {
                            DB::table('m_personas_investigaciones')->insert(
                                array(
                                    'persona_id' => $persona->id,
                                    'investiga' => $investiga,
                                    'anio' => $anio,
                                    'created_at'=> date('Y-m-d h:m:s'),
                                    'persona_id_created_at'=> Auth::user()->id,
                                    'estado' => 1,
                                )
                            );
                        } 
                        else 
                        {
                            DB::table('m_personas_investigaciones')
                                ->where('id', '=', $data[$i])
                                ->update(
                                    array(
                                        'investiga' => $investiga,                                        
                                        'anio' => $anio,
                                        'estado' => 1,
                                        'updated_at'=> date('Y-m-d h:m:s'),
                                        'persona_id_updated_at' => Auth::user()->id
                                    )
                            );
                        }
                        
                    }
                    
                }
            }
        }
        // --


        // Tabla m_personas_publicaciones
        if ($r->publica_selec) {
            $data = explode(',', $r->publica_selec);
            if (is_array($data)) {
                for ($i=0; $i<count($data); $i++) {
                    $publica = $r['publica'.$data[$i]];
                    $anio = $r['anio'.$data[$i]];
                    $revista = $r['revista'.$data[$i]];
                    
                    if($publica)
                    {
                        $persona_publica=DB::table('m_personas_publicaciones')
                            ->where('id', $data[$i])
                            ->first();

                        if (is_null($persona_publica))
                        {
                            DB::table('m_personas_publicaciones')->insert(
                                array(
                                    'persona_id' => $persona->id,
                                    'publica' => $publica,
                                    'anio' => $anio,
                                    'revista' => $revista,
                                    'created_at'=> date('Y-m-d h:m:s'),
                                    'persona_id_created_at'=> Auth::user()->id,
                                    'estado' => 1,
                                )
                            );
                        } 
                        else 
                        {
                            DB::table('m_personas_publicaciones')
                                ->where('id', '=', $data[$i])
                                ->update(
                                    array(
                                        'publica' => $publica,
                                        'anio' => $anio,
                                        'revista' => $revista,
                                        'estado' => 1,
                                        'updated_at'=> date('Y-m-d h:m:s'),
                                        'persona_id_updated_at' => Auth::user()->id
                                    )
                            );
                        }
                        
                    }
                    
                }
            }
        }
        // --

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
                           'mspp.consorcio_ids',DB::raw('IFNULL(mspp.fecha_ingreso,"") as fecha_ingreso'),
                           DB::raw('IFNULL(mspp.fecha_salida,"") as fecha_salida'))
                   ->join("m_privilegios as  mp","mp.id","=","mspp.privilegio_id")
                   ->where('mspp.persona_id','=',$personaId)
                   ->where('mspp.estado','=',1)
                    ->get();
        
        return $sql;
    }

    public static function getGrado($personaId) {
        $sql = DB::table('m_personas_grados as mpg')
                   ->select('mpg.id','mpg.persona_id',"mpg.universidad","mpg.grado_instruccion",
                           'mpg.anio')
                   //->join("m_privilegios as  mp","mp.id","=","mspp.privilegio_id")
                   ->where('mpg.persona_id','=',$personaId)
                   ->where('mpg.estado','=',1)
                   ->get();        
        return $sql;
    }

    public static function getInvestigaciones($personaId) {
        $sql = DB::table('m_personas_investigaciones as mpi')
                   ->select('mpi.id','mpi.persona_id',"mpi.investiga",
                           'mpi.anio')
                   ->where('mpi.persona_id','=',$personaId)
                   ->where('mpi.estado','=',1)
                   ->get();        
        return $sql;
    }

    public static function getPublicaciones($personaId) {
        $sql = DB::table('m_personas_publicaciones as mpa')
                   ->select('mpa.id','mpa.persona_id',"mpa.publica", "mpa.revista",
                           'mpa.anio')
                   ->where('mpa.persona_id','=',$personaId)
                   ->where('mpa.estado','=',1)
                   ->get();        
        return $sql;
    }

}
