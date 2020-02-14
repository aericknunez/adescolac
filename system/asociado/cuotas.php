<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Fechas.php';
include_once 'application/common/Alerts.php';
include_once 'system/asociado/Asociado.php';
$asociado = new Asociados(); 

?>

<div id="destino"></div>
<h2 class="h2-responsive">LISTADO DE CUOTAS</h2>


<div id="destinoasociado">
   <?php $asociado->VerCuotas(); ?>
</div>


<!-- /// modal ver cleinte -->

<div class="modal" id="ModalPagar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         PAGAR CUOTA</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<?php  if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>
<div id="vista"></div>
<?php } else { Alerts::Mensajex("No se puede realizar esta acci&oacuten!", "danger"); }
 ?>
<!-- ./  content -->
      </div>
      <div class="modal-footer">


<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->

