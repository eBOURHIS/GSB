<?php

require "connectAD.php";

$req = "SELECT idForfait,quantite FROM LigneFraisForfait WHERE idFicheForfait=".$_POST['id'];
$res = tableSQL($req);
$json = array();

for ($i = 0; $i < count($res); $i++) {
    $json[] = '"'.$res[$i]['idForfait'].'":"'.$res[$i]["quantite"].'"';
}

header('Content-Type: application/json');

echo "{".implode(",",$json)."}";

?>

