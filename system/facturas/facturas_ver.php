<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/facturas/Facturas.php';
include_once 'application/common/Fechas.php';
include_once 'system/asociado/Asociado.php';
$fact = new Facturas(); 

?>

<div id="destino"></div>
<h2 class="h2-responsive">FACTURAS COBRADAS HOY</h2>


<div id="destinoasociado">
   <?php $fact->VerFacturas(date("d-m-Y")); ?>
</div>