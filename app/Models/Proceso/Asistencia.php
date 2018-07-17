<?php

namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Proceso\AsistenciaMarcacion;
use App\Models\Proceso\AsistenciaHistorico;
use App\Models\Proceso\EventoAsistencia;
use Auth;


DEFINE('MARCA_INGRESO',0);
DEFINE('MARCA_SALIDA',1);
DEFINE('TARDANZA',2);
DEFINE('A_TIEMPO',1);
DEFINE('FALTA',3);

DEFINE('CAMBIA_AMBAS',0);
DEFINE('CAMBIA_INGRESO',1);
DEFINE('CAMBIA_SALIDA',2);
DEFINE('EVENTO_CON_RETORNO',3);


class Asistencia extends Model{
    
    protected   $table = 'p_asistencias';

    public static function Marcacion( $r ){

        if(isset($r->fecha) && isset($r->hora)){
            $caso = new Casuistica($r->dni,$r->fecha,$r->hora);
        }else{
            $caso = new Casuistica($r->dni);
        }

        $updatedOrAddeded = false;
        $guardarEventoAsistencia = false;

        if($caso->contratoActivo === false){

            $return['rst']='2';
            $return['tittle'] = 'Información!!';
            $return['type'] = 'warning';
            $return['msj']='Ud no cuenta con un contrato activo.';

            return $return;
        }


        $return['rst'] = 1;
        $return['tittle'] = 'Gracias!!';
        $return['type'] = 'success';
        $return['msj'] = 'Se registró correctamente';

        $log ="";
        DB::beginTransaction();;    

        if($caso->estadoAsistencia()==MARCA_INGRESO && $amanecida = $caso->reglaAmanecida()){ // NO TIENE ASISTENCIA.   
            
            if($amanecida === 2 && !$caso->tieneEvento(array(CAMBIA_AMBAS,CAMBIA_INGRESO))){

                $return['rst']='2';
                $return['tittle'] = 'Información!!';
                $return['type'] = 'warning';
                
                $horaEntrada = $caso->vDate("H:i:s",strtotime($caso->horarioprogramado->hora_inicio.' -1 hour'));

                $return['msj']="La hora actual ({$caso->horahoy}) no corresponde a la hora de entrada ({$horaEntrada}).";

            }else{

                $asistencia = new Asistencia;
                $asistencia['horario_programado_id'] = $caso->horarioprogramado->id;
                $asistencia['total_hora_tardanza']=0;
                $asistencia['persona_contrato_id']=$caso->contratoActivo;
                $asistencia['persona_id_created_at']=Auth::user()->id;
                
                $updatedOrAddeded=true;

                $log.=" :NO TIENE ASISTENCIA: ";

                if($caso->tieneEvento( array(0,1,2))){
                    $guardarEventoAsistencia = true;
                    $log.=" :TIENE EVENTO: ";
                    // GUARDAR ASISTENCIA, Y ACTUALIZAR EVENTO
                    $log.=" :EVENTO TIPO {$caso->eventoActivo->aplica_cambio}: ";
                    
                    if($caso->eventoActivo->aplica_cambio == CAMBIA_AMBAS){
                        //APLICA A INRESO Y SALIDA.

                        $asistencia->fecha_ingreso=$caso->eventoActivo->fecha_inicio;
                        $asistencia->hora_ingreso=$caso->eventoActivo->hora_inicio;
                    
                        $asistencia->fecha_salida=$caso->eventoActivo->fecha_fin;
                        $asistencia->hora_salida=$caso->eventoActivo->hora_fin;

                    }elseif($caso->eventoActivo->aplica_cambio == CAMBIA_INGRESO){
                        //APLICA AL INGRESO.

                            $asistencia->fecha_ingreso=$caso->eventoActivo->fecha_inicio;
                            $asistencia->hora_ingreso=$caso->eventoActivo->hora_inicio;
                        
                    }elseif($caso->eventoActivo->aplica_cambio == CAMBIA_SALIDA){
                        //APLICA A LA SALIDA.
                            $asistencia->fecha_salida=$caso->eventoActivo->fecha_fin;
                            $asistencia->hora_salida=$caso->eventoActivo->hora_fin;
                        
                    }

                    $updatedOrAddeded=true;


                }else{
                    $log .= " :NO TIENE EVENTO: ";
                    $tiempoMarcado = $caso->tiempoMarcado();
                    $updatedOrAddeded=true;
                    $asistencia->fecha_ingreso=$caso->fechahoy;
                    $asistencia->hora_ingreso=$caso->horahoy;
                    if($tiempoMarcado == A_TIEMPO){
                        //MARCO A TIEMPO
                        $log .= " :IN TIME: ";
                        $asistencia->asistencia_estado_ini=0;
                        $asistencia->asistencia_estado_fin=0;

                    }elseif($tiempoMarcado == TARDANZA){
                        //MARCO CON TARDANZA
                        $log .= " :LITTLE LATE: ";
                        $asistencia->asistencia_estado_ini=1;
                        $asistencia->asistencia_estado_fin=1;
                        $asistencia->total_hora_tardanza=$caso->tardanza;
                    }elseif($tiempoMarcado == FALTA){
                        //MARCO CON FALTA
                        $log .= " :TOO LATE: ";
                        $asistencia->asistencia_estado_ini=2;
                        $asistencia->asistencia_estado_fin=2;
                        $asistencia->total_hora_tardanza=$caso->tardanza;
                    }
                }
            }

        }elseif($caso->estadoAsistencia()==MARCA_SALIDA){ // ENTRADA MARCADA
            //var_dump($caso);
            
            $mTiempo = $caso->totalHoras();
            $asistencia = Asistencia::find($caso->asistenciaActivo);
            
            $log .= " :YA HA MARCADO: ";

            if($caso->tieneEvento(array(0,2,3))){
                $guardarEventoAsistencia = true;
               $log .= " : TIENE EVENTO SALIDA : ";
                // ACTUALIZAR EVENTO
               
                    if($caso->eventoActivo->aplica_cambio == CAMBIA_AMBAS){
                        $log .= " :SALIENDO TEMPRANO [AMBAS]: ";
                        
/*************************************************************************************************************/
/*************************************************************************************************************/
/*************************************************************************************************************/
                        //APLICA A LA SALIDA.
                        $asistencia->fecha_salida=$caso->fechahoy;
                        $asistencia->hora_salida=$caso->horahoy;
                        $asistencia->total_hora=$mTiempo;
                        $asistencia->asistencia_estado_fin=0;
                        $updatedOrAddeded=true;

/*************************************************************************************************************/
/*************************************************************************************************************/
/*************************************************************************************************************/



                    }elseif($caso->eventoActivo->aplica_cambio == CAMBIA_SALIDA){
                        $log .= " :SALIENDO TEMPRANO [SALIDA]: ";
                        //APLICA A LA SALIDA.

                        $asistencia->fecha_salida=$caso->eventoActivo->fecha_fin;
                        $asistencia->hora_salida=$caso->eventoActivo->hora_fin;
                        
                        $asistencia->total_hora=$caso->totalHoras($caso->eventoActivo->fecha_fin.' '.$caso->eventoActivo->hora_fin);
                        $asistencia->asistencia_estado_fin=0;
                        $updatedOrAddeded=true;
                    }elseif($caso->eventoActivo->aplica_cambio == EVENTO_CON_RETORNO){

                        if($caso->eventoActivo->ini_marcado==NULL){
                            $log .= " :SALIENDO CON PAPELETA CON RETORNO: ";
                        }else{
                            $log .= " :ENTRANDO CON PAPELETA CON RETORNO: ";
                        }

                    }
            }else{ 
                $log .= " :NO EVENT: ";

                if( $asistencia->asistencia_estado_ini == 3){
                    
                    $log .= " :ACTUALIZANDO: ";

                    $tiempoMarcado = $caso->tiempoMarcado();
                    $updatedOrAddeded=true;
                    $asistencia->fecha_ingreso=$caso->fechahoy;
                    $asistencia->hora_ingreso=$caso->horahoy;
                    $asistencia->horario_programado_id = $caso->horarioprogramado->id;

                    if($tiempoMarcado == A_TIEMPO){
                        //MARCO A TIEMPO
                        $log .= " :IN TIME: ";
                        $asistencia->asistencia_estado_ini=0;

                    }elseif($tiempoMarcado == TARDANZA){
                        //MARCO CON TARDANZA
                        $log .= " :LITTLE LATE: ";
                        $asistencia->asistencia_estado_ini=1;
                        $asistencia->total_hora_tardanza=$caso->tardanza;
                    }elseif($tiempoMarcado == FALTA){
                        //MARCO CON FALTA
                        $log .= " :TOO LATE: ";
                        $asistencia->asistencia_estado_ini=2;
                        $asistencia->total_hora_tardanza=$caso->tardanza;

                    }

                }elseif($caso->horaSalida()){

                    if($asistencia->hora_salida == NULL || $asistencia->hora_salida == ''){

                        $log .= " :SALIENDO: ";
                        $asistencia->fecha_salida=$caso->fechahoy;
                        $asistencia->hora_salida=$caso->horahoy;
                        $asistencia->asistencia_estado_fin=$asistencia->asistencia_estado_ini;
                        $asistencia->total_hora = $caso->totalHora;

                        $updatedOrAddeded=true;

                    }else{

                        $log .= " :MARCADA DE NUEVO LA SALIDA: ";

                    }
                }else{
                    if($asistencia->hora_salida == NULL){
                        $log.=" :NO SE SALE AÚN: ";
                    }else{
                        $log.=" :REMARCANDO SALIDA: ";
                    }
                }
            }

        }elseif($caso->estadoAsistencia()==-1){ // NO TIENE HORARIO ASIGNADO
            $log .= " SIN HORARIO PROGRAMADO PRAR EL DÍA: ";

           
            if($caso->asistenciaAux !== false){

                $asistencia= new Asistencia;
                $asistencia['persona_contrato_id']=$caso->contratoActivo;
                $asistencia['fecha_ingreso']=$caso->fechahoy;
                $asistencia['hora_ingreso']=$caso->horahoy;
                $total_hora_tardanza=0;
                $asistencia['total_hora_tardanza']=$total_hora_tardanza;
                $asistencia['asistencia_estado_ini']=3; // CANCELADO
                $asistencia['asistencia_estado_fin']=3; // CANCELADO
                $asistencia['persona_id_created_at']=Auth::user()->id;
                $updatedOrAddeded=true;

            }else{

                $asistencia = Asistencia::find($caso->asistenciaActivo);

            }

            $return['rst']='2';
            $return['tittle'] = 'Información!!';
            $return['type'] = 'warning';
            $return['msj']='Ud no cuenta con el horario programado para el día de hoy';


        }


        if($caso->reglaAmanecida() !== 2 || $caso->tieneEvento(array(CAMBIA_INGRESO,CAMBIA_AMBAS))){
                $asistencia->save();
        }

        if($guardarEventoAsistencia){
            $log.=" - UE++ ";
            if($caso->updateEvent()){
                $log.=" - EA++ ";
                $eventoasistencia= new EventoAsistencia;
                $eventoasistencia['asistencia_id']=$asistencia->id;
                $eventoasistencia['evento_id']=$caso->eventoActivo->id;
                $eventoasistencia['persona_id_created_at']=Auth::user()->id;
                $eventoasistencia->save();
            }

        }

        if($updatedOrAddeded){
            $log.=" - AH++ ";
            $asistenciahistorico = new AsistenciaHistorico;
            $asistenciahistorico['asistencia_id']=$asistencia->id;
            $asistenciahistorico['persona_contrato_id']=$asistencia->persona_contrato_id;
            $asistenciahistorico['horario_programado_id']=$asistencia->horario_programado_id;
            $asistenciahistorico['fecha_ingreso']=$asistencia->fecha_ingreso;
            $asistenciahistorico['fecha_salida']=$asistencia->fecha_salida;
            $asistenciahistorico['hora_ingreso']=$asistencia->hora_ingreso;
            $asistenciahistorico['hora_salida']=$asistencia->hora_salida;
            $asistenciahistorico['total_hora_tardanza']=$asistencia->total_hora_tardanza;
            $asistenciahistorico['total_hora']=$asistencia->total_hora;
            $asistenciahistorico['asistencia_estado_ini']=$asistencia->asistencia_estado_ini;
            $asistenciahistorico['asistencia_estado_fin']=$asistencia->asistencia_estado_fin;
            $asistenciahistorico['persona_id_created_at']=Auth::user()->id;
            $asistenciahistorico->save();
        }

        $asistenciamarcacion = new AsistenciaMarcacion;
        $asistenciamarcacion['asistencia_id']= isset($asistencia->id) ? $asistencia->id : null ;
        $asistenciamarcacion['persona_contrato_id']=$caso->contratoActivo;
        $asistenciamarcacion['fecha_marcada']=$caso->fechahoy;
        $asistenciamarcacion['hora_marcada']=$caso->horahoy;
        $asistenciamarcacion['persona_id_created_at']=Auth::user()->id;
        $asistenciamarcacion->save();

        
        $return['msj'] .= $log;

        DB::commit();

        return $return;
    }
    





