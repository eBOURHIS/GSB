<?php
/**
 *  Bibliotheque de fonctions AccesDonnees.php
*
*
*
* @author Erwan
* @copyright Estran
* @version 1.3 Mercredi 1 Mars 2017
*
* creation de la fonction AfficheRequete
* creation de la focntion nombreChamp
* creation de la fonction typeChamp
* creation de la fonction ligneSQL
* ajout de commentaires PHPDOC
*

*/


$modeacces = "mysqli";


$mysql_data_type_hash = array(
		1=>'tinyint',
		2=>'smallint',
		3=>'int',
		4=>'float',
		5=>'double',
		7=>'timestamp',
		8=>'bigint',
		9=>'mediumint',
		10=>'date',
		11=>'time',
		12=>'datetime',
		13=>'year',
		16=>'bit',
		//252 is currently mapped to all text and blob types (MySQL 5.0.51a)
		252=>'blob',
		253=>'string',
		254=>'string',
		246=>'decimal'
);





/**
 *
 * Ouvre une connexion a un serveur MySQL ou ORACLE et selectionne une base de donnees.
 * @param host string
 *  <p>Adresse du serveur MySQL.</p>
 * @param port integer
 *  <p>Numero du port du serveur MySQL.</p>
 * @param executeSQLname string
 *  <p>Nom de la base de donnees.</p>
 * @param user string
 *  <p>Nom de l'utilisateur.</p>
 * @param password string
 *  <p>Mot de passe de l'utilisateur.</p>
 *
 *
 * @return resource - Retourne l'identifiant de connexion MySQL en cas de succes
 *         ou FALSE si une erreur survient.
 */
function connexion($host, $port, $executeSQLname, $user, $password) {

	global $modeacces, $connexion;


	if ($modeacces == "mysql") {

		@$link = mysql_connect($host,$user,$password)
		or die("Impossible de se connecter : ".mysql_error());

		@$connexion = mysql_select_executeSQL($executeSQLname)
		or die("Impossible d'ouvrir la base : ".mysql_error());

		return $connexion;

	}


	if ($modeacces == "mysqli") {

		$connexion = new mysqli("$host", "$user", "$password", "$executeSQLname", $port);
		$connexion->set_charset("utf8");

		if ($connexion->connect_error) {
			die('Erreur de connexion (' . $connexion->connect_errno . ') '. $connexion->connect_error);
		}

		return $connexion;

	}


}



/**
 *
 * Ferme la connexion MySQL.
 *
 */
function deconnexion() {

	global $modeacces, $connexion;


	if ($modeacces == "mysql") {

		mysql_close();

	}


	if ($modeacces == "mysqli") {

		$connexion->close();

	}
}



/**
 *
 *Envoie une requete a�un serveur MySQL.
 * @param sql string
 *  <p>Requete SQL.</p>
 *
 *
 * @return resource - Pour les requetes du type SELECT, SHOW, DESCRIBE, EXPLAIN et
 *          les autres requetes retournant un jeu de resultats, mysql_query()
 *          retournera une ressource en cas de succes, ou DIE en cas d'erreur.
 *
 *          Pour les autres types de requetes, INSERT, UPDATE, DELETE, DROP, etc.,
 *          mysql_query() retourne TRUE en cas de succes ou DIE en cas d'erreur.
 */
