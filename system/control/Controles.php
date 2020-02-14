<?php 
class Controles{

		public function __construct() { 
     	} 


	public function Clave(){
			$numero = sha1(Fechas::Format(date("d-m-Y")));
			$num = substr("$numero", 0, 6);
			 return $num;
	}



	public function CobrosMes($fecha){ /// para ver los gastos de un mes especifico // eje feha 05-2019
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM cuotas WHERE edo = 2 and td = ".$_SESSION["td"]." and fecha like '%-$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();

		    $x = $db->query("SELECT sum(cantidad) FROM cuotas_corte WHERE edo = 2 and td = ".$_SESSION["td"]." and fecha like '%-$fecha'");
		    foreach ($x as $y) {
		     $total2=$y["sum(cantidad)"];
		    } $x->close();


		    return $total + $total2;
	}



	public function CreditoPendiente(){ /// total de productos registrados
		$db = new dbConn();
	    $a = $db->query("SELECT sum(abono) FROM creditos_abonos WHERE edo = 1 and td = ".$_SESSION["td"]."");
		    foreach ($a as $b) {
		    $abonos = $b["sum(abono)"];
		} $a->close();

	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and tipo_pago = 3 and td = ".$_SESSION["td"]."");
		    foreach ($a as $b) {
		    $creditos = $b["sum(total)"];
		} $a->close();

		return 	$creditos - $abonos;

	}


	public function CuotasPendiente(){ /// total de productos registrados
		$db = new dbConn();
	    $a = $db->query("SELECT * FROM cuotas WHERE edo = 1 and td = ".$_SESSION["td"]."");
		$cuotas = $a->num_rows;
		$a->close();
		return 	$cuotas;

	}



 	public function CuotasCobradas($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT * FROM cuotas WHERE edo = 1 and td = ".$_SESSION["td"]." and fecha like '%-$fecha'");
		    $cuotas = $a->num_rows;
		$a->close();
		return $cuotas;
	}



	public function SuspencionesActivas(){ /// total de productos registrados
		$db = new dbConn();
	    $a = $db->query("SELECT * FROM cuotas_corte WHERE edo = 1 and td = ".$_SESSION["td"]."");
		$cuotas = $a->num_rows;
		$a->close();
		return 	$cuotas;

	}




	public function CuentaPorCobrar(){ 
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM cuotas WHERE edo = 1 and td = ".$_SESSION["td"]."");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();

		    $x = $db->query("SELECT sum(cantidad) FROM cuotas_corte WHERE edo = 1 and td = ".$_SESSION["td"]."");
		    foreach ($x as $y) {
		     $total2=$y["sum(cantidad)"];
		    } $x->close();


		    return $total + $total2;
	}










} // Termina la lcase