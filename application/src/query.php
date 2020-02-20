<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($_SESSION["td"] == 0){
$numero = rand(1,9999999999);	
} else {
$numero = 1;	
}

//$numero = 1;

if(isset($_GET["modal"])) { 
echo '
	<script>
		$(document).ready(function()
		{
		  $("#' . $_GET["modal"] . '").modal("show");
		});
	</script>
	';


	if($_GET["modal"] == "registrar"){
	echo '<script type="text/javascript" src="assets/js/query/login.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "newpass"){
	echo '<script type="text/javascript" src="assets/js/query/user.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "userupdate"){
	echo '<script type="text/javascript" src="assets/js/query/user.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "avatar"){
	echo '<script type="text/javascript" src="assets/js/query/user.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "conf_config"){
	echo '<script type="text/javascript" src="assets/js/query/conf_config.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "conf_root"){
	echo '<script type="text/javascript" src="assets/js/query/conf_config.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "img_negocio"){
	echo '<script type="text/javascript" src="assets/js/query/img_negocio.js?v='.$numero.'"></script>';
	}

	/// producto

	if($_GET["modal"] == "Busqueda"){
	echo '<script type="text/javascript" src="assets/js/query/Busqueda.js?v='.$numero.'"></script>';
	}

	/// asociado y contribucion
	if($_GET["modal"] == "editasociado"){
	echo '<script type="text/javascript" src="assets/js/query/asociado.js?v='.$numero.'"></script>';
	}




} // termina modal

elseif($_SESSION["caduca"] != 0) {
echo '<script type="text/javascript" src="assets/js/query/noacceso.js?v='.$numero.'"></script>';
} 

//config
elseif(isset($_GET["precios"])) {
echo '<script type="text/javascript" src="assets/js/query/conf_config.js?v='.$numero.'"></script>';
} 


elseif(isset($_GET["user"])) {
echo '<script type="text/javascript" src="assets/js/query/user.js?v='.$numero.'"></script>';
} 





//////////////// asociado
elseif(isset($_GET["asociadoadd"])) {
echo '<script type="text/javascript" src="assets/js/query/asociado.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["asociadover"])) {
echo '
<script type="text/javascript" src="assets/js/addons/datatables.min.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/asociadodatatable.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/asociado.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["asociaunidades"])) {
echo '
<script type="text/javascript" src="assets/js/addons/datatables.min.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/asociadodatatable.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/asociado.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["cuotas"])) {
echo '
<script type="text/javascript" src="assets/js/addons/datatables.min.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/asociadodatatable.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/asociado.js?v='.$numero.'"></script>';
}
elseif(isset($_GET["cuotaspendientes"])) {
//echo '<script type="text/javascript" src="assets/js/printThis.js?v='.$numero.'"></script>';
echo '
<script type="text/javascript" src="assets/js/addons/datatables.min.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/asociadodatatable.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/asociado.js?v='.$numero.'"></script>';
}
elseif(isset($_GET["ordenes_corte"])) {
//echo '<script type="text/javascript" src="assets/js/printThis.js?v='.$numero.'"></script>';
echo '
<script type="text/javascript" src="assets/js/addons/datatables.min.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/asociadodatatable.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/asociado.js?v='.$numero.'"></script>';
}
elseif(isset($_GET["asociados_no_activos"])) {
//echo '<script type="text/javascript" src="assets/js/printThis.js?v='.$numero.'"></script>';
echo '
<script type="text/javascript" src="assets/js/addons/datatables.min.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/asociadodatatable.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/asociado.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/asociado_no_activo.js?v='.$numero.'"></script>';
}
//////////////// contribuciones
elseif(isset($_GET["contribucionadd"])) {
echo '<script type="text/javascript" src="assets/js/query/contribucion.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["sanciones"])) {
echo '<script type="text/javascript" src="assets/js/query/sancion.js?v='.$numero.'"></script>';
} 

//////////////// conductor
elseif(isset($_GET["conductoradd"])) {
echo '<script type="text/javascript" src="assets/js/query/conductor.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["verconductores"])) {
echo '
<script type="text/javascript" src="assets/js/addons/datatables.min.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/datatable-all.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/conductor.js?v='.$numero.'"></script>';
}
elseif(isset($_GET["con_vencidos"])) {
echo '
<script type="text/javascript" src="assets/js/addons/datatables.min.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/datatable-all.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/conductor.js?v='.$numero.'"></script>';
}
elseif(isset($_GET["sancionesasig"])) {
echo '
<script type="text/javascript" src="assets/js/addons/datatables.min.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/datatable-all.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/conductor.js?v='.$numero.'"></script>';
}

//// gastos
elseif(isset($_GET["gastos"])) {
echo '<script type="text/javascript" src="assets/js/query/gastos.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["entradas"])) {
echo '<script type="text/javascript" src="assets/js/query/gastos.js?v='.$numero.'"></script>';
} 
//// corte
elseif(isset($_GET["corte"])) {
echo '<script type="text/javascript" src="assets/js/query/corte.js?v='.$numero.'"></script>';
} 

//// Historial
elseif(isset($_GET["consolidado"])) {
echo '<script type="text/javascript" src="assets/js/query/historial.js?v='.$numero.'"></script>';
echo '<script type="text/javascript" src="assets/js/query/historial_modal_gastos.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["rdiario"])) {
echo '<script type="text/javascript" src="assets/js/query/historial.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["vdiario"])) {
echo '<script type="text/javascript" src="assets/js/query/historial.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["vmensual"])) {
echo '<script type="text/javascript" src="assets/js/query/historial.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["hcortes"])) {
echo '<script type="text/javascript" src="assets/js/query/historial.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["gdiario"])) {
echo '<script type="text/javascript" src="assets/js/query/historial.js?v='.$numero.'"></script>';
echo '<script type="text/javascript" src="assets/js/query/historial_modal_gastos.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["gmensual"])) {
echo '<script type="text/javascript" src="assets/js/query/historial.js?v='.$numero.'"></script>';
echo '<script type="text/javascript" src="assets/js/query/historial_modal_gastos.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["gra_semanal"])) include_once 'assets/js/query/gra_semanal.php';
elseif(isset($_GET["gra_mensual"])) include_once 'assets/js/query/gra_mensual.php';
elseif(isset($_GET["gra_clientes"])) include_once 'assets/js/query/gra_clientes.php';
elseif(isset($_GET["gra_semestre"])) include_once 'assets/js/query/gra_semestre.php';





else{

echo '<script type="text/javascript" src="assets/js/query/reload_lateral.js?v='.$numero.'"></script>';

echo '<script type="text/javascript" src="assets/js/query/control.js?v='.$numero.'"></script>';
include_once 'assets/js/query/gra_control.php'; // acativar despues
}
	
?>

<script>
	
	$("body").on("click","#cambiar",function(){
        var op = $(this).attr('op');
        $.post("application/src/routes.php", {op:op}, 
        	function(htmlexterno){
            window.location.href="?";
        });
    });	


// preloader
    $(window).on("load", function () {
        $('#mdb-preloader').fadeOut('fast');
    });


</script>
