<?php

require '../../php/def.php';
require '../../php/connectAD.php';

header('Content-Type: application/json');

$json = array();

if (array_key_exists('insert', $_POST)) {
    $json['pwd'] = motdepasse(9);
    
    $req = array(
        "keys" => array(),
        "values" => array()
    );
    
    foreach ($_POST as $key => $value) {
        
        if ($key == 'insert') {
            continue;
        }
        
        $req["keys"][] = $key;
        
        if ($key == "pwd") {
            $req["values"][] = '"'.md5($json['pwd']).'"';
        } else {
            $req["values"][] = '"'.$value.'"';
        }
        
    }
    
    $json['req'] = "INSERT INTO Visiteur (".implode(',',$req["keys"]).") VALUES (".implode(',',$req["values"]).")";
    
    $json['res'] = executeSQL($json['req']);
    
} elseif (array_key_exists('update', $_POST)) {
    
    $req = array();
    
    foreach ($_POST as $key => $value) {
        if ($key == 'update' || $key == 'pwd') {
           continue;
        }
        
        $req[] = $key."='".$value."'";
    }
    
    $json['req'] = "UPDATE Visiteur SET ".implode(",",$req)." WHERE id='".$_POST['id']."'";
    $json['res'] = executeSQL($json['req']);
    
} else {
    $json['req'] = "SELECT * FROM Visiteur WHERE id='".$_POST['id']."'";
    $json['res'] = tableSQL($json['req'])[0];
}

echo json_encode($json);

?>