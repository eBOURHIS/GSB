<?php

require "../php/connectAD.php";

$req = "DELETE FROM ".$_POST["table"]." WHERE id='".$_POST["id"]."';";
$res = executeSQL($req);

header('Content-Type: application/json');

?>

{
    "req":"<?=$req ?>",
    "res":"<?= $res ?>"
}