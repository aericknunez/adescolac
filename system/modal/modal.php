<style>
    body { 
        background-color: black; /* La página de fondo será negra */
        color: 000; 
    	}
</style>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($_REQUEST["modal"]=="registrar") include_once 'system/modal/modal/registrar.php';

if($_REQUEST["modal"]=="newpass") include_once 'system/modal/modal/user_cambiar_pass.php';

if($_REQUEST["modal"]=="userupdate") include_once 'system/modal/modal/user_update.php';
http://localhost/adescolac/?
if($_REQUEST["modal"]=="avatar") include_once 'system/modal/modal/avatar.php';

if($_REQUEST["modal"]=="conf_config") include_once 'system/modal/modal/conf_config.php';

if($_REQUEST["modal"]=="conf_root") include_once 'system/modal/modal/conf_root.php';

if($_REQUEST["modal"]=="img_negocio") include_once 'system/modal/modal/imagen_negocio.php';

if($_REQUEST["modal"]=="editasociado") include_once 'system/modal/modal/editar-asociado.php';


if($_REQUEST["modal"]=="Busqueda") include_once 'system/modal/modal/Busqueda.php';

