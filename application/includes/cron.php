<?php
date_default_timezone_set('America/El_Salvador');

define("HOST", "localhost"); 			//35.225.56.157 The host you want to connect to. 
define("USER", "superpol_erick"); 			// The database username. 
define("PASSWORD", "caca007125-"); 	// The database password. 
define("DATABASE", "superpol_acamsal");  

require_once("/home/superpol/public_html/pizto.com/acamsal/application/common/Mysqli.php");
$db = new dbConn();


