<?php 
  if($_SERVER['HTTP_REFERER'] == NULL) $dir = "http://". $_SERVER['HTTP_HOST'] . "/adescolac"; else $dir = $_SERVER['HTTP_REFERER'];


if ($_GET["op"] == 1) { /// imprimir listado de cuotas pendientes
	include_once '../../system/asociado/Asociado.php';
    include_once 'Imprime.php';
    $print = new Imprime(); 
    $print->CrearCuotas(); 
}






// if($_GET["op"] == 2){
//     include_once '../../system/asociado/Asociado.php';
//     $asociado = new Asociados(); 
//     echo '<h2 class="h2-responsive">Productos adquiridos por el asociado</h2>';
//     $asociado->VerProductosAsociado($_GET["as"], $_GET["inicio"], $_GET["fin"]);

//     $dir = "http://". $_SERVER['HTTP_HOST'] . "/acamsal/?asociadover";
// }
?>