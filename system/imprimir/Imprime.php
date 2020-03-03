<?php 
class Imprime {

		public function __construct() { 
     	} 


//// notas de cobro
  public function CrearCuotas(){
    $db = new dbConn();
    $asoc = new Asociados();

    $a = $db->query("SELECT * FROM asociados_unidades WHERE edo = 1 and td = ".$_SESSION["td"]."");
    $num = 0;
    foreach ($a as $b) {
    $num = $num + 1;
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

    if ($num == 3) {
        echo '<div class="saltoDePagina"></div>';
        $num = 0;
      }

    } $a->close();

  }







  public function CrearFactura($contador, $fecha){
    $db = new dbConn();
    $asoc = new Asociados();

      if ($r = $db->select("asociado, lectura_anterior, lectura_actual, consumo", "cuotas", "where contador = '$contador' and edo = 2 and fecha = '$fecha' and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { 
        $asociado = $r["asociado"];
        $lectura_anterior = $r["lectura_anterior"];
        $lectura_actual = $r["lectura_actual"];
        $consumo = $r["consumo"];
      } unset($r); 


  $a = $db->query("SELECT sum(total) FROM cuotas WHERE contador = '$contador' and edo = 2 and fecha = '$fecha' and td = ".$_SESSION["td"]."");
      foreach ($a as $b) {
       $total=$b["sum(total)"];
      } $a->close();


/// extrae los meses y cantidades de cada uno
    $a = $db->query("SELECT fecha, cantidad, mora FROM cuotas WHERE contador = '$contador' and edo = 2 and fecha = '$fecha' and td = ".$_SESSION["td"]."");
    $mora = 0;
    foreach ($a as $b) {
    $mora = $mora + $b["mora"];
     
    $meses = Fechas::MesEscrito($b["fecha"]) ." de ". Fechas::AnoFecha($b["fecha"]) .": " . Helpers::Dinero($b["cantidad"]) . " | ";

    } $a->close();

  if($mora != 0){
   $meses .= "Total Mora: " . Helpers::Dinero($mora);
  }


echo '<br><br>

<table class="table table-borderless">
  <tbody>
    <tr>
      <th scope="row"><h3>'.$contador.'</h3></th>
      <td><h3>'.$lectura_anterior.'</h3></td>
      <td><h3>'.$consumo.'</h3></td>
      <td><h3>'.$lectura_actual.'</h3></td>
      <td><h3>'.Helpers::Dinero($total).'</h3></td>
    </tr>
        <tr>
      <th scope="row"></th>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <th scope="row"></th>
      <td colspan="4"><h3>'.$asoc->AsociadoNombre($asociado).'</h3></td>
    </tr>
    <tr>
      <th scope="row"></th>
      <td colspan="4"><h3>'.Dinero::DineroEscrito($total).'</h3></td>
    </tr>
     <tr>
      <td colspan="5"><h3>'.$meses.'</h3></td>
    </tr>
    <tr>
      <th scope="row"></th>
      <td colspan="4"><h3>'.$fecha.'</h3></td>
    </tr>

  </tbody>
</table>

';
  }







} // Termina la clase