<div class="modal bounceIn" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          BUSCAR ASOCIADO</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div align="center">
  <div class="col-md-12 z-depth-2 justify-content-center">
      <div class="md-form mt-0">
        <form id="p-busqueda">
        <input class="form-control" type="text" placeholder="Buscar Producto" aria-label="Search" id="key" name="key" autofocus>
        <button class="btn aqua-gradient btn-rounded btn-sm" type="submit" id="btn-busqueda" name="btn-busqueda">Buscar</button>
        </form>
      </div>
  </div>
  <div class="col-md-12 z-depth-2 justify-content-center" id="muestra-busqueda"></div>
</div>

<form id="form-addlectura">
<div align="center">
<div id="contenido"></div>
<div id="formu">
            <div class="form-row">
            <div class="col-md-12 my-2 md-form text-center">
             <button class="btn btn-info my-2" type="submit" id="btn-addlectura"><i class="fa fa-save mr-1"></i> Guardar</button>

            </div>
          </div>
</div>
</div>
</form>
<!-- ./  content -->
      </div>
      <div class="modal-footer">
          <a href="?" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->