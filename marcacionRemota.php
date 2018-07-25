<?php

define('MySQL_U', 'root');
define('MySQL_P', '');
define('MySQL_S', '192.157.30.234'); // set to localhost
define('MySQL_DB', 'DATA_PRIN');

function getData($qry,$conexion, $allField=false){  
        if ($result = $conexion->query($qry)) {
                if($result->num_rows > 0){
                        $akey = 0;
                        while($row = ($allField?$result->fetch_assoc():$result->fetch_row()))
                        {
                                $keys = array_keys($row);
                                if($allField && isset($row['id'])){
                                        $index = $row['id'];
                                }elseif($allField){
                                        $index = $akey++;
                                }else{
                                        if(isset($row[$keys[0]])) 
                                                $index = $row[$keys[0]];
                                        //unset($row[0]);
                                }

                                if($allField){
                                        foreach ($row as $key => $value) {
                                                $rec[$key] = $value;
                                        }
                                }else{
                                        $rec = $row[1];
                                }
                                $data[$index] = $rec;            
                        }
                }else{
                        return false;
                }
            $result->close();
        }else{
                return false;
        }
        return $data;
}


if(!$conexion = mysqli_connect(MySQL_S, MySQL_U, MySQL_P)) {

        die("Ha ocurrido un error al conectar a la base de datos.");
}


$conexion->select_db(MySQL_DB);

$qry = "SELECT * FROM `REG_SEDE_LINCE` WHERE estado = 0";

$marcaciones = getData($qry,$conexion,true);

if(is_array($marcaciones))foreach ($marcaciones as $marca) {
    $DNI = $marca['DNI'];
    $fecha = $marca['FECHA'];
    $hora = $marca['HORA'];
    //var_dump($marca);
    if($conexion->query("UPDATE `REG_SEDE_LINCE` SET estado=1 WHERE DNI='$DNI' AND FECHA='$fecha' AND HORA='$hora' LIMIT 1;")===true){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://veflat.local/planilla/public/marcacionRemota");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"hora=$hora&fecha=$fecha&dni=$DNI&mkSess=1");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec ($ch);

        curl_close ($ch);

        echo "http://veflat.local/planilla/public/AjaxDinamic/Proceso.MarcacionPR@Marcacion".$result;
        

    }else{
        echo "0.";
    }

}

echo ":END";
