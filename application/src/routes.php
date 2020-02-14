<?php
include_once '../common/Helpers.php'; // [Para todo]
include_once '../includes/variables_db.php';
include_once '../common/Mysqli.php';
$db = new dbConn();
include_once '../includes/DataLogin.php';
$seslog = new Login();
$seslog->sec_session_start();





include_once '../common/Alerts.php';
$alert = new Alerts;
$helps = new Helpers;
include_once '../common/Fechas.php';
include_once '../common/Encrypt.php';


// filtros para cuando no hay session abierta
if ($seslog->login_check() != TRUE) {
echo '<script>
	window.location.href="application/includes/logout.php"
</script>';
} 

if($_SESSION["user"] == NULL and $_SESSION["td"] == NULL){
echo '<script>
	window.location.href="application/includes/logout.php"
</script>';
exit();
}
//





/// usuarios

if($_REQUEST["op"]=="0"){ // redirecciona despues de registrar a llenar datos
	include_once '../includes/DataLogin.php';
	$seslog->Register($_POST);

}


if($_REQUEST["op"]=="1"){ // cambia el password
include_once '../../system/user/Usuarios.php';
$usuarios = new Usuarios;
$passw1 = filter_input(INPUT_POST, 'pass1', FILTER_SANITIZE_STRING);
$passw2 = filter_input(INPUT_POST, 'pass2', FILTER_SANITIZE_STRING);
$usuarios->CompararPass($passw1, $passw2); 
}


if($_REQUEST["op"]=="2"){ // terminar usuario
	if($_POST["nombre"] != NULL && $_POST["tipo"] != NULL){
	include_once '../../system/user/Usuarios.php';
	$usuarios = new Usuarios;
	$usuarios->TerminarUsuario(Helpers::Mayusculas($_POST["nombre"]),$_POST["tipo"],sha1($_POST["user"]));	
	} else {
	Alerts::Alerta("error","Error!","Faltan Datos!");	
	}
}



if($_REQUEST["op"]=="3"){ // terminar actualizar
	if($_POST["nombre"] != NULL && $_POST["tipo"] != NULL){
	include_once '../../system/user/Usuarios.php';
	$usuarios = new Usuarios;
	$usuarios->ActualizarUsuario(Helpers::Mayusculas($_POST["nombre"]),$_POST["tipo"],sha1($_POST["user"]));	
	} else {
	Alerts::Alerta("error","Error!","Faltan Datos!");	
	}
}


if($_REQUEST["op"]=="4"){ // cambiar avatar
include_once '../../system/user/Usuarios.php';
	$usuarios = new Usuarios;
	$usuarios->CambiarAvatar($_REQUEST["iden"],$_REQUEST["user"]);
}



if($_REQUEST["op"]=="5"){ // pregunta si elimina el usuario
include_once '../../system/user/Usuarios.php';
$usuarios = new Usuarios;
$alert->EliminarUsuario($_REQUEST["iden"], $_REQUEST["username"]);

}


if($_REQUEST["op"]=="6"){ // elimina el usuario
include_once '../../system/user/Usuarios.php';
$usuarios = new Usuarios;
$usuarios->EliminarUsuario($_REQUEST["iden"], $_REQUEST["username"]);
}



// confiuraciones
if($_REQUEST["op"]=="10"){ // agregar datos de configuracion
	include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;

	if($_POST["pais"] == 1){
		$moneda = "Dolares"; $simbolo = "$"; $imp = "IVA"; $doc = "NIT";
	}if($_POST["pais"] == 2){
		$moneda = "Lempiras"; $simbolo = "L"; $imp = "ISV"; $doc = "RTN";
	}if($_POST["pais"] == 3){
		$moneda = "Quetzales"; $simbolo = "Q"; $imp = "IVA"; $doc = "NIT";
	}

	$configuracion->Configuraciones($_POST["sistema"],
									$_POST["cliente"],
									$_POST["slogan"],
									$_POST["propietario"],
									$_POST["telefono"],
									$_POST["direccion"],
									$_POST["email"],
									$_POST["pais"],
									$_POST["giro"],
									$_POST["nit"],
									$_POST["imp"],
									$imp,
									$doc,
									$moneda,
									$simbolo,
									$_POST["tipo_inicio"],
									$_POST["skin"],
									$_POST["inicio_tx"],
									$_POST["otras_ventas"],
									$_POST["cambio_tx"]);
}

