<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'application/common/Alerts.php';
include_once 'system/config_configuraciones/Config.php';
include_once 'application/common/Fechas.php';

$config = new Config(); 

?>

<h1>CONFIGURACION DE PRECIOS</h1>


<div class="row">
    <div class="col-md-6 btn-outline-black z-depth-2">
            

  <form id="form-precios">
  
  <div class="form-row">

  <div class="col-md-4 mb-2 md-form">
      <label for="descripcion">Metros</label>
      <input type="text" class="form-control" id="mts" name="mts">
    </div>

    <div class="col-md-4 mb-2 md-form">
      <label for="cod">Mora</label>
      <input type="text" class="form-control" id="mora" name="mora">
    </div>


    <div class="col-md-4 mb-2 md-form">
      <label for="cod">Cuota Minima</label>
      <input type="text" class="form-control" id="cuota_minima" name="cuota_minima">
    </div>
  </div>


  <div class="form-row">
    
    <div class="col-md-6 mb-2 md-form">
      <label for="cod">Reconexion</label>
      <input type="text" class="form-control" id="reconexion" name="reconexion">
    </div>

   <div class="col-md-6 mb-2 md-form">
      <label for="descripcion">Fecha Cobro</label>
      <input placeholder="Seleccione una fecha" type="text" id="fecha" name="fecha" class="form-control datepicker my-0">
    </div>

  </div>


  <div class="form-row">
    <div class="col-md-12 my-2 md-form text-center">
     <button class="btn btn-info my-2" type="submit" id="btn-precios"><i class="fa fa-save mr-1"></i> Guardar</button>

    </div>
  </div>

</form>

<!-- TERMINA FORMULARIO PRINCIPAL -->

    </div>
    
    <div class="col-md-6 btn-outline-black z-depth-2" id="contenido">
          <?php 
           $config->VerPrecios();
         ?>
    </div>
   
</div>  <!-- row -->


