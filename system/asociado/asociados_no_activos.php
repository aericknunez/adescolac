<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Fechas.php';
include_once 'application/common/Alerts.php';
include_once 'system/asociado/Asociado.php';
$asociado = new Asociados(); 

?>

<div id="destino"></div>
<h2 class="h2-responsive">CUOTAS FIJAS</h2>


<div id="destinoasociado">
   <?php $asociado->AsociadosNoActivos(); ?>
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


<a href="" id="btn-pro" class="btn btn-secondary btn-rounded">Modificar Datos</a>
<a id="btn-cuotas-fijas" op="194" key="" class="btn btn-info btn-rounded">Pagar cuotas</a>
<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->



<!-- MODAL PARA CONFIRMAR ELIMINACION -->

<div class="modal fade" id="ConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <p class="heading">Seguro que desea eliminar este elemento?</p>
      </div>

      <!--Body-->
      <div class="modal-body">
<p>ADVERTENCIA!! Al elimiar un asociado tambi&eacuten se eliminar&aacute toda la informaci&oacuten relacionada a &eacuteste permenentemente.</p>
        <i class="fas fa-times fa-4x animated rotateIn"></i>

<p>Desea continuar?</p>
      </div>

      <!--Footer-->
      <div class="modal-footer flex-center">
        <a id="delasociado" class="btn  btn-outline-danger">Eliminar</a>
        <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalConfirmDelete-->



<!-- /// modal ver cleinte -->

<div class="modal" id="ModalCuotasFijas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         PAGAR CUOTAS</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 3) {  ?>
<div id="vista-unidades"></div>

<?php } else {
  Alerts::Mensajex("No tienes permisos para estar aqui","danger");
} ?>
<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->




