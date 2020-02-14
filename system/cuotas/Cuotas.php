<?php 
class Cuotas {

		public function __construct() { 
     	} 



  public function AddCuota($datos){
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

          if($this->CompruebaCuota($datos) == TRUE){
            /// aqui debe ir el registro de la nueva cuota
                  $consumo = $this->ConsumoAgua($this->LecturaAnterior($datos["unidad"]), $datos["lectura"]);

                $data["asociado"] = $datos["asociado"];
                $data["contador"] = $datos["unidad"];
                $data["lectura_anterior"] = $this->LecturaAnterior($datos["unidad"]);
                $data["lectura_actual"] = $datos["lectura"];
                $data["consumo"] = $consumo;
                $data["cantidad"] = $this->CantidadConsumo($consumo);
                $data["vencido"] = NULL;
                $data["mora"] = NULL; 
                $data["total"] = $this->CantidadConsumo($consumo);
                $data["fecha"] = date("d-m-Y");
                $data["fechaF"] = Fechas::Format(date("d-m-Y"));
                $data["fechav"] = $this->DiaVencimiento();
                $data["fechavF"] = Fechas::Format($this->DiaVencimiento());
                $data["edo"] = 1; 
                $data["hash"] = Helpers::HashId();
                $data["time"] = Helpers::TimeId();
                $data["td"] = $_SESSION["td"];
                if ($db->insert("cuotas", $data)) {
                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                    $this->ActualizarUltimaLectura($datos["unidad"], $datos["lectura"]);
                } else {
                  Alerts::Alerta("error","Error!","Algo Ocurrio :(");
                }



          } else {
            Alerts::Alerta("error","Error!","Ya existe un registro en esta fecha!");
          }
                

    } else {
      Alerts::Alerta("error","Error!","Faltan Datos!");
    }

  }


  public function CompruebaForm($datos){
        if($datos["lectura"] == NULL or
            $datos["asociado"] == NULL or
            $datos["unidad"] == NULL){
          return FALSE;
        } else {
         return TRUE;
        }
  }

  public function CompruebaCuota($datos){
    $db = new dbConn();
    $fechax = Fechas::Format(date("d-m-Y"));

    $a = $db->query("SELECT * FROM cuotas WHERE asociado = '".$datos["asociado"]."' and contador = '".$datos["unidad"]."' and fechaF = '$fechax' and td = ".$_SESSION["td"]."");
    if($a->num_rows == 0){
      return true; /// no existe registro
    } else {
      return false;
    }    
    
    $a->close();

  }



  public function CompruebaCorte($contador){
    $db = new dbConn();
  
    $a = $db->query("SELECT * FROM cuotas_corte WHERE contador = '$contador' and edo = 1 and td = ".$_SESSION["td"]."");
    if($a->num_rows == 0){
      return true; /// no existe registro
    } else {
      return false;
    }    
    
    $a->close();

  }




/// ultima lectura
  public function LecturaAnterior($contador){
    $db = new dbConn();

    if ($r = $db->select("lectura", "asociados_unidades", "WHERE unidad = '$contador' and td = ".$_SESSION["td"]."")) { 
        return $r["lectura"];
    } unset($r);  

  }


  public function ConsumoAgua($anterior, $actual){
      $consumo =  $actual - $anterior;
      return $consumo;
  }


  public function CantidadConsumo($consumo){ // consumo en $$
    $db = new dbConn();

    if ($r = $db->select("mts", "precios", "WHERE td = ".$_SESSION["td"]."")) { 
        $precio = $r["mts"];
    } unset($r);  

    return $consumo * $precio;

  }


  public function DiaVencimiento(){ // consumo en $$
    $db = new dbConn();

    if ($r = $db->select("fecha_ultima", "precios", "WHERE td = ".$_SESSION["td"]."")) { 
        $fecha = $r["fecha_ultima"];
    } unset($r);  

      $f = date("m-Y");
    return $fecha . "-" .$f;

  }


  public function ActualizarUltimaLectura($contador, $lectura){
    $db = new dbConn();

          $data["lectura"] = $lectura;
          Helpers::UpdateId("asociados_unidades", $data, "unidad = '$contador' and td = ".$_SESSION["td"]."");          
  }




