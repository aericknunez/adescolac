<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Fechas.php';
include_once 'system/index/Inicio.php';
include_once 'system/corte/Corte.php';
$cut = new Corte();

include_once 'system/control/Controles.php';
$control = new Controles(); 

echo '<div id="ventana"></div>';

if($cut->UltimaFecha() != date("d-m-Y")){ // comprobacion de corte
	
	include_once 'system/control/control.php';

} else { /// termina comprobacion de corte
	Alerts::CorteEcho("ventas");
}

?>