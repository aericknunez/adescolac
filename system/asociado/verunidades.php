<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/asociado/Asociado.php';
$asociado = new Asociados(); 

?>

<div id="msj"></div>
<h2 class="h2-responsive">CONTADORES REGISTRADOS</h2>


<div id="destinoasociado">
   <?php $asociado->VerTodasLasUnidades(); ?>
</div>


<!-- /// modal ver cleinte -->

<div class="modal" id="ModalVerAsociado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         DETALLES ASOCIADO</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div id="vista"></div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">
<?php  if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>
<a href="" id="btn-pro" class="btn btn-secondary btn-rounded">Modificar Datos</a>
<?php } ?>
<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->




<!-- /// modal ver unidades -->

<div class="modal" id="ModalVerUnidades" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         DATOS LECTURA ACTUAL</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div id="vista_unidad" class="text-center"></div>


<div class="row d-flex justify-content-center">
  <div class="col-md-6">
  <form id="form-addlectura">
  
   <input type="hidden" id="asociado" name="asociado" value="">
    <input type="hidden" id="unidad" name="unidad" value="">


  <div class="form-row">
    
    <div class="col-md-12 mb-2 md-form">
      <label for="unidad">* Nueva Lectura</label>
      <input type="text" class="form-control" id="lectura" name="lectura">
    </div>
</div>


  <div class="form-row">
    <div class="col-md-12 my-2 md-form text-center">
     <button class="btn btn-info my-2" type="submit" id="btn-addlectura"><i class="fa fa-save mr-1"></i> Guardar</button>

    </div>
  </div>

</form>
</div></div>
<div id="resultado"></div>



<!-- ./  content -->
      </div>
      <div class="modal-footer">
<a class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->






<!-- /// modal ver cleinte -->

<div class="modal" id="ModalCambioPrecio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         CAMBIOAR PRECIO A AGUA</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<form id="form-cambioprecio">
  
   <input type="hidden" id="pcontador" name="pcontador" value="">

  <div class="form-row">
    
    <div class="col-md-12 mb-2 md-form">
      <label for="pcantidad">* Precio</label>
      <input type="text" class="form-control" id="pcantidad" name="pcantidad">
    </div>

  </div>



  <div class="form-row">
    <div class="col-md-12 my-2 md-form text-center">
     <button class="btn btn-info my-2" type="submit" id="btn-cambioprecio"><i class="fa fa-save mr-1"></i> Guardar</button>

    </div>
  </div>

</form>


<div id="vista_cambio" class="text-center"></div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">
<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->