if($_REQUEST["op"]=="11"){  // agregar datos de root
include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;

	include_once '../common/Encrypt.php';
	$configuracion->Root(Encrypt::Encrypt($_POST["expira"],$_SESSION['secret_key']),
		Encrypt::Encrypt(Fechas::Format($_POST["expira"]),$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["ftp_servidor"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["ftp_path"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["ftp_ruta"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["ftp_user"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["ftp_password"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["tipo_sistema"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["plataforma"],$_SESSION['secret_key']));
}


if($_REQUEST["op"]=="12"){ // Subir imagen negocio
include("../common/Imagenes.php");
	$imagen = new upload($_FILES['archivo']);
include("../common/ImagenesSuccess.php");
$imgs = new Success();

	if($imagen->uploaded) {
		if($imagen->image_src_y > 800 or $imagen->image_src_x > 800){ // si ancho o alto es mayir a 800
			$imagen->image_resize         		= true; // default is true
			$imagen->image_ratio        		= true; // para que se ajuste dependiendo del ancho definido
			$imagen->image_x              		= 700; // para el ancho a cortar
			$imagen->image_y              		= 700; // para el alto a cortar
		}
		$imagen->file_new_name_body   		= Helpers::TimeId(); // agregamos un nuevo nombre
		// $imagen->image_watermark      		= 'watermark.png'; // marcado de agua
		// $imagen->image_watermark_position 	= 'BR'; // donde se ub icara el marcado de agua. Bottom Right		
		$imagen->process('../../assets/img/logo/');	

		$imgs->SaveImagen($imagen->file_dst_name, $imagen->image_dst_x, $imagen->image_dst_y);
		$_SESSION['config_imagen'] = $imagen->file_dst_name; // cambio el logo de la variable
	} // [file_dst_name] nombre de la imagen
	else {
	  Alerts::Alerta("error","Error!","Error: " . $imagen->error);
	  $imgs->VerImgNegocio("assets/img/logo/");
	}

}


///////////// modifica las tablas del sync
if($_REQUEST["op"]=="13"){
	include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;
	$configuracion->AddPrecios($_POST);
}



//////////// cambios de funcion
if($_REQUEST["op"]=="15"){ /// cambia de rapido a lento

	if($_SESSION["tipo_inicio"] == 1){
		$_SESSION["tipo_inicio"] = 2;
	} else {
		$_SESSION["tipo_inicio"] = 1;
	}
}


/// subir imagen de producto
if($_REQUEST["op"]=="16"){
include("../common/Imagenes.php");
	$imagen = new upload($_FILES['archivo']);
include("../common/ImagenesSuccess.php");
$imgs = new Success();

	if($imagen->uploaded) {
		if($imagen->image_src_y > 800 or $imagen->image_src_x > 800){ // si ancho o alto es mayir a 800
			$imagen->image_resize         		= true; // default is true
			$imagen->image_ratio        		= true; // para que se ajuste dependiendo del ancho definido
			$imagen->image_x              		= 800; // para el ancho a cortar
			$imagen->image_y              		= 800; // para el alto a cortar
		}
		$imagen->file_new_name_body   		= Helpers::TimeId(); // agregamos un nuevo nombre
		// $imagen->image_watermark      		= 'watermark.png'; // marcado de agua
		// $imagen->image_watermark_position 	= 'BR'; // donde se ub icara el marcado de agua. Bottom Right		
		$imagen->process('../../assets/img/productos/');	

		$imgs->SaveProducto($_POST['producto'], $imagen->file_dst_name, $_POST['descripcion'], $imagen->image_dst_x, $imagen->image_dst_y);

	} // [file_dst_name] nombre de la imagen
	else {
	  echo 'error : ' . $imagen->error;
	  $imgs->VerProducto($_POST['producto'], "assets/img/productos/");
	}	
}

/// Eliminar imagen
if($_REQUEST["op"]=="17"){ // agrega primeros datos del producto
include("../common/ImagenesSuccess.php");
	$imgs = new Success();
	$imgs->BorrarImagen($_REQUEST['hash'], "../../assets/img/productos/", $_REQUEST['producto']);
}

//// ver imagen desde ajax
if($_REQUEST["op"]=="18"){ 
include_once '../common/ImagenesSuccess.php';
$imgs = new Success();
$imgs->VerImg($_REQUEST["key"], "assets/img/productos/");
}





///////////////////////// corte /////////////////

if($_REQUEST["op"]=="115"){ // corte preguntar
	if($_POST["efectivo"] ==  NULL){
		Alerts::Alerta("error","Error!","El Formulario esta vacio");
	} else {
		Alerts::RealizarCorte("ejecuta-corte","116",$_POST["efectivo"]);
	}
}

if($_REQUEST["op"]=="116"){ // ejecuta corte
include_once '../../system/corte/Corte.php';
//include_once '../../system/sync/Sync.php';
$cortes = new Corte;
if($_POST["fecha"] == NULL){ $fecha = date("d-m-Y"); 
} else {
   $fecha = $_POST["fecha"];
}
$cortes->Execute($_POST["efectivo"], $fecha);
}



if($_REQUEST["op"]=="117"){ // ver el contenido
	include_once '../../system/corte/Corte.php';
	//include_once '../../system/sync/Sync.php';
	$cortes = new Corte;
	$cortes->Contenido(date("d-m-Y"));
}


if($_REQUEST["op"]=="118"){ // cancelar corte
	include_once '../../system/corte/Corte.php';
	$cortes = new Corte;
	if($_POST["fecha"] == NULL){ $fecha = date("d-m-Y"); 
	} else {
	   $fecha = $_POST["fecha"];
	}
	$cortes->CancelarCorte($_POST["random"], $fecha);

}




//// historial ///////////////////////////////////////////////


if($_REQUEST["op"]=="124"){ // consolidad diario
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
	
	if($_POST["fecha_submit"] == NULL){ $fecha = date("d-m-Y"); 
	} else { $fecha = $_POST["fecha_submit"]; }
	
	$historial->ConsolidadoDiario($fecha);
}

if($_REQUEST["op"]=="125"){ // historial diario
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
	
	if($_POST["fecha_submit"] == NULL){ $fecha = date("d-m-Y"); 
	} else { $fecha = $_POST["fecha_submit"]; }
	
	$historial->HistorialDiario($fecha);
}



if($_REQUEST["op"]=="126"){ // ventas mensual
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
		$fecha=$_POST["mes"];
		@$ano=$_POST["ano"];
		$fechax="-$fecha-$ano";

	$historial->HistorialMensual($fechax);
}


// cortes
if($_REQUEST["op"]=="127"){ // historial cortes
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
	if($_POST["fecha1_submit"]){
		$inicio = $_POST["fecha1_submit"]; $fin=$_POST["fecha2_submit"];
	} else {
		$inicio = date("01-m-Y"); $fin=date("31-m-Y");
	}
	
	$historial->HistorialCortes($inicio, $fin);
}



if($_REQUEST["op"]=="128"){ // gasto diario
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
	if($_POST["fecha_submit"] == NULL){ $fecha = date("d-m-Y"); } 
	else { 		$fecha = $_POST["fecha_submit"]; }
	
	$historial->HistorialGDiario($fecha);
}



if($_REQUEST["op"]=="129"){ // gastos mensual
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
		$fecha=$_POST["mes"];
		@$ano=$_POST["ano"];
		$fechax="-$fecha-$ano";

	$historial->HistorialGMensual($fechax);
}


if($_REQUEST["op"]=="130"){ // validar el sistema
$_SESSION["caduca"] = 0;
echo '<script>
	window.location.href="?"
</script>';
}


if($_REQUEST["op"]=="131"){ // validar codigo de sistema
include_once '../common/Encrypt.php';
include_once '../../system/index/Inicio.php';
$inicio = new Inicio;
$inicio->Validar($_POST["fecha_submit"], $_POST["codigo"]);
	
}








///////////////gastos
if($_REQUEST["op"]=="170"){ 
include_once '../../system/gastos/Gasto.php';
	$gastos = new Gastos;
	$gastos->AddGasto($_POST);
}

if($_REQUEST["op"]=="171"){ 
include_once '../../system/gastos/Gasto.php';
	$gastos = new Gastos;
	$gastos->BorrarGasto($_POST["iden"]);

}

if($_REQUEST["op"]=="172"){  // entrada de efectivo
include_once '../../system/gastos/Gasto.php';
	$gastos = new Gastos;
	$gastos->AddEfectivo($_POST);
}


if($_REQUEST["op"]=="173"){ 
include_once '../../system/gastos/Gasto.php';
	$gastos = new Gastos;
	$gastos->BorrarEfectivo($_POST["iden"]);

}

/// subir imagen de producto
if($_REQUEST["op"]=="174"){
include("../common/Imagenes.php");
	$imagen = new upload($_FILES['archivo']);
include("../common/ImagenesSuccess.php");
$imgs = new Success();

	if($imagen->uploaded) {
		if($imagen->image_src_y > 800 or $imagen->image_src_x > 800){ // si ancho o alto es mayir a 800
			$imagen->image_resize         		= true; // default is true
			$imagen->image_ratio        		= true; // para que se ajuste dependiendo del ancho definido
			$imagen->image_x              		= 800; // para el ancho a cortar
			$imagen->image_y              		= 800; // para el alto a cortar
		}
		$imagen->file_new_name_body   		= Helpers::TimeId() . "-" . $_SESSION["td"]; // agregamos un nuevo nombre
		// $imagen->image_watermark      		= 'watermark.png'; // marcado de agua
		// $imagen->image_watermark_position 	= 'BR'; // donde se ub icara el marcado de agua. Bottom Right		
		$imagen->process('../../assets/img/gastosimg/');	

		$imgs->SaveGasto($_POST['codigo'], $imagen->file_dst_name, $_POST['descripcion']);

	} // [file_dst_name] nombre de la imagen
	else {
	  echo 'error : ' . $imagen->error;
	  $imgs->VerImagenGasto($_POST['codigo']);
	}	
}


if($_REQUEST["op"]=="175"){ 
include("../common/ImagenesSuccess.php");
	$imgs = new Success();
	$imgs->VerImagenGasto($_REQUEST['gasto'], $_REQUEST['iden']);
	$imgs->ImagenesGasto($_REQUEST['gasto']);
}


if($_REQUEST["op"]=="176"){ 
include("../common/ImagenesSuccess.php");
	$imgs = new Success();
	$imgs->VerImagenGasto($_REQUEST['gasto'], $_REQUEST['iden']);
	$imgs->ImagenesGasto($_REQUEST['gasto']);
}




/////////////////////// asociado

if($_REQUEST["op"]=="184"){ // agregar asociado
include_once '../../system/asociado/Asociado.php';
	$asociado = new Asociados;
	$asociado->AddAsociado($_POST);
}

if($_REQUEST["op"]=="185"){ // elimina asociado
include_once '../../system/asociado/Asociado.php';
	$asociado = new Asociados;
	$asociado->DelAsociado($_REQUEST["hash"]);
}

if($_REQUEST["op"]=="186"){ // elimina asociado desde liasta completa
include_once '../../system/asociado/Asociado.php';
	$asociado = new Asociados;
	$asociado->DelAsociadox($_REQUEST["hash"]);
}

if($_REQUEST["op"]=="187"){ // actualizar asociado
include_once '../../system/asociado/Asociado.php';
	$asociado = new Asociados;
	$asociado->UpAsociado($_POST);
}


if($_REQUEST["op"]=="188"){ // ver asociado
include_once '../../system/asociado/Asociado.php';
	$asociado = new Asociados;
	$asociado->VistaAsociado($_POST);
}



if($_REQUEST["op"]=="189"){ // ver asociado
include_once '../../system/asociado/Asociado.php';
include_once '../../system/cuotas/Cuotas.php';
	$asociado = new Asociados;
	$asociado->DatosAsociado($_POST);
}




//195
if($_REQUEST["op"]=="195"){ // ver unidades
include_once '../../system/asociado/Asociado.php';
	$asociado = new Asociados;
	$asociado->VerUnidades($_POST["key"]);
}


if($_REQUEST["op"]=="196"){ // add unidades
include_once '../../system/asociado/Asociado.php';
	$asociado = new Asociados;
	$asociado->AddUnidades($_POST);
}
if($_REQUEST["op"]=="197"){ // elimina asociado
include_once '../../system/asociado/Asociado.php';
	$asociado = new Asociados;
	$asociado->DelUnidad($_REQUEST["hash"], $_REQUEST["asociado"]);
}











///////////// comienza lo de las cuotas
if($_REQUEST["op"]=="200"){ 
include_once '../../system/cuotas/Cuotas.php';
	$asociado = new Cuotas;
	$asociado->AddCuota($_POST);
}

/// modal pagar
if($_REQUEST["op"]=="201"){ 
include_once '../../system/cuotas/Cuotas.php';
include_once '../../system/asociado/Asociado.php';
	$asociado = new Cuotas;
	$asociado->Pagar($_POST);
}

//// cobrar
if($_REQUEST["op"]=="202"){ 
include_once '../../system/cuotas/Cuotas.php';
	$asociado = new Cuotas;
	$asociado->Cobrar($_POST);
}

//// modal de orde de corte. del total
if($_REQUEST["op"]=="203"){ 
include_once '../../system/cuotas/Cuotas.php';
include_once '../../system/asociado/Asociado.php';
	$asociado = new Cuotas;
	$asociado->OrdenModal($_POST);
}

//// cobrar
if($_REQUEST["op"]=="204"){ 
include_once '../../system/cuotas/Cuotas.php';
	$asociado = new Cuotas;
	$asociado->CobrarSuspencion($_POST);
}








/////////
$db->close();
?>