<?php 
class Contribuciones {

		public function __construct() { 
     	} 



  public function AddContribucion($datos){
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

                $data["contribucion"] = strtoupper($datos["contribucion"]);
                $data["cuota"] = $datos["cuota"];
                $data["dias_activos"] = $datos["dias"];
                $data["mora"] = $datos["mora"];
                $data["inicio"] = $datos["inicio_submit"];
                $data["inicioF"] = Fechas::Format($datos["inicio_submit"]);
                $data["fin"] = Fechas::DiaSuma($datos["inicio_submit"],$datos["dias"]);
                $data["finF"] = Fechas::Format(Fechas::DiaSuma($datos["inicio_submit"],$datos["dias"])); // inicio mas dias de vig
                $data["vigencia"] = $datos["vigencia_submit"]; // del form
                $data["vigenciaF"] = Fechas::Format($datos["vigencia_submit"]);
                $data["tipo"] = $datos["tipo"];
                $data["hash"] = Helpers::HashId();
                $data["time"] = Helpers::TimeId();
                $data["td"] = $_SESSION["td"];
                if ($db->insert("asociados_contribuciones", $data)) {
                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                }

        } else {
          Alerts::Alerta("error","Error!","Faltan Datos!");
        }

      $this->VerContribuciones();
  }


  public function CompruebaForm($datos){
        if($datos["contribucion"] == NULL or
          $datos["cuota"] == NULL or
          $datos["dias"] == NULL or
          $datos["mora"] == NULL){
          return FALSE;
        } else {
         return TRUE;
        }
  }

  public function UpContribucion($datos){ // lo que viede del formulario principal
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos
                $data["contribucion"] = strtoupper($datos["contribucion"]);
                $data["cuota"] = $datos["cuota"];
                $data["mora"] = $datos["mora"];

                $data["vigencia"] = $datos["vigencia_submit"]; // del form
                $data["vigenciaF"] = Fechas::Format($datos["vigencia_submit"]);
                $data["hash"] = Helpers::HashId();
                $data["time"] = Helpers::TimeId();
                $data["td"] = $_SESSION["td"];
              if (Helpers::UpdateId("asociados_contribuciones", $data, "hash = '".$datos["hash"]."' and td = ".$_SESSION["td"]."")) {
                  Alerts::Alerta("success","Realizado!","Cambio realizado exitsamente!");
                  echo '<script>
                        window.location.href="?contribucionadd"
                      </script>';
              }           

      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }

  }



  public function VerContribuciones(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM asociados_contribuciones WHERE td = ".$_SESSION["td"]." order by id desc limit 10");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Contribuci&oacuten</th>
              <th scope="col">Cuota</th>
              <th scope="col">Mora</th>
              <th scope="col">Estado</th>
              <th scope="col">Acci&oacuten</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                if($this->EdoVigencia($b["hash"]) == TRUE) $vig = "Activo"; else $vig = "Inactivo";
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["contribucion"].'</td>
                      <td>'.$b["cuota"].'</td>
                      <td>'.$b["mora"].'</td>
                      <td>'.$vig.'</td>
                      <td><a href="?modal=editcontribucion&key='.$b["hash"].'" ><i class="fa fa-edit fa-lg green-text"></i></a><a id="xdelete" hash="'.$b["hash"].'" op="191"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';
          } $a->close();  
      
  }

  public function EdoVigencia($contribucion){
      $db = new dbConn();

    if ($r = $db->select("vigenciaF", "asociados_contribuciones", "WHERE hash = '$contribucion' and td = ".$_SESSION["td"]."")) { 
        $vigencia = $r["vigenciaF"];
    }  unset($r);  

      if($vigencia == NULL or $vigencia <= Fechas::Format(date("d-m-Y"))){
        return TRUE;
      } else {
        return FALSE;
      }
  }




  public function DelContribucion($hash){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("asociados_contribuciones", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","asociado eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerContribuciones();
  }


///////////////////////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

/////////// comprobar si ya estuvo el mes
  public function UltimaFecha($contribucion){
    $db = new dbConn();
      if ($r = $db->select("mes", "asoc_control_mes", "where contribucion = '$contribucion' and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { return $r["mes"];
      } unset($r); 
  }
 
  public function FechaInicio($date){ // fecha inicio  
      $dia = Fechas::DiaFecha($date); // extrigo el dia
      return date($dia . "-m-Y");
  }


  public function VerificarCuota($contribucion, $asociado){
    $db = new dbConn();
          $a = $db->query("SELECT * FROM asoc_cuotas WHERE asociado = '$asociado' and contribucion = '$contribucion' and td = ".$_SESSION["td"]."");
                  if($a->num_rows > 0){ // si hay
                    return TRUE; 
                  } else {
                    return FALSE;
                  }
          $a->close();
  }













///sino -- recorrerr todos las contribuciones si son personales o por unidad
  public function Ejecutar(){
    $db = new dbConn();
          $a = $db->query("SELECT * FROM asociados_contribuciones WHERE td = ".$_SESSION["td"]."");
            foreach ($a as $b) {
               
              $contribucion = $b["hash"];

                if($this->UltimaFecha($contribucion) != date("m-Y")){ /// si la ultima fecha no corresponde a este mes

                    //comparao si la contrubucion es para los asociados o taxis asocc =  1
                    if($b["tipo"] == 1){ // 1 == a todos los usuarios

                      $aa = $db->query("SELECT * FROM asociados WHERE edo = '1' or edo = '2' and  td = ".$_SESSION["td"]."");
                        foreach ($aa as $ba) {
                          $asociado = $ba["hash"];

                      //      if($this->VerificarCuota($contribucion, $asociado) == FALSE){ 
                            // verifico si existe la cuota si es false la agrego
                                    $datos = array();
                                    $datos["asociado"] = $asociado;
                                    $datos["contribucion"] = $contribucion;
                                    $datos["descripcion"] = $b["contribucion"];
                                    $datos["cuota"] = $b["cuota"];
                                    $datos["mora"] = $b["mora"];
                                    $datos["total"] = $b["total"];
                                    $datos["inicio"] = $this->FechaInicio($b["inicio"]);
                                    $datos["inicioF"] = Fechas::Format($this->FechaInicio($b["inicio"]));
                                    $datos["fin"] = Fechas::DiaSuma($this->FechaInicio($b["inicio"]),$b["dias_activos"]);
                                    $datos["finF"] = Fechas::Format(Fechas::DiaSuma($this->FechaInicio($b["inicio"]),$b["dias_activos"]));
                                    $datos["dia_cancel"] = NULL;
                                    $datos["dia_cancelF"] = NULL;
                                    $datos["edo"] = 1;
                                    $datos["hash"] = Helpers::HashId();
                                    $datos["time"] = Helpers::TimeId();
                                    $datos["td"] = $_SESSION["td"];
                                    $db->insert("asoc_cuotas", $datos); 
                        //    } // verifica

                      } $aa->close(); // aa//////////////////////


                    } //comparao si la contrubucion es para los asociados o taxis asocc =  1
                    elseif($b["tipo"] == 3){ // 1 == a todos los usuarios

                      $aa = $db->query("SELECT * FROM asociados WHERE edo = '3' and td = ".$_SESSION["td"]."");
                        foreach ($aa as $ba) {
                          $asociado = $ba["hash"];

                      //      if($this->VerificarCuota($contribucion, $asociado) == FALSE){ 
                            // verifico si existe la cuota si es false la agrego
                                    $datos = array();
                                    $datos["asociado"] = $asociado;
                                    $datos["contribucion"] = $contribucion;
                                    $datos["descripcion"] = $b["contribucion"];
                                    $datos["cuota"] = $b["cuota"];
                                    $datos["mora"] = $b["mora"];
                                    $datos["total"] = $b["total"];
                                    $datos["inicio"] = $this->FechaInicio($b["inicio"]);
                                    $datos["inicioF"] = Fechas::Format($this->FechaInicio($b["inicio"]));
                                    $datos["fin"] = Fechas::DiaSuma($this->FechaInicio($b["inicio"]),$b["dias_activos"]);
                                    $datos["finF"] = Fechas::Format(Fechas::DiaSuma($this->FechaInicio($b["inicio"]),$b["dias_activos"]));
                                    $datos["dia_cancel"] = NULL;
                                    $datos["dia_cancelF"] = NULL;
                                    $datos["edo"] = 1;
                                    $datos["hash"] = Helpers::HashId();
                                    $datos["time"] = Helpers::TimeId();
                                    $datos["td"] = $_SESSION["td"];
                                    $db->insert("asoc_cuotas", $datos); 
                        //    } // verifica

                      } $aa->close(); // aa//////////////////////


                    } else{ // solo para unidades
                        // aqui ago para las unidades
                        // 
                        $aa = $db->query("SELECT * FROM asociados_unidades WHERE edo = 1 and td = ".$_SESSION["td"]."");
                        foreach ($aa as $ba) {
                          $asociado = $ba["asociado"];
                                    $datos = array();
                                    $datos["asociado"] = $asociado;
                                    $datos["contribucion"] = $contribucion;
                                    $datos["descripcion"] = $b["contribucion"] . " (unidad " . $ba["unidad"] . ")";
                                    $datos["cuota"] = $b["cuota"];
                                    $datos["mora"] = $b["mora"];
                                    $datos["total"] = $b["total"];
                                    $datos["inicio"] = $this->FechaInicio($b["inicio"]);
                                    $datos["inicioF"] = Fechas::Format($this->FechaInicio($b["inicio"]));
                                    $datos["fin"] = Fechas::DiaSuma($this->FechaInicio($b["inicio"]),$b["dias_activos"]);
                                    $datos["finF"] = Fechas::Format(Fechas::DiaSuma($this->FechaInicio($b["inicio"]),$b["dias_activos"]));
                                    $datos["dia_cancel"] = NULL;
                                    $datos["dia_cancelF"] = NULL;
                                    $datos["edo"] = 1;
                                    $datos["hash"] = Helpers::HashId();
                                    $datos["time"] = Helpers::TimeId();
                                    $datos["td"] = $_SESSION["td"];
                                    $db->insert("asoc_cuotas", $datos); 

                        } $aa->close();
                    } 
                     

                    $this->InsertarControl($contribucion);
                } // verifica fecha

              
            } $a->close();

  }

  public function InsertarControl($contribucion){
    $db = new dbConn();
          $datos = array();
          $datos["contribucion"] = $contribucion;
          $datos["mes"] = date("m-Y");
          $datos["hash"] = Helpers::HashId();
          $datos["time"] = Helpers::TimeId();
          $datos["td"] = $_SESSION["td"];
          $db->insert("asoc_control_mes", $datos); 
  }




/////////////////////////// sanciones //////////////
  public function AddSancion($datos){
    $db = new dbConn();
      if($datos["sancion"] != NULL or $datos["cantidad"] != NULL){ 

                $data["sancion"] = strtoupper($datos["sancion"]);
                $data["cantidad"] = $datos["cantidad"];
                $data["edo"] = 1;
                $data["hash"] = Helpers::HashId();
                $data["time"] = Helpers::TimeId();
                $data["td"] = $_SESSION["td"];
                if ($db->insert("conductores_sanciones", $data)) {
                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                }
        } else {
          Alerts::Alerta("error","Error!","Faltan Datos!");
        }

      $this->VerSanciones();

  }




  public function DelSancion($hash){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("conductores_sanciones", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","asociado eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerSanciones();
  }


  public function VerSanciones(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM conductores_sanciones WHERE td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Sanci&oacuten</th>
              <th scope="col">Cuota</th>
              <th scope="col">OP</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                if($this->EdoVigencia($b["hash"]) == TRUE) $vig = "Activo"; else $vig = "Inactivo";
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["sancion"].'</td>
                      <td>'.Helpers::Dinero($b["cantidad"]).'</td>
                      <td><a href="?modal=editsancion&key='.$b["hash"].'" ><i class="fa fa-edit fa-lg green-text"></i></a><a id="xdelete" hash="'.$b["hash"].'" op="221"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';
          } $a->close();  
      
  }


  public function UpSancion($datos){ // lo que viede del formulario principal
    $db = new dbConn();
       if($datos["sancion"] != NULL or $datos["cantidad"] != NULL){ 

                $data["sancion"] = strtoupper($datos["sancion"]);
                $data["cantidad"] = $datos["cantidad"];
                $data["time"] = Helpers::TimeId();
              if (Helpers::UpdateId("conductores_sanciones", $data, "hash = '".$datos["hash"]."' and td = ".$_SESSION["td"]."")) {
                  Alerts::Alerta("success","Realizado!","Cambio realizado exitsamente!");
                  echo '<script>
                        window.location.href="?sanciones"
                      </script>';
              }           

      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }

  }








} // Termina la lcase