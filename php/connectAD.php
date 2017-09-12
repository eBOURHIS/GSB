<?php

	include "AccesDonnees.php";
	
	$ip=explode(".",$_SERVER['SERVER_ADDR']);

	switch ($ip[0]) {
		
	    case 127 :
		case 172 :
		    //Cloud9
		    $host = "127.0.0.1";
			$user = "root";
			$password = "";
			$dbname = "gsb_frais";
			$port='3306';
			break;
			
		case 192 :
			//local
			$host = "127.0.0.1";
			$user = "root";
			$password = "";
			$dbname = "SI6";
			$port='3306';
			break;
	
		case 31 :
			//hostinger
			$host = "mysql.hostinger.fr";
			$user = "u291192831_user";
			$password = "iroise29";
			$dbname = "u291192831_si6";
			$port='3306';
			break;
	    
		default :
			exit ("Serveur non reconnu...");
			break;
	}
	
	$connexion=connexion($host,$port,$dbname,$user,$password);
	
/*	if ($connexion) {
		echo "Connexion reussie<br />";
		echo "Base $dbname selectionnee... <br />";
		echo "Mode acces : $modeacces";
	}
*/	
?>

