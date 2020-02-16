<?php 
class Config{

	public function __construct() { 
     } 


	public function Configuraciones($sistema,$cliente,$slogan,$propietario,$telefono,$direccion,$email,$pais,$giro,$nit,$imp,$nombre_impuesto,$nombre_documento,$moneda,$moneda_simbolo,$tipo_inicio,$skin,$inicio_tx,$otras_ventas,$cambio_tx){
		$db = new dbConn();

		$cambio = array();
	    $cambio["sistema"] = $sistema;
	    $cambio["cliente"] = $cliente;
	    $cambio["slogan"] = $slogan;
	    $cambio["propietario"] = $propietario;
	    $cambio["telefono"] = $telefono;
	    $cambio["direccion"] = $direccion;
	    $cambio["email"] = $email;
	    $cambio["pais"] = $pais;
	    $cambio["giro"] = $giro;
	    $cambio["nit"] = $nit;
	    $cambio["imp"] = $imp;
	    $cambio["nombre_impuesto"] = $nombre_impuesto;
	    $cambio["nombre_documento"] = $nombre_documento;
	    $cambio["moneda"] = $moneda;
	    $cambio["moneda_simbolo"] = $moneda_simbolo;
	    $cambio["tipo_inicio"] = $tipo_inicio;
	    $cambio["skin"] = $skin;
	    $cambio["inicio_tx"] = $inicio_tx;
	    $cambio["otras_ventas"] = $otras_ventas;
	    $cambio["cambio_tx"] = $cambio_tx;
	    $cambio["time"] = Helpers::TimeId();
	    if (Helpers::UpdateId("config_master", $cambio, "td = ".$_SESSION["td"]."")) {
	    	$this->CrearVariables();
	        Alerts::Alerta("success","Echo!","Registros actualizados correctamente");
	    } else {
	       Alerts::Alerta("error","Error!","Ocurrio un error desconocido!");   
	    }

	
	}



	public function Root($expira,$expiracion,$ftp_servidor,$ftp_path,$ftp_ruta,$ftp_user,$ftp_password,$tipo_sistema,$plataforma){
		$db = new dbConn();

		$cambio = array();
	    $cambio["expira"] = $expira;
	    $cambio["expiracion"] = $expiracion;
	    $cambio["ftp_servidor"] = $ftp_servidor;
	    $cambio["ftp_path"] = $ftp_path;
	    $cambio["ftp_ruta"] = $ftp_ruta;
	    $cambio["ftp_user"] = $ftp_user;
	    $cambio["ftp_password"] = $ftp_password;
	    $cambio["tipo_sistema"] = $tipo_sistema;
	    $cambio["plataforma"] = $plataforma;
	    $cambio["time"] = Helpers::TimeId();
	    if (Helpers::UpdateId("config_root", $cambio, "td = ".$_SESSION["td"]."")) {
	    	$this->CrearVariables();
	        Alerts::Alerta("success","Echo!","Registros actualizados correctamente");
	    } else {
	       Alerts::Alerta("error","Error!","Ocurrio un error desconocido!");   
	    }

	
	}
	


	