    public static function runLoadAsistencia($r){
        
        $sql= Asistencia::select('p_asistencias.id','p_asistencias.fecha_ingreso','p_asistencias.hora_ingreso','p_asistencias.fecha_salida','p_asistencias.hora_salida','pea.id as evento_asistencia_id')
            ->leftjoin("p_eventos_asistencias as pea","pea.asistencia_id","=","p_asistencias.id")
            ->where('p_asistencias.asistencia_estado_fin','!=',2)
            ->where(
                function($query) use ($r){
                    if( $r->has("fecha") ){
                        $fecha=trim($r->fecha);
                        if( $fecha !='' ){
                            $query->where('p_asistencias.fecha_ingreso','=',$fecha);
                        }
                    }
                    if( $r->has("persona_contrato_id") ){
                        $persona_contrato_id=trim($r->persona_contrato_id);
                        if( $persona_contrato_id !='' ){
                            $query->where('p_asistencias.persona_contrato_id','=',$persona_contrato_id);
                        }
                    }
                    if( $r->has("estado") ){
                        $estado=trim($r->estado);
                        if( $estado !='' ){
                            $query->where('p_asistencias.estado','=',$estado);
                        }
                    }
                    if( $r->has("fecha_ingreso") ){
                        $fecha_ingreso=trim($r->fecha_ingreso);
                        if( $fecha_ingreso !='' ){
                            $query->where('p_asistencias.fecha_ingreso','like','%'.$fecha_ingreso.'%');
                        }
                    }
                    if( $r->has("hora_ingreso") ){
                        $hora_ingreso=trim($r->hora_ingreso);
                        if( $hora_ingreso !='' ){
                            $query->where('p_asistencias.hora_ingreso','like','%'.$hora_ingreso.'%');
                        }
                    }
                    if( $r->has("fecha_salida") ){
                        $fecha_salida=trim($r->fecha_salida);
                        if( $fecha_salida !='' ){
                            $query->where('p_asistencias.fecha_salida','like','%'.$fecha_salida.'%');
                        }
                    }
                    if( $r->has("hora_salida") ){
                        $hora_salida=trim($r->hora_salida);
                        if( $hora_salida !='' ){
                            $query->where('p_asistencias.hora_salida','like','%'.$hora_salida.'%');
                        }
                    }
                }
            );
        $result = $sql->orderBy('p_asistencias.fecha_ingreso','asc')
                      ->groupBy('p_asistencias.id','p_asistencias.fecha_ingreso','p_asistencias.hora_ingreso','p_asistencias.fecha_salida','p_asistencias.hora_salida','pea.id')->paginate(10);
        return $result;
    }
    
