<?php 	

	require '../php/connectAD.php';
	
	header('Content-Type: application/json');
	
	$res = array();
	
    if (!array_key_exists("mois",$_POST)) {
        $sql = "SELECT mois, annee FROM FicheFrais WHERE idVisiteur='".$_POST['idVisiteur']."' AND idEtat='CR'";
        $res = tableSQL($sql);
        echo json_encode($res);
    } 
    
    if (array_key_exists("mois",$_POST)) {
        $sql = "SELECT montantValide, idEtat, id FROM FicheFrais WHERE idEtat='CR' AND mois=".$_POST['mois']." AND annee=".$_POST['annee']." AND idVisiteur='".$_POST['idVisiteur']."';";
        $res[0] = tableSQL($sql)[0];
        $sql = "SELECT idForfait, quantite, libelle FROM LigneFraisForfait, Forfait WHERE idForfait = id AND idFicheForfait=".$res[0]['id'];
        $tmp = tableSQL($sql);
        
        for ($i = 0; $i < count($tmp); $i++) {
            $res[1][$tmp[$i]["idForfait"]] = array("quantite" => $tmp[$i]["quantite"], "libelle" => $tmp[$i]["libelle"]);
        }
        
        unset($res[0]['idEtat']);
        echo json_encode($res);
    }
    
?>