	public function CrearVariables(){
		$db = new dbConn();
		$encrypt = new Encrypt;

		if ($r = $db->select("*", "config_master", "WHERE td = ".$_SESSION['td']."")) { 

			$_SESSION['config_sistema'] = $r["sistema"];
			$_SESSION['config_cliente'] = $r["cliente"];
			$_SESSION['config_slogan'] = $r["slogan"];
			$_SESSION['config_propietario'] = $r["propietario"];
			$_SESSION['config_telefono'] = $r["telefono"];
			$_SESSION['config_giro'] = $r["giro"];
			$_SESSION['config_nit'] = $r["nit"];
			$_SESSION['config_imp'] = $r["imp"];
			$_SESSION['config_direccion'] = $r["direccion"];
			$_SESSION['config_email'] = $r["email"];
			$_SESSION['config_imagen'] = $r["imagen"]; // de la empresa
			$_SESSION['config_logo'] = $r["logo"]; // el de pizto
			$_SESSION['config_skin'] = $r["skin"];
			$_SESSION['tipo_inicio'] = $r["tipo_inicio"];

			$_SESSION['config_pais'] = $r["pais"];
			$_SESSION['config_moneda'] = $r["moneda"];
			$_SESSION['config_moneda_simbolo'] = $r["moneda_simbolo"];
			$_SESSION['config_nombre_impuesto'] = $r["nombre_impuesto"];
			$_SESSION['config_nombre_documento'] = $r["nombre_documento"];
			$_SESSION['tx'] = $r["inicio_tx"];
			$_SESSION['config_otras_ventas'] = $r["otras_ventas"];
			$_SESSION['config_cambio_tx'] = $r["cambio_tx"];

			if($_SESSION['config_skin'] == NULL) $_SESSION['config_skin'] = "mdb-skin";
			// white-skin , mdb-skin , grey-skin , pink-skin ,  light-blue-skin , black-skin  cyan-skin, navy-blue-skin

			// fixed-sn , hidden-sn
			} unset($r);

			    // para root pero sin descifrar
			if ($root = $db->select("*", "config_root", "WHERE td = ".$_SESSION['td']."")) {

			$_SESSION['root_expira'] = $root["expira"];
			$_SESSION['root_expiracion'] = $root["expiracion"];
			$_SESSION['root_tipo_sistema'] = $root["tipo_sistema"];
			$_SESSION['root_plataforma'] = $root["plataforma"];
     
			} unset($root);
			$_SESSION['root_tipo_sistema'] = $encrypt->Decrypt(
  			$_SESSION['root_tipo_sistema'],$_SESSION['secret_key']);

			$_SESSION['root_plataforma'] = $encrypt->Decrypt(
			$_SESSION['root_plataforma'],$_SESSION['secret_key']);

	}




public function VerPrecios(){
	$db = new dbConn();
   if ($r = $db->select("*", "precios", "WHERE td = ".$_SESSION['td']."")) { 

	echo '<table class="table table-sm table-striped">

   <thead>
     <tr>
       <th>Metros</th>
       <th>Mora</th>
       <th>Reconexion</th>
       <th>Cuota Minima</th>
       <th>Fecha Pago</th>
     </tr>
   </thead>';

	   echo '<tbody>
	     <tr>
	      <td>'.$r["mts"].'</td>
	      <td>'.$r["mora"].'</td>
	      <td>'.$r["reconexion"].'</td>
	      <td>'.$r["cuota_minima"].'</td>
	      <td>'.$r["fecha_ultima"].' De cada mes</td>   
	     </tr>
	    
	   </tbody>
	</table>';

    } unset($r);  

}


	public function AddPrecios($datos){
		$db = new dbConn();

if($datos["mts"] != NULL or $datos["mora"] != NULL or $datos["reonexion"] != NULL or $datos["fecha_submit"] != NULL){
		$cambio = array();
	    $cambio["mts"] = $datos["mts"];
	    $cambio["mora"] = $datos["mora"];
	    $cambio["reconexion"] = $datos["reconexion"];
	    $cambio["cuota_minima"] = $datos["cuota_minima"];
	    $cambio["fecha_ultima"] = $datos["fecha_submit"];
	    $cambio["hash"] = Helpers::HashId();
        $cambio["time"] = Helpers::TimeId();
	    if (Helpers::UpdateId("precios", $cambio, "td = ".$_SESSION["td"]."")) {
	        Alerts::Alerta("success","Echo!","Registros actualizados correctamente");
	    } else {
	       Alerts::Alerta("error","Error!","Ocurrio un error desconocido!");   
	    }
} else {
	Alerts::Alerta("error","Error!","Ocurrio un error desconocido!");
}
	$this-> VerPrecios();
	}













} // fin de la clase

 ?>