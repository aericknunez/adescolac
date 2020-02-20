<?php 
class CuotasFijas {

		public function __construct() { 
     	} 



  public function AddCuota($datos){
    $db = new dbConn();

    if($this->BuscarCuotas($datos["asociado"]) == TRUE){ // si es true es que hay cuotas

      // buscar la ultima cuota pagada
      $ultima = $this->UltimaCuota($datos["asociado"]);

        $i = 1;
        while ($i <= $datos["cantidad"]) {
        // obtener fecha nueva
          $mes = Fechas::MesSuma("01-" . $ultima ,$i);

                $data["asociado"] = $datos["asociado"];
                $data["cuota"] = $datos["cuota"];
                $data["mes"] = $mes;
                $data["fecha_pago"] = date("d-m-Y");
                $data["fecha_pagoF"] = Fechas::Format(date("d-m-Y"));
                $data["edo"] = 1; 
                $data["hash"] = Helpers::HashId();
                $data["time"] = Helpers::TimeId();
                $data["td"] = $_SESSION["td"];
                if ($db->insert("cuotas_fijas", $data)) {
                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                }


           $i++;
        } // while

    } else {

    // comenzar a aplicar cuotas a partir de ahora 
      $ultima = date("m-Y");

        $i = 1;
        while ($i <= $datos["cantidad"]) {
        // obtener fecha nueva
          $mes = Fechas::MesSuma("01-" . $ultima ,$i);

                $data["asociado"] = $datos["asociado"];
                $data["cuota"] = $datos["cuota"];
                $data["mes"] = $mes;
                $data["fecha_pago"] = date("d-m-Y");
                $data["fecha_pagoF"] = Fechas::Format(date("d-m-Y"));
                $data["edo"] = 1; 
                $data["hash"] = Helpers::HashId();
                $data["time"] = Helpers::TimeId();
                $data["td"] = $_SESSION["td"];
                if ($db->insert("cuotas_fijas", $data)) {
                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                }


           $i++;
        } // while


    } // else

    unset($_SESSION["cuota_cantidad"]);
  }






/// corroborar si existen cuotas

  public function BuscarCuotas($asociado){
    $db = new dbConn();

  $a = $db->query("SELECT * FROM cuotas_fijas WHERE asociado = '$asociado' and edo = 1 and td = ".$_SESSION["td"]."");
  $num = $a->num_rows;
  $a->close();

      if($num > 0){
        return TRUE;
      } else {
        return FALSE;
      }

  }


  public function UltimaCuota($asociado){
    $db = new dbConn();
      if ($r = $db->select("mes", "cuotas_fijas", "where asociado = '$asociado' and edo = 1 and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { return $r["mes"];
      } unset($r); 
  }








} // Termina la clase