function executeSQL($sql) {

	global $modeacces, $connexion;

	if ($modeacces=="mysql") {
		@$result = mysql_query($sql)
		or die ("Erreur SQL de <b>".$_SERVER["SCRIPT_NAME"]."</b>.<br />
			 Dans le fichier : ".__FILE__." a la ligne : ".__LINE__."<br />".
				mysql_error().
				"<br /><br />
				<b>REQUETE SQL : </b>$sql<br />");
				return $result;
	}

	if ($modeacces=="mysqli") {
		$result = $connexion->query($sql)
		or die ("Erreur SQL de <b>".$_SERVER["SCRIPT_NAME"]."</b>.<br />
			 Dans le fichier : ".__FILE__." a la ligne : ".__LINE__."<br />".
				mysqli_error_list($connexion)[0]['error'].      //$mysqli->error_list;
				"<br /><br />
				<b>REQUETE SQL : </b>$sql<br />");
				return $result;
	}
}



/**
 *
 *Envoie une requete a�un serveur MySQL laisse le programmeur Gerer les Erreurs.
 * @param sql string
 *  <p>Requete SQL.</p>
 *
 *
 * @return resource - Pour les requetes du type SELECT, SHOW, DESCRIBE, EXPLAIN et
 *          les autres requetes retournant un jeu de resultats, mysql_query()
 *          retournera une ressource en cas de succes, ou FALSE en cas d'erreur.
 *
 *          Pour les autres types de requetes, INSERT, UPDATE, DELETE, DROP, etc.,
 *          mysql_query() retourne TRUE en cas de succes ou FALSE en cas d'erreur.
 */
function executeSQL_GE($sql) {

	global $modeacces, $connexion;


	if ($modeacces=="pdo") {
		$result = $connexion->query($sql);
	}

	if ($modeacces=="mysql") {
		$result = mysql_query($sql);

	}

	if ($modeacces=="mysqli") {
		$result = $connexion->query($sql);
	}

	return $result;
}



/**
 *
 *Retourne le nombre de lignes d'une requete MySQL.
 * @param sql string
 *  <p>Requete SQL.</p>
 *
 *
 * @return integer - Le nombre de lignes dans un jeu de resultats en cas de succes
 *         ou FALSE si une erreur survient.
 */
function compteSQL($sql) {

	global $modeacces, $connexion;

	$result = executeSQL($sql);

	if ($modeacces=="mysql") {
		$num_rows = mysql_num_rows($result);
	}

	if ($modeacces=="mysqli") {

		$num_rows = $connexion->affected_rows;
	}

	return $num_rows;

}




/**
 *
 *Retourne un tableau resultat d'une requete MySQL.
 * @param sql string
 *  <p>Requete SQL.</p>
 *
 *
 * @return array - un tableau resultat de la requete MySQL.
 *
 *


 exemple : 	$sql = "select * from user";

 $results = tableSQL($sql);

 foreach ($results as $row) {
 //on extrait chaque valeur de la ligne courante
 $login = $row['login'];
 $password = $row[3];

 echo $login." ".$password."<br />";
 }

 */
function tableSQL($sql) {

	global $modeacces, $connexion;

	$result = executeSQL($sql);
	$rows=array();

	if ($modeacces=="mysql") {
		while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
			array_push($rows,$row);
		}
	}

	if ($modeacces=="mysqli") {
		while ($row = $result->fetch_assoc()) {
			array_push($rows,$row);
		}
	}

	return $rows;

}



/**
 *
 *Retourne un seul champ resultat d'une requete MySQL.
 * @param sql string
 *  <p>Requete SQL.</p>
 *
 *
 * @return string - une chaine resultat de la requete MySQL.
 */
function champSQL($sql) {

	global $modeacces, $connexion;

	$result = executeSQL($sql);

	if ($modeacces=="mysql") {
		$rows = mysql_fetch_array($result, MYSQL_NUM);
	}


	if ($modeacces=="mysqli") {
		$rows = $result->fetch_array(MYSQLI_NUM);

	}

	return $rows[0];
}



/**
 *
 *Affiche sous forme d'un tableau le resultat d'une requette SQL
 * @param sql string
 *  <p>Requete SQL.</p>
 *
 *
 */
function afficheRequete($sql) {

	$results = tableSQL($sql);

	$nbchamps = nombreChamp($sql);

	echo "<table style=\"border: 2px solid blue; border-collapse: collapse; \">";
	echo "   <caption style=\"color:green;font-weight:bold\">$sql</caption>
	<tr style=\"border: 2px solid blue; border-collapse: collapse; \" >";
	for ($i=0;$i<$nbchamps;$i++) {
		echo "<th style=\"border: 2px solid blue; border-collapse: collapse; \">".nomChamp($sql,$i)."(".typeChamp($sql,$i).")</th>";
	}
	echo "   </tr>";

	foreach ($results as $ligne) {
		echo "<tr style=\"border: 1px solid red; border-collapse: collapse; \">";
		//on extrait chaque valeur de la ligne courante
		for ($i=0;$i<$nbchamps;$i++) {
			echo "<td style=\"border: 1px solid red; border-collapse: collapse; \">".$ligne[$i]."</td>";
		}
		echo "</tr>";
	}

	echo "</table>";
}



/**
 *
 *Retourne le nombre de champs d'une requete MySQL
 * @param sql string
 *  <p>Requete SQL.</p>
 *
 *
 * @return integer - Retourne le nombre de champs d'un jeu de resultat en cas de succes
 *         ou FALSE si une erreur survient.
 */
function nombreChamp($sql) {

	global $modeacces, $connexion;


	$result = executeSQL($sql);

	if ($modeacces=="mysql") {
		return mysql_num_fields($result);
	}

	if ($modeacces=="mysqli") {
		return  $result->field_count;
	}

}



/**
 *
 *Retourne le type d'une colonne MySQL specifique
 * @param sql string
 *  <p>Requete SQL.</p>
 * @param field_offset integer
 *  <p>La position numerique du champ. field_offset commence a� 0. Si field_offset
 *     n'existe pas, une alerte E_WARNING sera egalement generee.</p>
 *
 *
 * @return string - Retourne le type du champ retourne peut etre : "int", "real", "string", "blob"
 *         ou d'autres, comme detaille » dans la documentation MySQL.
 *
 */
 
// function typeChamp($sql, $field_offset) {

// 	global $modeacces, $connexion, $mysql_data_type_hash, $typebase;

// 	$result = executeSQL($sql);

// 	if ($modeacces=="mysql") {
// 		return mysql_field_type($result, $field_offset);
// 	}

// 	if ($modeacces=="mysqli") {
// 		return  $mysql_data_type_hash[$result->fetch_field_direct($field_offset)->type];
// 	}

// }



/**
 *
 *Retourne le nombre de champs d'une requete MySQL
 * @param sql string
 *  <p>Requete SQL.</p>
 *
 *
 * @return integer - Retourne le nombre de champs d'un jeu de resultat en cas de succes
 *         ou FALSE si une erreur survient.
 */
function nomChamp($sql, $field_offset) {

	global $modeacces, $connexion, $mysql_data_type_hash;

	$result = executeSQL($sql);

	if ($modeacces=="mysql") {
		return mysql_field_name($result, $field_offset);
	}

	if ($modeacces=="mysqli") {
		$infos = $result->fetch_field_direct($field_offset);
		return $infos->name;
	}

}



/**
 *
 *Retourne un seule ligne resultat d'une requete MySQL.
 * @param sql string
 *  <p>Requete SQL.</p>
 *
 *
 * @return array - un tableau indexe et associatif representant  la ligne
 *
 *
 * exemple
 -------

 $sql = "select * from user where numero = 1 ";
 $results = ligneSQL($sql);

 $login = $results['login'];
 $password = $results[3];

 echo $login." ".$password."<br />";

 */
function ligneSQL($sql) {

	global $modeacces, $connexion;

	$result = executeSQL($sql);

	if ($modeacces=="mysql") {
		$rows = mysql_fetch_array($result, MYSQL_BOTH);
	}

	if ($modeacces=="mysqli") {
		$rows = $result->fetch_array(MYSQLI_BOTH);
	}

	return $rows;
}


?>