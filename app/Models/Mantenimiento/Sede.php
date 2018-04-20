<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class Sede extends Model
{
    protected   $table = 'm_sedes';

    public static function runEditStatus($r)
    {
        $sedee = Auth::user()->id;
        $sede = Sede::find($r->id);
        $sede->estado = trim( $r->estadof );
        $sede->persona_id_updated_at=$sedee;
        $sede->save();
    }

    public static function runNew($r)
    {
        $sedee = Auth::user()->id;
        $sede = new Sede;
        $sede->sede = trim( $r->sede );
        $sede->direccion = trim( $r->direccion );
        $sede->telefono = trim( $r->telefono );
        $sede->celular = trim( $r->celular );
        $sede->email = trim( $r->email );
        $sede->estado = trim( $r->estado );
        $sede->persona_id_created_at=$sedee;
        if(trim($r->imagen_nombre)!=''){
        $sede->foto=$r->imagen_nombre;
        $este = new Sede;
        $url = "img/sede/".$r->imagen_nombre; 
        $este->fileToFile($r->imagen_archivo, $url);}
        else {
        $sede->foto=null;    
        }
        $sede->save();
    }

    public static function runEdit($r)
    {
        $sedee = Auth::user()->id;
        $sede = Sede::find($r->id);
        $sede->sede = trim( $r->sede );
        $sede->direccion = trim( $r->direccion );
        $sede->telefono = trim( $r->telefono );
        $sede->celular = trim( $r->celular );
        $sede->email = trim( $r->email );
        $sede->estado = trim( $r->estado );
        $sede->persona_id_updated_at=$sedee;
        if(trim($r->imagen_nombre)!=''){
            $sede->foto=$r->imagen_nombre;
        }else {
            $sede->foto=null;    
        }
        if(trim($r->imagen_archivo)!=''){
            $este = new Sede;
            $url = "img/sede/".$r->imagen_nombre; 
            $este->fileToFile($r->imagen_archivo, $url);
        }
        $sede->save();
    }

    public static function runLoad($r)
    {
        $sql=Sede::select('id','sede','direccion','telefono','celular','email','foto','estado')
            ->where( 
                function($query) use ($r){
                    if( $r->has("sede") ){
                        $sede=trim($r->sede);
                        if( $sede !='' ){
                            $query->where('sede','like','%'.$sede.'%');
                        }
                    }
                    if( $r->has("direccion") ){
                        $direccion=trim($r->direccion);
                        if( $direccion !='' ){
                            $query->where('direccion','like','%'.$direccion.'%');
                        }
                    }
                    if( $r->has("telefono") ){
                        $telefono=trim($r->telefono);
                        if( $telefono !='' ){
                            $query->where('telefono','like',$telefono.'%');
                        }
                    }
                    if( $r->has("celular") ){
                        $celular=trim($r->celular);
                        if( $celular !='' ){
                            $query->where('celular','like','%'.$celular.'%');
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
                            $query->where('estado','like','%'.$estado.'%');
                        }
                    }
                }
            );
        $result = $sql->orderBy('sede','asc')->paginate(10);
        return $result;
    }

    public static function runLoad2($r)
    {
        $sql=Sede::select('id','sede','direccion','telefono','celular','email')->where('estado','=',1);
        $result = $sql->orderBy('sede','asc')->get();
        return $result;
    }

    public function fileToFile($file, $url)
    {
        if ( !is_dir('img') ) {
            mkdir('img',0777);
        }
        if ( !is_dir('img/sede') ) {
            mkdir('img/sede',0777);
        }
        list($type, $file) = explode(';', $file);
        list(, $type) = explode('/', $type);
        if ($type=='jpeg') $type='jpg';
        if (strpos($type,'document')!==False) $type='docx';
        if (strpos($type, 'sheet') !== False) $type='xlsx';
        if (strpos($type, 'pdf') !== False) $type='pdf';
        if ($type=='plain') $type='txt';
        list(, $file)      = explode(',', $file);
        $file = base64_decode($file);
        file_put_contents($url , $file);
        return $url. $type;
    }
    
    public static function ListSede($r)
    {
        $sql=Sede::select('id','sede','estado')
            ->where('estado','=','1');
        $result = $sql->orderBy('sede','asc')->get();
        return $result;
    }
    
    public static function ListSedeandUsuario($r)
    {
        $sql= PersonaPrivilegioSede::select('s.id','s.sede','s.estado')
            ->join('sedees as s','s.id','=','pps.sede_id')
            ->where('pps.estado','=','1')
            ->where('pps.persona_id','=', Auth::user()->id);
        $result = $sql->orderBy('sede','asc')->get();
        return $result;

    }

    // Export
    public static function runExport($r)
    {
        $rsql= Sede::runLoad2($r);

        $length=array(
            'A'=>15,
            'B'=>15,'C'=>40,'D'=>20,'E'=>20,
            'F'=>30
        );
        $cabecera=array(
            'id','Sede','Direccion','Telefono',
            'Celular','Email'
        );
        $campos=array(
            'id','sede','direccion','telefono',
            'celular','email'
        );

        $r['data']=$rsql;
        $r['cabecera']=$cabecera;
        $r['campos']=$campos;
        $r['length']=$length;
        $r['max']='F'; // Max. Celda en LETRA
        return $r;
    }

}
