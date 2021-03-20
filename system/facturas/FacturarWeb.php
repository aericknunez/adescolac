<?php 
class FacturarWeb{




public function PagoCuota($hash){ /// obtiene el json que se envia a la impresora local
		$db = new dbConn();

$parametros["hash"] = $hash;
$parametros["tipoticket"] = 1;


if ($r = $db->select("*", "cuotas", "WHERE hash = '$hash'")) { 

$asociado = $r["asociado"];
$parametros["contador"] = $r["contador"];
$parametros["lectura_anterior"] = $r["lectura_anterior"];
$parametros["lectura_actual"] = $r["lectura_actual"];
$parametros["consumo"] = $r["consumo"];
$parametros["cantidad"] = $r["cantidad"];
$parametros["total"] = $r["total"];
$parametros["fecha"] = $r["fecha"];
$parametros["fechav"] = $r["fechav"];
$parametros["dia_cancel"] = $r["dia_cancel"];

} unset($r);  


if ($r = $db->select("nombre, direccion", "asociados", "WHERE hash = '$asociado'")) { 
$parametros["nombre_asociado"] = $r["nombre"];
$parametros["direccion_asociado"] = $r["direccion"];
} unset($r);  


echo json_encode($parametros);
		

}// termina le funcion









} // fin de la clase

 ?>


 