<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class Consorcio extends Model
{
    protected   $table = 'm_consorcios';

    public static function runEditStatus($r)
    {
        $consorcio = Consorcio::find($r->id);
        $consorcio->estado = trim( $r->estadof );
        $consorcio->persona_id_updated_at=Auth::user()->id;
        $consorcio->save();
    }

    public static function runNew($r)
    {
        
        $consorcio = new Consorcio;
        $consorcio->consorcio = trim( $r->consorcio );
        $consorcio->consorcio_apocope = trim( $r->consorcio_apocope );
        $consorcio->ruc = trim( $r->ruc );
        $consorcio->estado = trim( $r->estado );
        $consorcio->persona_id_created_at=Auth::user()->id;
        if(trim($r->imagen_nombre)!=''){
        $consorcio->logo=$r->imagen_nombre;
        $este = new Consorcio;
        $url = "img/consorcio/".$r->imagen_nombre; 
        $este->fileToFile($r->imagen_archivo, $url);}
        else {
        $consorcio->logo=null;    
        }
        $consorcio->save();
    }

    public static function runEdit($r)
    {
        $consorcio = Consorcio::find($r->id);
        $consorcio->consorcio = trim( $r->consorcio );
        $consorcio->consorcio_apocope = trim( $r->consorcio_apocope );
        $consorcio->ruc = trim( $r->ruc );
        $consorcio->estado = trim( $r->estado );
        $consorcio->persona_id_updated_at=Auth::user()->id;
        if(trim($r->imagen_nombre)!=''){
            $consorcio->logo=$r->imagen_nombre;
        }else {
            $consorcio->logo=null;    
        }
        if(trim($r->imagen_archivo)!=''){
            $este = new Consorcio;
            $url = "img/consorcio/".$r->imagen_nombre; 
            $este->fileToFile($r->imagen_archivo, $url);
        }
        $consorcio->save();
    }

    public static function runLoad($r)
    {
        $sql=Consorcio::select('id','consorcio_apocope','consorcio','logo','ruc','estado')
            ->where( 
                function($query) use ($r){
                    if( $r->has("consorcio") ){
                        $consorcio=trim($r->consorcio);
                        if( $consorcio !='' ){
                            $query->where('consorcio','like','%'.$consorcio.'%');
                        }
                    }
                    if( $r->has("consorcio_apocope") ){
                        $consorcio_apocope=trim($r->consorcio_apocope);
                        if( $consorcio_apocope !='' ){
                            $query->where('consorcio_apocope','like','%'.$consorcio_apocope.'%');
                        }
                    }
                    if( $r->has("ruc") ){
                        $ruc=trim($r->ruc);
                        if( $ruc !='' ){
                            $query->where('ruc','like',$ruc.'%');
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
        $result = $sql->orderBy('consorcio','asc')->paginate(10);
        return $result;
    }

    public static function runLoad2($r)
    {
        $sql=Consorcio::select('id','sede','direccion','telefono','celular','email')->where('estado','=',1);
        $result = $sql->orderBy('sede','asc')->get();
        return $result;
    }

    public function fileToFile($file, $url)
    {
        if ( !is_dir('img') ) {
            mkdir('img',0777);
        }
        if ( !is_dir('img/consorcio') ) {
            mkdir('img/consorcio',0777);
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
    
    public static function Listconsorcio($r)
    {
        $sql=Consorcio::select('id','consorcio','estado')
            ->where('estado','=','1');
        $result = $sql->orderBy('consorcio','asc')->get();
        return $result;
    }
    
    public static function ListconsorcioandUsuario($r)
    {
        $sql= PersonaPrivilegioconsorcio::select('s.id','s.sede','s.estado')
            ->join('sedees as s','s.id','=','pps.sede_id')
            ->where('pps.estado','=','1')
            ->where('pps.persona_id','=', Auth::user()->id);
        $result = $sql->orderBy('sede','asc')->get();
        return $result;

    }

    // Export
    public static function runExport($r)
    {
        $rsql= Consorcio::runLoad2($r);

        $length=array(
            'A'=>15,
            'B'=>15,'C'=>40,'D'=>20,'E'=>20,
            'F'=>30
        );
        $cabecera=array(
            'id','consorcio','Direccion','Telefono',
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
