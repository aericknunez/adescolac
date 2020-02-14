<?php 
class Imprime {

		public function __construct() { 
     	} 


//// notas de cobro
  public function CrearCuotas(){
    $db = new dbConn();
    $asoc = new Asociados();

    $a = $db->query("SELECT * FROM asociados_unidades WHERE edo = 1 and td = ".$_SESSION["td"]."");
    foreach ($a as $b) {
        /// aqui genero todas las notas de cobro segun contador
        echo '<hr><div class="row">
              <div class="col-6">
                <div class="panel-heading">
                <h3>'.$asoc->AsociadoNombre($b["asociado"]).'</h3>
                </div>
                
                <div class="panel-body"><h3>
               Contador: '.$b["unidad"].'
                </h3></div>

              </div>

              <div class="col-6 text-right">
              <img alt="" src="assets/img/logo/cametpequeno.png"/>
              </div>
            </div>
            <hr />

            <pre>Detalles de cobro</pre>
                  <table class="table table-sm">
                  <thead>
                      <tr>
                      <th scope="col"><h3>Consumo</h3></th>
                      <th scope="col"><h3>Descripci&oacuten</h3></th>
                      <th scope="col"><h3>Cantidad</h3></th>
                      </tr>
                  </thead>
                  <tbody>';
            $x = $db->query("SELECT * FROM cuotas WHERE contador = '".$b["unidad"]."' and edo = 1 and td = ".$_SESSION["td"]."");
            $total = 0;
            $count = 0;
            foreach ($x as $y) {
            $total = $total + $y["total"];
              echo '<tr>
                    <th scope="row"><h3>'.$y["consumo"].' Mts</h3></th>
                    <td><h3>Cuota de '.Fechas::MesEscrito($y["fecha"]).' de '.Fechas::AnoFecha($y["fecha"]).'</h3></td>
                    <td><h3>'.Helpers::Dinero($y["cantidad"]).'</h3></td>
                    </tr>';
             if($y["vencido"] != 0){
               echo '<tr>
                    <th scope="row"><h3>xxx</h3></th>
                    <td><h3>Mora por falta de Pago</h3></td>
                    <td><h3>'.Helpers::Dinero($y["mora"]).'</h3></td>
                    </tr>';
             }
              

                  $c = $db->query("SELECT * FROM cuotas_corte WHERE edo = 1 and contador = '".$b["unidad"]."' and td = ".$_SESSION["td"]."");
                 
                  if($c->num_rows > 0){
                  foreach ($c as $e) {
                     echo '<tr>
                    <th scope="row"><h3>xxx</h3></th>
                    <td><h3>Cobro de Reconexión</h3></td>
                    <td><h3>'.Helpers::Dinero($e["cantidad"]).'</h3></td>
                    </tr>';
                  $total = $total + $e["cantidad"];
                  } 

                  }$c->close();  

                      

            } $x->close();

            echo '<tr>
                    <tr>
                    <td colspan="2" class="text-right"><strong><h3>Total: </h3></strong></td>
                    <th scope="row"><strong><h3>'.Helpers::Dinero($total).'</h3></strong></th>
                    </tr>
                </tbody>
                </table> <hr>';
                  unset($total);
                  unset($count);
    } $a->close();

  }









} // Termina la clase