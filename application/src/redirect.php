<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($_SESSION["caduca"] != 0) include_once 'system/index/noacceso.php';

elseif(isset($_GET["modal"])) include_once 'system/modal/modal.php';

elseif(isset($_GET["user"])) include_once 'system/user/user.php';

elseif(isset($_GET["configuraciones"])) include_once 'system/config_configuraciones/configuraciones.php';
elseif(isset($_GET["precios"])) include_once 'system/config_configuraciones/precios.php';

elseif(isset($_GET["root"])  and $_SESSION['tipo_cuenta'] == "1") include_once 'system/config_configuraciones/root.php';
elseif(isset($_GET["tablas"])) include_once 'system/config_configuraciones/tablas.php';


// asociados
elseif(isset($_GET["asociadoadd"])) include_once 'system/asociado/asociados.php'; // agregar asociado
elseif(isset($_GET["asociadover"])) include_once 'system/asociado/asociadover.php'; // ver asociados
elseif(isset($_GET["asociaunidades"])) include_once 'system/asociado/verunidades.php'; // ver unidades
elseif(isset($_GET["cuotas"])) include_once 'system/asociado/cuotas.php'; // ver unidades
elseif(isset($_GET["cuotaspendientes"])) include_once 'system/asociado/cuotas_pendientes.php'; // ver unidades
elseif(isset($_GET["productos_asociado"])) include_once 'system/asociado/productos_asociado.php'; // producto com asoc
elseif(isset($_GET["ordenes_corte"])) include_once 'system/asociado/ordenes_corte.php'; // ver unidades
elseif(isset($_GET["asociados_no_activos"])) include_once 'system/asociado/asociados_no_activos.php'; // ver unidades


// contribuciones
elseif(isset($_GET["contribucionadd"])) include_once 'system/contribucion/contribuciones.php'; // agregar asociado
elseif(isset($_GET["sanciones"])) include_once 'system/contribucion/sanciones.php'; // agregar asociado


// Conductore
elseif(isset($_GET["conductoradd"])) include_once 'system/conductores/conductores.php'; 
elseif(isset($_GET["verconductores"])) include_once 'system/conductores/conductoresver.php';
elseif(isset($_GET["con_vencidos"])) include_once 'system/conductores/vencidos.php';
elseif(isset($_GET["sancionesasig"])) include_once 'system/conductores/sancionados.php';



// Gastos y compras
elseif(isset($_GET["gastos"])) include_once 'system/gastos/gastos.php'; 
elseif(isset($_GET["entradas"])) include_once 'system/gastos/entradas.php'; 


// Corte Diario
elseif(isset($_GET["corte"])) include_once 'system/corte/cortes.php'; 



// Historia;
elseif(isset($_GET["consolidado"])) include_once 'system/historial/consolidado_diario.php';
elseif(isset($_GET["vdiario"])) include_once 'system/historial/vdiario.php'; 
elseif(isset($_GET["vmensual"])) include_once 'system/historial/vmensual.php'; 
elseif(isset($_GET["hcortes"])) include_once 'system/historial/hcortes.php'; 
elseif(isset($_GET["gdiario"])) include_once 'system/historial/gdiario.php'; 
elseif(isset($_GET["gmensual"])) include_once 'system/historial/gmensual.php'; 

// graficos;
elseif(isset($_GET["gra_semanal"])) include_once 'system/historial/gra_semanal.php';
elseif(isset($_GET["gra_mensual"])) include_once 'system/historial/gra_mensual.php';
elseif(isset($_GET["gra_clientes"])) include_once 'system/historial/gra_clientes.php';
elseif(isset($_GET["gra_semestre"])) include_once 'system/historial/gra_semestre.php';



// Panel de Control
elseif(isset($_GET["control"])) include_once 'system/control/control.php';


else{

	if(Helpers::ServerDomain() == TRUE){
		include_once 'system/control/control.php';
	} else{
		include_once 'system/index/index.php';
	}

}
	
?>