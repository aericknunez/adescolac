<?php 
class Asociados {

		public function __construct() { 
     	} 



  public function AddAsociado($datos){
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

                $hashed = Helpers::HashId(); // para que este hash mismo sea para cliente
                $datos["nombre"] = strtoupper($datos["nombre"]);
                $datos["hash"] = $hashed;
                $datos["time"] = Helpers::TimeId();
                $datos["td"] = $_SESSION["td"];
                if ($db->insert("asociados", $datos)) {

                    /// agregando como cliente
                    unset($datos["edo"]);
                    $db->insert("clientes", $datos);

                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                }

        } else {
          Alerts::Alerta("error","Error!","Faltan Datos!");
        }
      $this->VerAsociados();
  }


  public function CompruebaForm($datos){
        if($datos["nombre"] == NULL){
          return FALSE;
        } else {
         return TRUE;
        }
  }

  public function UpAsociado($datos){ // lo que viede del formulario principal
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

              $data["nombre"] = strtoupper($datos["nombre"]);
              $data["documento"] = $datos["documento"];
              $data["telefono"] = $datos["telefono"];
              $data["direccion"] = $datos["direccion"];
              $data["comentarios"] = $datos["comentarios"];
              $data["time"] = Helpers::TimeId();
              $hash = $datos["hash"];
              if (Helpers::UpdateId("asociados", $data, "hash = '$hash' and td = ".$_SESSION["td"]."")) {
                  
                  Helpers::UpdateId("clientes", $data, "hash = '$hash' and td = ".$_SESSION["td"]."");

                  Alerts::Alerta("success","Realizado!","Cambio realizado exitsamente!");
                  echo '<script>
                        window.location.href="?asociadover"
                      </script>';
              }           

      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
  }



  public function VerAsociados(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM asociados WHERE edo != 0 and td = ".$_SESSION["td"]." order by id desc limit 10");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Documento</th>
              <th scope="col">Direccion</th>
              <th scope="col">Telefono</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["nombre"].'</td>
                      <td>'.$b["documento"].'</td>
                      <td>'.$b["direccion"].'</td>
                      <td>'.$b["telefono"].'</td>
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="185"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';
            echo '<div class="text-center"><a href="?asociadover" class="btn btn-outline-info btn-rounded waves-effect btn-sm">Ver Todos</a></div>';
          } $a->close();  
      
  }


  public function DelAsociado($hash){ // elimina precio
    $db = new dbConn();

        $data["edo"] = 0;
        if (Helpers::UpdateId("asociados", $data, "hash = '$hash' and td = ".$_SESSION["td"]."")){
           Alerts::Alerta("success","Eliminado!","asociado eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerAsociados();
  }

  public function DelAsociadox($hash){ // elimina precio
    $db = new dbConn();
        
        $data["edo"] = 0;
        if (Helpers::UpdateId("asociados", $data, "hash = '$hash' and td = ".$_SESSION["td"]."")){
           Alerts::Alerta("success","Eliminado!","asociado eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerTodosAsociados();
  }



  public function VerTodosAsociados(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM asociados WHERE edo != 0 and td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-sm table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Estado</th>
                    <th>Ver</th>
                    <th>OP</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                if($b["edo"] == 1) $edo = "Activo"; elseif($b["edo"] == 2) $edo = "Inactivo"; else $edo = "No Asociado";
                echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$b["nombre"].'</td>
                      <td>'.$b["telefono"].'</td>
                      <td>'.$edo.'</td>
                      <td><a id="xver" op="188" key="'.$b["hash"].'"><i class="fas fa-search fa-lg green-text"></i></a></td>
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="186"><i class="fa fa-minus-circle fa-lg red-text"></i></a>
                      <a id="print" hash="'.$b["hash"].'" ><i class="fa fa-print fa-lg blue-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Telefono</th>
                    <th>Ver</th>
                    <th>OP</th>
                  </tr>
                </tfoot>
              </table>';

          } $a->close();  

  }











  public function VistaAsociado($data){
      $db = new dbConn();
     if ($r = $db->select("*", "asociados", "WHERE hash = '".$data["key"]."' and td = ".$_SESSION["td"]."")) { 


              echo '<table class="table table-hover">
                <thead>
                  <tr>
                    <th>Nombre: '.$r["nombre"].'</th>
                    <th>Documento: '.$r["documento"].'</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th colspan="2">Direcci&oacuten: '.$r["direccion"].'</th>
                  </tr>
                  <tr>
                    <td>Telefono: '.$r["telefono"].'</td>
                    <td>Comentarios: '.$r["comentarios"].'</td>
                  </tr>
                </tbody>
              </table>'; 

        }  unset($r); 

$this->VerUnidades($data["key"], 1);


  }





////////////////////unidades de los asociados ////
///
  public function AddUnidades($datos){
    $db = new dbConn();
      if($datos["unidad"] != NULL or $datos["lectura"] != NULL){ // comprueba si todos los datos requeridos estan llenos
                $datos["edo"] = 1;
                $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
                $datos["td"] = $_SESSION["td"];
                if ($db->insert("asociados_unidades", $datos)) {
                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                }

        } else {
          Alerts::Alerta("error","Error!","Faltan Datos!");
        }

      $this->VerUnidades($datos["asociado"]);

  }






  public function VerUnidades($asociado, $ver = NULL){
      $db = new dbConn();

          $a = $db->query("SELECT * FROM asociados_unidades WHERE asociado='".$asociado."' and td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
          Alerts::Mensajex("Contadores registrados por el asociado","info");

        echo '<table class="table table-sm table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Contador</th>
                  <th scope="col">Ultima Lectura</th>';
                        if($ver == NULL){
                          echo '<th scope="col">Borrar</th>';
                        }
                  echo '</tr>
              </thead>
              <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                echo '<tr>
                        <th scope="row">'.$n++.'</th>
                        <td>'.$b["unidad"].'</td>
                        <td>'.$b["lectura"].'</td>';
                        if($ver == NULL){
                          echo '<td><a id="delunidad" hash="'.$b["hash"].'" op="197" asociado="'.$asociado.'"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>';
                        }
                    echo '</tr>';          
              }
        echo '</tbody>
              </table>';

          } else {
             Alerts::Mensajex("No hay Unidades registradas por el asociado","danger");
          }$a->close();  

  }


  public function DelUnidad($hash, $asociado){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("asociados_unidades", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Unidad eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
     $this->VerUnidades($asociado);
  }



public function VerTodasLasUnidades(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM asociados_unidades WHERE td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-sm table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Asociado</th>
                    <th>Unidad</th>
                    <th>Ultima Lectura</th>
                    <th>Ver</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$this->AsociadoNombre($b["asociado"]).'</td>
                      <td>'.$b["unidad"].'</td>
                      <td>'.$b["lectura"].'</td>
                      <td>
                      <a id="xver" op="188" key="'.$b["asociado"].'"><i class="fas fa-search fa-lg green-text"></i></a>
                        |  <a id="xcont" op="189" key="'.$b["asociado"].'" unidad="'.$b["unidad"].'"><i class="fas fa-file-invoice fa-lg red-text"></i></a>
                      </td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Asociado</th>
                    <th>Unidad</th>
                    <th>Placa</th>
                  </tr>
                </tfoot>
              </table>';

          } $a->close();  

  }

  public function AsociadoNombre($hash){
      $db = new dbConn();

    if ($r = $db->select("nombre", "asociados", "WHERE hash = '$hash' and td = ".$_SESSION["td"]."")) { 
        return $r["nombre"];
    }  unset($r);  
  }



  public function DatosAsociado($datos){
      $db = new dbConn();
      $asociado = new Cuotas();

      $datos["asociado"] = $datos["key"];
      if($asociado->CompruebaCuota($datos) == FALSE){
        Alerts::Mensajex("Ya existe una cuota en esta fecha","danger");
      }

      echo '<h2>'.$this->AsociadoNombre($datos["key"]).'</h2>
      Contador:
      <h1>'.$datos["unidad"].'</h1>
      Lectura anterior:
      <h3>'.$asociado->LecturaAnterior($datos["unidad"]).'</h3>';

  }





public function VerCuotas($vencidos = NULL){
      $db = new dbConn();

       if($vencidos == NULL){
        $a = $db->query("SELECT * FROM cuotas WHERE td = ".$_SESSION["td"]." order by id desc");
      } else {
        $a = $db->query("SELECT * FROM cuotas WHERE edo = 1 and td = ".$_SESSION["td"]." order by id desc");
      }
          
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-sm table-striped" >
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Asociado</th>
                    <th>Contador</th>
                    <th>Lectura Anterior</th>
                    <th>Lectura Actual</th>
                    <th>Total</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                if($b["edo"] == 1) $edo = '<a id="pagar" op="201" hash="'.$b["hash"].'"><i class="fas fa-money-bill-alt fa-lg green-text"></i> COBRAR</a>'; else $edo = "CANCELADO";
                echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$this->AsociadoNombre($b["asociado"]).'</td>
                      <td>'.$b["contador"].'</td>
                      <td>'.$b["lectura_anterior"].'</td>
                      <td>'.$b["lectura_actual"].'</td>
                      <td>'.Helpers::Dinero($b["total"]).'</td>
                      <td id="idcuota'.$b["hash"].'">'.$edo.'</td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Asociado</th>
                    <th>Contador</th>
                    <th>Lectura Anterior</th>
                    <th>Lectura Actual</th>
                    <th>Total</th>
                    <th>Estado</th>
                  </tr>
                </tfoot>
              </table>';

          } else {
            Alerts::Mensajex("No se encontraron cuotas para mostrar","danger");
          } $a->close();  

  }










public function OrdenesCorte($vencidos = NULL){
      $db = new dbConn();
      $asociado = new Cuotas();

        $a = $db->query("SELECT * FROM cuotas_corte WHERE td = ".$_SESSION["td"]." order by id desc");
          
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-sm table-striped" >
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Asociado</th>
                    <th>Contador</th>
                    <th>Fecha</th>
                    <th>Total Adeudado</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                if($b["edo"] == 1) $edo = '<a id="pagar" op="203" hash="'.$b["hash"].'"><i class="fas fa-money-bill-alt fa-lg green-text"></i> COBRAR</a>'; else $edo = "CANCELADO";
                echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$this->AsociadoNombre($b["asociado"]).'</td>
                      <td>'.$b["contador"].'</td>
                      <td>'.$b["fecha"].'</td>
                      <td>'.Helpers::Dinero($asociado->TotalAdeudado($b["contador"])).'</td>
                      <td id="idcuota'.$b["hash"].'">'.$edo.'</td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Asociado</th>
                    <th>Contador</th>
                    <th>Fecha</th>
                    <th>Total Adeudado</th>
                    <th>Estado</th>
                  </tr>
                </tfoot>
              </table>';

          } else {
            Alerts::Mensajex("No se encontraron cuotas para mostrar","danger");
          } $a->close();  

  }








} // Termina la clase