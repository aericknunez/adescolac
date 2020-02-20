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
                $lectura_anterior = $this->LecturaAnterior($datos["unidad"]);

                if($lectura_anterior <= $datos["lectura"]){ 

                $data["asociado"] = $datos["asociado"];
                $data["contador"] = $datos["unidad"];
                $data["lectura_anterior"] = $lectura_anterior;
                $data["lectura_actual"] = $datos["lectura"];
                $data["consumo"] = $consumo;
                $data["cantidad"] = $this->CantidadConsumo($consumo, $datos["unidad"]);
                $data["vencido"] = NULL;
                $data["mora"] = NULL; 
                $data["total"] = $this->CantidadConsumo($consumo, $datos["unidad"]);
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
                Alerts::Alerta("error","Error!","La lectura actual es menor que la anterior!");
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


  public function AddOtroPrecio($datos){
    $db = new dbConn();

            if($datos["pcontador"] != NULL){
                $data["contador"] = $datos["pcontador"];
                $data["precio"] = $datos["pcantidad"];
                $data["edo"] = 1; 
                $data["hash"] = Helpers::HashId();
                $data["time"] = Helpers::TimeId();
                $data["td"] = $_SESSION["td"];
                if ($db->insert("cuota_otro_precio", $data)) {
                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                    $this->ActualizarUltimaLectura($datos["unidad"], $datos["lectura"]);
                } else {
                  Alerts::Alerta("error","Error!","Algo Ocurrio :(");
                }             
              } else {
                Alerts::Alerta("error","Error!","Faltan Datos :(");
              }
        
        $this->ModalPrecioAgua($datos["pcontador"]);

  }

  public function QuitarOtroPrecio($contador){ // elimina precio
    $db = new dbConn();

        $data["edo"] = 0;
        if(Helpers::DeleteId("cuota_otro_precio", "contador = '$contador' and td = ".$_SESSION["td"]."")){
           Alerts::Alerta("success","Eliminado!","asociado eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->ModalPrecioAgua($contador);
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


    public function CompruebaOtroPrecio($contador){ /// falso no tieno otro precio
    $db = new dbConn();
 
       if ($r = $db->select("precio", "cuota_otro_precio", "WHERE contador = '$contador' and td = ".$_SESSION["td"]."")) {$precio = $r["precio"];
      } unset($r); 

        if($precio == NULL){
          return FALSE;
        } else{
          return $precio;
        }
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


  public function PrecioAgua($contador){ // consumo en $$
    $db = new dbConn();
    
    if($this->CompruebaOtroPrecio($contador) == FALSE){
          if ($r = $db->select("mts", "precios", "WHERE td = ".$_SESSION["td"]."")) { 
            $precio = $r["mts"];
          } unset($r);    
      } else {
          $precio = $this->CompruebaOtroPrecio($contador);
      }
      return $precio;
  }



  public function CantidadConsumo($consumo, $contador){ // consumo en $$
    $db = new dbConn();

    $precio = $this->PrecioAgua($contador);

    if($precio < 2){
      $total =  2;
    } else {
      $total =  $consumo * $precio;
    }
    return $total;

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
          
      if($this->CompruebaCorte($r["contador"]) != TRUE){ 
        Alerts::Mensajex("Hay una órden de corte activa en éste contador, Puede cobrar las cuotas pendientes pero la orden de corte debe cancelarse por aparte","danger");
        echo '<a href="?ordenes_corte" class="btn btn-danger btn-rounded">Ver Orden de corte</a>';
      } 
        
        echo '<a id="cobrar" hash="'.$datos["hash"].'" op="202" total="'.$r["total"].'" class="btn btn-success btn-rounded">Cobrar</a>';


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

if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 3) { 
        if ($r = $db->select("*", "cuotas_corte", "WHERE hash = '".$datos["hash"]."' and td = ".$_SESSION["td"]."")) { 

      Alerts::Mensajex("Orden de suspensión activa. La cantidad total adeudada es de " . Helpers::Dinero($this->TotalAdeudado($r["contador"])) ,"info");

         echo '<div class="text-center"><h2>'.$asociado->AsociadoNombre($r["asociado"]).'</h2>
         <h4>'.$r["contador"].'</h4>
          <h1>'.Helpers::Dinero($r["cantidad"]).'</h1>
          <p>Cancelación de suspensión de servicio: '.Fechas::MesEscrito($r["fecha"]).' de '.Fechas::AnoFecha($r["fecha"]).'</p>';
          
        echo '<a id="cobrar" hash="'.$datos["hash"].'" op="204" total="'.$r["cantidad"].'" class="btn btn-success btn-rounded">Cobrar</a>';


        echo '</div>';

        }  unset($r);   

      } else {
        Alerts:Mensajex("No tiene permisos para estar aqui","danger");
      }
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



  public function CuotaNoActivos($asociado){
    $db = new dbConn();
    $asoc = new Asociados();
    $fijas = new CuotasFijas();
        /// aqui verifico si tiene permisos 1 o 3
        if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 3) { 



      if($_SESSION["cuota_cantidad"] == NULL){ /// si no hay cuota se asignara valor 1
        $_SESSION["cuota_cantidad"] = 1;
      }

        if ($r = $db->select("cuota_minima", "precios", "WHERE td = ".$_SESSION["td"]."")) { 
            $cuota_minima = $r["cuota_minima"];
          } unset($r); 

       $total = $cuota_minima * $_SESSION["cuota_cantidad"];   

        echo '<div class="text-center"><h2>'.$asoc->AsociadoNombre($asociado).'</h2>';

        if($_SESSION["cuota_cantidad"] == 1){
        echo '<div class="d-inline-block">
        <i class="fas fa-ban fa-lg red-text"></i>
        </div>';
        } else {
        echo '<div class="d-inline-block">
        <a id="cambiarnumero" op="190" asociado="'.$asociado.'" accion="2"><i class="fas fa-minus-circle fa-lg blue-text"></i></a>
        </div>';
        }


        echo '<div class="d-inline-block ml-3 mr-3">
        <h1 class="display-1 z-depth-1-half"><strong>'.$_SESSION["cuota_cantidad"].'</strong></h1>
        </div>

        <div class="d-inline-block">
        <a id="cambiarnumero" op="190" asociado="'.$asociado.'" accion="1"><i class="fas fa-plus-circle fa-lg green-text"></i></a>
        </div>
            

            <p>Total a cancelar</p>    

                  <h1>'.Helpers::Dinero($total).'</h1>';

                  echo '<p>'.Dinero::DineroEscrito($total).'</p>'; 


                if($fijas->BuscarCuotas($asociado) == TRUE){

                  $ultima = $fijas->UltimaCuota($asociado);
                  $mes = Fechas::MesSuma("01-" . $ultima , $_SESSION["cuota_cantidad"]);

                    echo '<p><strong>Hasta '.Fechas::MesEscrito("01-". $mes) . " de " . Fechas::AnoFecha("01-". $mes).'</strong></p>';
                } else {
                  $ultima = date("m-Y");
                  $mes = Fechas::MesSuma("01-" . $ultima , $_SESSION["cuota_cantidad"]);


                    echo '<p><strong>Hasta '.Fechas::MesEscrito("01-". $mes) . " de " . Fechas::AnoFecha("01-".  $mes).'</strong></p>';
                }
                
                  
                echo '<a id="CobrarNoActivo" asociado="'.$asociado.'" op="250" cantidad="'.$_SESSION["cuota_cantidad"].'" cuota="'.$cuota_minima.'" class="btn btn-success btn-rounded">Cobrar</a>';
                

                echo '</div>';

        } else {
        Alerts:Mensajex("No tiene permisos para estar aqui","danger");
      }

  }

  


  public function CambiarNumero($asociado, $accion = NULL){

      if($_SESSION["cuota_cantidad"] != NULL and $accion == 1){
         $_SESSION["cuota_cantidad"] =  $_SESSION["cuota_cantidad"] + 1;
      }
      if($_SESSION["cuota_cantidad"] != NULL and $accion == 2 and $_SESSION["cuota_cantidad"] > 0){
         $_SESSION["cuota_cantidad"] =  $_SESSION["cuota_cantidad"] - 1;
      }

      if($_SESSION["cuota_cantidad"] == NULL and $accion == NULL){
        $_SESSION["cuota_cantidad"] = 1;
      }

      if($_SESSION["cuota_cantidad"] == 0){
        $_SESSION["cuota_cantidad"] = 1;
      }

      $this->CuotaNoActivos($asociado);
  }



  public function ModalPrecioAgua($contador){
    $db = new dbConn();


      echo '<h3>'.Helpers::Dinero($this->PrecioAgua($contador)).'</h3>';
      if($this->CompruebaOtroPrecio($contador) == FALSE){
        Alerts::Mensajex("Este contador tiene precio regular","info");
      } else {
        Alerts::Mensajex("Este contador ya cuenta con un precio especial","danger");
        echo '<a id="quitarprecio" contador="'.$contador.'" op="191"  class="btn btn-danger btn-rounded">Quitar Precio</a>';
      }
      
 
  }









} // Termina la lcase