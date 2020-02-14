<?php
include_once '../application/common/Helpers.php'; // [Para todo]
include_once '../application/includes/variables_db.php';
include_once '../application/common/Mysqli.php';
include_once '../application/includes/DataLogin.php';
$db = new dbConn();
$seslog = new Login();
$seslog->sec_session_start();
include_once '../application/common/Fechas.php';


// busco el numero de local

    if ($r = $db->select("td", "config_root", "WHERE id = 1")) { 
        $_SESSION["temporal_td"] = $r["td"];
    } unset($r);  



// busca la fecha de vencimiento de cada cuota
    $aw = $db->query("SELECT * FROM precios WHERE  td = ".$_SESSION["temporal_td"]."");
    foreach ($aw as $bw) {
    	$vence = $bw["fecha_ultima"];
    	$mora = $bw["mora"];
    	$reconexion = $bw["reconexion"];
    } $aw->close();


/// si ya vencio entonces hago todo, sino se acaba el script
if($vence < date("d")){


    $a = $db->query("SELECT * FROM cuotas WHERE edo = 1 and vencido = 0 and td = ".$_SESSION["temporal_td"]."");
    foreach ($a as $b) {

              $data["vencido"] = 1;
              $data["mora"] = $mora;
              $data["total"] = $b["total"] + $mora;
              Helpers::UpdateId("cuotas", $data, "hash = '".$b["hash"]."' and td = ".$_SESSION["temporal_td"]."");      


$ap = $db->query("SELECT * FROM cuotas WHERE contador = '".$b["contador"]."' and edo = 1 and vencido = 0 and td = ".$_SESSION["temporal_td"]."");
$cantidad = $ap->num_rows;
$ap->close();

	if($cantidad == 3){

		$af = $db->query("SELECT * FROM cuotas_corte WHERE contador = '".$b["contador"]."' and edo = 1 and td = ".$_SESSION["temporal_td"]."");
		$cant = $af->num_rows;
		$af->close();
		
			if($cantidad == 0){
				    $datos = array();
				    $datos["asociado"] = $b["asociado"];
				    $datos["contador"] = $b["contador"];
				    $datos["cantidad"] = $reconexion;
				    $datos["fecha"] = date("d-m-Y");
				    $datos["fechaF"] = Fechas::Format(date("d-m-Y"));
				    $datos["edo"] = 1;
				    $datos["hash"] = Helpers::HashId();
               		$datos["time"] = Helpers::TimeId();
               		$datos["td"] = $_SESSION["temporal_td"];
				    $db->insert("cuotas_corte", $datos);
			}	    

	}



    } $a->close();

      




} // termina vence

