<?php 	

	require '../php/connectAD.php';
	
	$res = array();
	
    if (!array_key_exists("mois",$_POST)) {
        $sql = "SELECT mois, annee FROM FicheFrais WHERE idVisiteur='".$_POST['idVisiteur']."' AND idEtat='CR'";
        $res = tableSQL($sql);
        header('Content-Type: application/json');
        echo json_encode($res);
    } 
    
    if (array_key_exists("mois",$_POST)) {
        $sql = "SELECT mois, annee, montantValide, idEtat, id FROM FicheFrais WHERE idEtat='CR' AND mois=".$_POST['mois']." AND annee=".$_POST['annee']." AND idVisiteur='".$_POST['idVisiteur']."';";
        $res[] = tableSQL($sql);
        $sql = "SELECT idForfait, quantite FROM LigneFraisForfait WHERE idFicheForfait=".$res[0][0]['id'];
        $tmp = tableSQL($sql);
        for ($i = 0; $i < count($tmp); $i++) {
            $res[] = array($tmp[$i]["idForfait"] => $tmp[$i]["quantite"]);
        }
        
    }


// 	$ficheFraisListe = tableSQL("SELECT mois,annee,montantValide,idEtat FROM FicheFrais WHERE idEtat='CR'");
	
// 	// print_r($ficheFraisListe);

// 	echo '<table>';
	
// 	for ($i = 0; $i < count($ficheFraisListe); $i++) {

// 			foreach ($ficheFraisListe[$i] as $key => $value) { 

// 				echo "<th>$key</th>";
// 			}
			

// 			echo '<tr>';
			
// 			foreach ($ficheFraisListe[$i] as $key => $value) {
			

// 				echo "<td>$value</td>";
				
// 			}
// 				echo '	<td><input type= "radio" name="Valide" value="Valide" > Valide</td>';
// 				echo '	<td><input type= "radio" name="Non_Valide" value="Non_Valide" > Non Valide</td>';
// 	echo '</tr>';

				

// 	}
// 	echo '</table>';
	 
?>