/////////////////pagar
  public function Pagar($datos){
    $db = new dbConn();
    $asociado = new Asociados();

        if ($r = $db->select("*", "cuotas", "WHERE hash = '".$datos["hash"]."' and td = ".$_SESSION["td"]."")) { 

         echo '<div class="text-center"><h2>'.$asociado->AsociadoNombre($r["asociado"]).'</h2>
         <h4>'.$r["contador"].'</h4>
          <h1>'.Helpers::Dinero($r["total"]).'</h1>
          <p>Cuota de: '.Fechas::MesEscrito($r["fecha"]).' de '.Fechas::AnoFecha($r["fecha"]).'</p>';
          
      if($this->CompruebaCorte($r["contador"]) == TRUE){ 
        echo '<a id="cobrar" hash="'.$datos["hash"].'" op="202" total="'.$r["total"].'" class="btn btn-success btn-rounded">Cobrar</a>';
      } else {
        Alerts::Mensajex("Hay una órden de corte activa en éste contador, nates de continuar, debe cobrar esta orden","danger");
        echo '<a href="?ordenes_corte" class="btn btn-danger btn-rounded">Ordenes de corte</a>';
      }
        


        echo '</div>';

        }  unset($r);   
  }



public function Cobrar($datos){
      $db = new dbConn();

    $data = array();
    $data["dia_cancel"] = date("d-m-Y");
    $data["dia_cancelF"] = Fechas::Format(date("d-m-Y"));
    $data["edo"] = 2;
    if (Helpers::UpdateId("cuotas", $data, "hash = '".$datos["hash"]."' and edo = 1 and td = ".$_SESSION["td"]."")) {
        Alerts::Alerta("success","Realizado!","Cambio realizado exitsamente!");        

      } else {
      Alerts::Alerta("error","Error!","Faltan Datos!");
      }
  

    }


/// total adeudado
  public function TotalAdeudado($contador){ // consumo en $$
    $db = new dbConn();

$a = $db->query("SELECT sum(total) FROM cuotas WHERE contador = '$contador' and edo = 1 and td = ".$_SESSION["td"]."");
        foreach ($a as $b) {
         $total = $b["sum(total)"];
   } $a->close();

   if($this->CompruebaCorte($r["contador"]) == FALSE){ // tre existe registro
        if ($r = $db->select("reconexion", "precios", "WHERE td = ".$_SESSION["td"]."")) { 
            $reconexion = $r["reconexion"];
        } unset($r); 
   } else {
    $reconexion = 0;
   }

    return $total + $reconexion;
  }



  public function OrdenModal($datos){
    $db = new dbConn();
    $asociado = new Asociados();

        if ($r = $db->select("*", "cuotas_corte", "WHERE hash = '".$datos["hash"]."' and td = ".$_SESSION["td"]."")) { 

      Alerts::Mensajex("Cancele la orden de suspención, despues puede pagar las cuotas pendientes. La cantidad total adeudada es de " . Helpers::Dinero($this->TotalAdeudado($r["contador"])) ,"info");

         echo '<div class="text-center"><h2>'.$asociado->AsociadoNombre($r["asociado"]).'</h2>
         <h4>'.$r["contador"].'</h4>
          <h1>'.Helpers::Dinero($r["cantidad"]).'</h1>
          <p>Cancelación de suspensión de servicio: '.Fechas::MesEscrito($r["fecha"]).' de '.Fechas::AnoFecha($r["fecha"]).'</p>';
          
        echo '<a id="cobrar" hash="'.$datos["hash"].'" op="204" total="'.$r["cantidad"].'" class="btn btn-success btn-rounded">Cobrar</a>';


        echo '</div>';

        }  unset($r);   
  }



public function CobrarSuspencion($datos){
      $db = new dbConn();

    $data = array();
    $data["fecha_pago"] = date("d-m-Y");
    $data["Fecha_pagoF"] = Fechas::Format(date("d-m-Y"));
    $data["edo"] = 2;
    if (Helpers::UpdateId("cuotas_corte", $data, "hash = '".$datos["hash"]."' and edo = 1 and td = ".$_SESSION["td"]."")) {
        Alerts::Alerta("success","Realizado!","Cambio realizado exitsamente!");        

      } else {
      Alerts::Alerta("error","Error!","Faltan Datos!");
      }
  

    }





} // Termina la lcase