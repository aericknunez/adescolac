<?php 
class Search{

		public function __construct() { 
     	} 


  public function Busqueda($dato){ // Busqueda para busqueda lenta
    $db = new dbConn();
      if($dato["keyword"] != NULL){
             $a = $db->query("SELECT asociados.nombre, asociados.hash, asociados_unidades.unidad FROM asociados 
              INNER JOIN asociados_unidades on asociados.hash = asociados_unidades.asociado 
              WHERE asociados_unidades.unidad like '%".$dato["keyword"]."%' or asociados.nombre like '%".$dato["keyword"]."%' and asociados_unidades.td = ".$_SESSION["td"]." limit 10");
                if($a->num_rows > 0){
                    echo '<table class="table table-striped table-sm table-hover">';
            foreach ($a as $b) {
                       echo '<tr>
                              <td scope="row"><a id="select-p" op="51" key="'. $b["hash"] .'" unidad="'. $b["unidad"] .'">
                              '. $b["unidad"] .'  || '. $b["nombre"] .'</a></td>
                            </tr>'; 
            }  
                        echo '<tr>
                              <td scope="row"><a id="cancel-p">CANCELAR</a></td>
                            </tr>'; 
                $a->close();

                
              } else {
                 echo '<table class="table table-sm table-hover">';
                    echo '<tr>
                              <td scope="row">El criterio de busqueda no corresponde a un producto</td>
                            </tr>';
                    echo '<tr>
                              <td scope="row"><a id="cancel-p">CANCELAR</a></td>
                            </tr>';
             }

          echo '</table>';
      }

  }



public function Form($dato){

  echo '<input type="hidden" id="asociado" name="asociado" value="'.$dato["key"].'">
            <input type="hidden" id="unidad" name="unidad" value="'.$dato["unidad"].'">


          <div class="form-row">
            
            <div class="col-md-12 mb-2 md-form">
              <label for="unidad">* Nueva Lectura</label>
              <input type="text" class="form-control" id="lectura" name="lectura">
            </div>
        </div>';

}






} // Termina la lcase