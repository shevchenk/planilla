<?php 
$tol=10;
$fechahoy=date("Y-m-d");
$fechaayer=date("Y-m-d",strtotime("-1 day"));
$horahoy=date("H:i:s");
$diahoy=date("N");
$diaayer=date("N",strtotime("-1 day"));
$hora_inicio=date("H:i:s",strtotime($horahoy.' -3 minutes' ));
$tolerancia=date("H:i:s",strtotime($hora_inicio.' +'.$tol.' minutes' ));
$dif= strtotime($horahoy)-strtotime($hora_inicio);
echo $dif."<br>";
$total_hora_tardanza=date("H:i:s",strtotime($horahoy." -".strtotime($hora_inicio)." seconds") );

echo $fechahoy." | ".$diahoy; echo "<hr>";
echo $fechaayer." | ".$diaayer; echo "<hr>";
echo $hora_inicio; echo "<hr>";
echo $horahoy; echo "<hr>";
echo $tolerancia; echo "<hr>";
echo $total_hora_tardanza;
?>
