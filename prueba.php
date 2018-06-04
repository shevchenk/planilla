<?php 
$tol=10;
$horahoy=date("H:i:s");
$diahoy=date("N");
$hora_inicio=date("H:i:s",strtotime($horahoy.' -3 minutes' ));
$tolerancia=date("H:i:s",strtotime($hora_inicio.' +'.$tol.' minutes' ));
$dif= strtotime($horahoy)-strtotime($hora_inicio);
echo $dif."<br>";
$total_hora_tardanza=date("H:i:s",strtotime($horahoy." -".strtotime($hora_inicio)." seconds") );

echo $hora_inicio; echo "<hr>";
echo $horahoy; echo "<hr>";
echo $tolerancia; echo "<hr>";
echo $total_hora_tardanza;
?>
