<?php 
class Facturas{

		public function __construct() { 
     	} 


  public function VerFacturas($fecha){
      $db = new dbConn();
      $asoc = new Asociados(); 

    $d = $db->selectGroup("asociado, contador, count(edo)", "cuotas", "WHERE edo = 2 and dia_cancel = '$fecha' GROUP BY contador");
    if ($d->num_rows > 0) {
            echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Asociado</th>
              <th scope="col">Contador</th>
              <th scope="col">Facturas</th>
              <th scope="col">Imprimir</th>
            </tr>
          </thead>
          <tbody>';	
          $n = 1;
        while($r = $d->fetch_assoc() ) {
            echo '<tr>
              <th scope="row">'. $n ++ .'</th>
              <td>'.$asoc->AsociadoNombre($r["asociado"]).'</td>
              <td>'.$r["contador"].'</td>
              <td>'.$r["count(edo)"].'</td>
              <td><a href="system/imprimir/imprimir.php?op=2&contador='.$r["contador"].'&fecha='.$fecha.'"><i class="fa fa-print fa-lg red-text"></i></a></td>
            </tr>';  

        }

        echo '</tbody>
        </table>';

    } $d->close();

  }














} // Termina la lcase