<?php

require "../php/connectAD.php";

$req = "DELETE FROM ".$_POST["table"]." WHERE id='".$_POST["id"]."';";

$json = supprSQL($req);
$json['req'] = $req;

header('Content-Type: application/json');

echo json_encode($json);

?>