    public static function runEdit($r)
    {
        $asistencia = Asistencia::find($r->id);
        // $asistencia->fecha_ingreso = trim( $r->fecha_ingreso );
        $asistencia->fecha_salida = trim( $r->fecha_salida );
        $asistencia->hora_ingreso = trim( $r->hora_ingreso );
        $asistencia->hora_salida = trim( $r->hora_salida );
        $asistencia->persona_id_updated_at=Auth::user()->id;
        $asistencia->save();
 
    }

    public static function runNew($r)
    {

        $asistencia = new Asistencia;
        $asistencia->fecha_ingreso = trim( $r->fecha_ingreso );
        $asistencia->fecha_salida = trim( $r->fecha_salida );
        $asistencia->hora_ingreso = trim( $r->hora_ingreso );
        $asistencia->hora_salida = trim( $r->hora_salida );
        $asistencia->persona_contrato_id = trim( $r->persona_contrato_id );
        $asistencia->horario_programado_id = trim( 1 );
        $asistencia->persona_id_created_at=Auth::user()->id;
        $asistencia->save();

    }
    
}











Class Casuistica{

    public $DNI;

    private $contrato;

    private $asistencia;

    private $evento;

    public $horarioprogramado;

    public $fechahoy;

    public $fechaayer;

    public $horahoy;

    public $diahoy;

    public $tardanza;

    public $eventoActivo;

    public $asistenciaActivo;

    public $contratoActivo;

    public $asistenciaAux;

    public $totalHora;

    private $fechaHorario;

    private $emularFecha;

    private $emuTime;


    public function __construct($DNI,$fechaH=null, $horaH=null){
        
        if($fechaH!=null && $horaH !=null){
            $this->emularFecha = true;
            $this->emuTime = trim($fechaH).' '.trim($horaH);
        }else{
            $this->emularFecha = false;
            $this->emuTime = date("Y-m-d H:i:s");
        }

        $this->asistenciaAux = true;
        $this->DNI = $DNI;
        $this->fechahoy = $this->vDate("Y-m-d");
        $this->horahoy = $this->vDate("H:i:s");
        $this->fechaayer=$this->vDate("Y-m-d",strtotime("-1 day"));
        $this->diahoy=$this->vDate("N");
        $this->diaAyer=$this->vDate("N",strtotime("-1 day"));
        $this->fechaHorario=$this->vDate("Y-m-d");


        $this->contrato=
        DB::table('p_personas_contratos AS ppc')
        ->join('m_personas AS mp',function($join){
            $join->on('mp.id','=','ppc.persona_id');
        })
        ->select('ppc.id')
        ->where('mp.dni',$DNI)
        ->first();

        if( count($this->contrato)>0 ){

            $this->contratoActivo=$this->contrato->id;

            $this->horarioprogramado = DB::table('p_horarios_programados AS php')
            ->select('php.id','php.hora_inicio','php.hora_fin','php.horario_amanecida','php.tolerancia','php.dia_id')
            ->where('php.persona_contrato_id',$this->contrato->id)
            ->where('php.dia_id',$this->diahoy)
            ->where('php.estado',1)
            ->first();

            $hpAux = DB::table('p_horarios_programados AS php')
            ->select('php.id','php.hora_inicio','php.hora_fin','php.horario_amanecida','php.tolerancia','php.dia_id')
            ->where('php.persona_contrato_id',$this->contrato->id)
            ->where('php.dia_id',$this->diaAyer)
            ->where('php.estado',1)
            ->first();

            $this->asistencia = DB::table('p_asistencias AS pa')
            ->select('pa.id','pa.fecha_ingreso','pa.fecha_salida','asistencia_estado_fin','asistencia_estado_ini','persona_contrato_id','horario_programado_id','hora_ingreso','hora_salida','fecha_salida','total_hora_tardanza','total_hora')
            ->where('pa.persona_contrato_id',$this->contrato->id)
            ->where('pa.fecha_ingreso','>=',$this->fechaayer)
            ->where('pa.estado',1)
            ->orderBy('pa.fecha_ingreso','DESC')
            ->first();


            if(count($hpAux)>0 && $hpAux->horario_amanecida == 1){

                    if($this->compararFechasHoras($hpAux->hora_fin,$this->horahoy)){
                        $this->horarioprogramado = $hpAux;
                        $this->fechaHorario = $this->fechaayer;
                    }

            }

            if(count($this->asistencia)>0 && $this->asistencia->fecha_ingreso == $this->fechaHorario && count($hpAux)>0 && $hpAux->horario_amanecida == 1 && $this->asistencia->fecha_salida != NULL && trim($this->asistencia->fecha_salida) != ''){
                
                if($this->vTtime() >= strtotime($this->fechaHorario.' '.$this->horarioprogramado->hora_inicio." -1 hour")){                
                    $this->asistencia = DB::table('p_asistencias AS pa')
                    ->select('pa.id','pa.fecha_ingreso','pa.fecha_salida','asistencia_estado_fin','asistencia_estado_ini','persona_contrato_id','horario_programado_id','hora_ingreso','hora_salida','fecha_salida','total_hora_tardanza','total_hora')
                    ->where('pa.persona_contrato_id',$this->contrato->id)
                    ->where('pa.fecha_ingreso','=',$this->fechahoy)
                    ->whereNull('pa.fecha_salida')
                    ->where('pa.estado',1)
                    ->orderBy('pa.fecha_ingreso','DESC')
                    ->first();
                }

            }




            if(count($hpAux)>0)unset($hpAux);


            if(count($this->asistencia)>0 && $this->asistencia->fecha_ingreso == $this->fechaayer && count($this->horarioprogramado)>0 && $this->horarioprogramado->horario_amanecida==1 && ($this->asistencia->fecha_salida == NULL || $this->asistencia->fecha_salida == '')){
                $this->horarioprogramado = DB::table('p_horarios_programados AS php')
                ->select('php.id','php.hora_inicio','php.hora_fin','php.horario_amanecida','php.tolerancia','php.dia_id')
                ->where('php.persona_contrato_id',$this->contrato->id)
                ->where('php.dia_id',$this->diaAyer)
                ->where('php.horario_amanecida',1)
                ->where('php.estado',1)
                ->first();
                $this->fechaHorario = $this->fechaayer;
            }
            
            if($this->horarioprogramado->horario_amanecida == 1 && count($this->asistencia)>0 && ($this->asistencia->fecha_salida != NULL || trim($this->asistencia->fecha_salida) != '')){
                $this->asistencia=null;
            }

            $this->evento = DB::table('p_eventos AS pe')
            ->join('m_eventos_tipos AS met',function($join){
                $join->on('met.id','=','pe.evento_tipo_id');
            })->leftJoin('p_eventos_asistencias AS pea',function($join){
                $join->on('pea.evento_id','=','pe.id')
                ->where('pea.estado',1);
            })->select('pe.id','met.aplica_cambio','pe.fecha_inicio','pe.fecha_fin','pe.hora_inicio','pe.hora_fin','pe.ini_marcado','pe.fin_marcado')
            ->where('pe.persona_contrato_id',$this->contrato->id)
            ->where('pe.estado',1)
            ->where('met.aplica_cambio','>',0)
            //->whereRaw('\''.$this->fechahoy.'\' BETWEEN pe.fecha_inicio AND pe.fecha_fin ',1)
            ->whereNull('pea.id')
            ->get();




//            $this->full_var_dump();
//            die();


        }else{
            $this->contratoActivo = false;
        }

        //echo "Construct ends.";
    }

    public function tieneEvento($mode=array()){
        if( count($this->evento)>0){ //Tiene eventos.
            //EVENTOS DE HOY.
            $mas_cercano = 999999999999;
            $mEvento;
            $true = false;
            foreach ($this->evento as $e){
                if($e->fecha_inicio == $this->fechaHorario || $e->fecha_inicio == $this->fechahoy){
                    $difEvent=strtotime($this->fechahoy.' '.$this->horahoy)-strtotime($this->fechaHorario.' '.$e->hora_inicio);
                    if($difEvent<$mas_cercano){
                        if(count($mode)==0 || (count($mode)>0 && in_array($e->aplica_cambio, $mode))){
                            $this->eventoActivo = $e;
                            $mas_cercano=$difEvent;
                            $true = true;
                        }
                    }
                }
            }   
            return $true;
        }else{
            return false;
        }
    } 

    public function estadoAsistencia(){


        if(count($this->horarioprogramado)==0){
            if(count($this->asistencia)>0){$this->asistenciaActivo = $this->asistencia->id;$this->asistenciaAux = false;}
            return -1; // NO TIENE HORARIO ASIGNADO.
        }

        if($this->asistencia != NULL && $this->asistencia->fecha_ingreso==$this->fechahoy && $this->horarioprogramado->horario_amanecida==0){
            $this->asistenciaActivo = $this->asistencia->id;
            return MARCA_SALIDA; // ENTRO, NO HA SALIDO - HORARIO REGULAR

        }elseif($this->horarioprogramado->horario_amanecida==1 && count($this->asistencia)>0 && ($this->asistencia->fecha_ingreso==$this->fechaayer || $this->asistencia->fecha_ingreso==$this->fechahoy)){
            $this->asistenciaActivo = $this->asistencia->id;
            return MARCA_SALIDA; // ENTRO, NO HA SALIDO - HORARIO REGULAR
        }else{
            // NO HA ENTRADO.
            return MARCA_INGRESO;
        }
    }


    public function tiempoMarcado(){
        //var_dump($this->horarioprogramado);

        if($this->compararFechasHoras($this->fechahoy.' '.$this->horahoy,$this->fechaHorario.' '.$this->horarioprogramado->hora_inicio)){
            // TARDANZA O FALTA
            
            $tolerado=$this->vDate("Y-m-d H:i:s",strtotime($this->fechaHorario.' '.$this->horarioprogramado->hora_inicio.' +'.$this->horarioprogramado->tolerancia.' minutes') );
            
            $hhoy = $this->vTime(); // UNIX TIME.
            $hini = strtotime($this->fechaHorario . " " . $this->horarioprogramado->hora_inicio);

            $secs = $hhoy-$hini;

            if($this->compararFechasHoras($this->fechahoy.' '.$this->horahoy,$tolerado)){
                $this->tardanza= $this->timeFormat($secs);
                return FALTA; // FALTA, ENTRO FUERA DE HORA.
            }else{
                $this->tardanza= $this->timeFormat($secs);
                return TARDANZA; // ENTRA CON TARDANZA
            }
        }else{
            // JUST IN TIME.  
            return A_TIEMPO;  
        }

    }

    public function horaSalida(){

        if($this->compararFechasHoras($this->horahoy,$this->horarioprogramado->hora_fin) && $this->horarioprogramado->horario_amanecida == 0){
            $secs = $this->vTime()-strtotime($this->asistencia->fecha_ingreso .' '. $this->asistencia->hora_ingreso);
            $this->totalHora = $this->timeFormat($secs);
            return true;
        }elseif($this->horarioprogramado->horario_amanecida == 1){
            
            if($this->horarioprogramado->dia_id == $this->diahoy){
                return false;
            }elseif($this->compararFechasHoras($this->fechahoy.' '.$this->horahoy,$this->fechahoy.' '.$this->horarioprogramado->hora_fin)){
                $secs = $this->vTime()-strtotime($this->asistencia->fecha_ingreso .' '. $this->asistencia->hora_ingreso);
                $this->totalHora = $this->timeFormat($secs);
                return true;
            }
        }else{
            return false;
        }
    }

    public function totalHoras($salida = null){

        $secs = ($salida==null?$this->vTime():strtotime($salida))-strtotime($this->asistencia->fecha_ingreso .' '. $this->asistencia->hora_ingreso);

        return $this->timeFormat($secs);;
    }

    public function reglaAmanecida(){ 
        if(count($this->horarioprogramado)>0 && $this->horarioprogramado->horario_amanecida == 1){
           if(count($this->asistencia)==0 && $this->vTime()<strtotime($this->fechahoy.' '.$this->horarioprogramado->hora_inicio." -1 hour")){
                return 2;
            }else{
                return ($this->vTime() >= strtotime($this->fechaHorario.' '.$this->horarioprogramado->hora_inicio." -1 hour")?true:false);
            }
        }else{
            return true;
        }
    }

    public function updateEvent(){
            $evt = Evento::find($this->eventoActivo->id);

            if($this->eventoActivo->ini_marcado == NULL || trim($this->eventoActivo->ini_marcado) == ''){
                $evt['ini_marcado'] = $this->fechahoy . ' ' . $this->horahoy;
                $evt->save();

                if($this->eventoActivo->aplica_cambio == 3){
                    return false;
                }else{
                    return true;
                }

            }elseif($this->eventoActivo->aplica_cambio == 3 && ($this->eventoActivo->fin_marcado == NULL || trim($this->eventoActivo->fin_marcado) == '') ){
                $evt['fin_marcado'] = $this->fechahoy . ' ' . $this->horahoy;
                $evt->save();
                return true;

            }else{
                return false; 
            }                
            

    }

/**********************************************************************
**********************ETC FUNCTIONS************************************
**********************************************************************/
    private function compararFechasHoras($d1,$d2){
        if(strtotime($d1)>strtotime($d2)) {
            return true;
        } else {
            return false;
        }
    }    

    private function vDate($param1=null,$param2=null){
        if($param2!=null){
            if($this->emularFecha === true){
                $nowEmuTime = time() - $param2;
                return date($param1,strtotime($this->emuTime)+$nowEmuTime);
            }else{
                return date($param1,$param2);
            }
        }elseif($param1!=null){
            return $this->emularFecha === true ? date($param1, strtotime($this->emuTime)) : date($param1);
        }else{
            return date();
        }
    }

    private function vTime(){
        if($this->emularFecha === true){
            return strtotime($this->emuTime);
        }else{
            return time();
        }
    }

    public function timeFormat($seconds){
        $seconds *= ($seconds>=0 ? 1 : -1);
        return sprintf('%02d:%02d:%02d', floor($seconds / 3600), floor($seconds / 60 % 60), floor($seconds % 60));
    }

    public function full_var_dump(){
        echo "<pre>";
        echo "  Contrato: ";var_dump($this->contrato);echo "\r\n";
        echo "  Asistencia: ";var_dump($this->asistencia);echo "\r\n";
        echo "  Eventos: ";var_dump($this->evento);echo "\r\n";
        echo "  Horario: ";var_dump($this->horarioprogramado);echo "\r\n";
        echo "</pre>";
    }

}