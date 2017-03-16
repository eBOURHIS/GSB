<?php

switch (explode('/',$_SERVER[PHP_SELF])[1]) {
  case 'admin':
  case 'comptable':
  case 'visiteur':
    $su = simplexml_load_file("../php/special.xml");
    break;
  
  default:
    $su = simplexml_load_file("php/special.xml");
    break;
}

function menu ($login) {
  global $su;
  
  $admin = array(
      "Liste des visiteurs" => "/admin/ListVisiteur.php", 
      'Ajouter des visiteurs' => "/admin/GestionVisiteur.php",
  );
  
  $compta = array(
      'Valider une fiche de frais' => "/comptable/ValidationFrais.php",
      'Mettre en paiement une fiche de frais' => "/comptable/MettreEnPaiement.php",
  );
   
  $visiteur = array(
      'Lister des fiches de frais' => "/visiteur/listeFicheFrais.php",
      'Renseigner une fiche de frais' => "/visiteur/maFicheFrais.php",
      'Suivre une fiche de frais' => "/visiteur/voirFicheFrais.php"
  );
  
   switch ($login) {

     case (string)$su->admin->login:
       while (list($key, $item) = each($admin)) {
           echo "<li><a href='$item'>".$key."</a></li>"; 
        }
        break;
      
      
     case (string)$su->comptable->login:
        while (list($key, $item) = each($compta)) {
            echo "<li><a href='$item'>".$key."</a></li>"; 
        }
        break;
      
      
     default: //On considère que par défauts c'est un visiteur
        while (list($key, $item) = each($visiteur)) {
            echo "<li><a href='$item'>".$key."</a></li>"; 
        }
        break;
    
  }

}

function checkAdmin ($login) {
  global $su;
  
  if ($login == (string)$su->admin->login) {
		return true;
	} else {
	  return false;
	}
}

function verificationDate() {
  return date('d/m/Y');
}

function motdepasse($nbre) { // Permet de générer mot de passe aléatoire avec un nombre définis de caractères
  for($i = 0; $i < $nbre; $i++) {
    if ($i%2) {
      $pass = $pass.chr(rand(33,93));
    } else {
      $pass = $pass.chr(rand(97,125));
    }
  }
  return $pass;
}

// // $req = "SELECT id, montant FROM Forfait";
// // $res = db($req);

// while ($row = $res->fetch_assoc()) { #Définition des constantes
// 	define($row['id'], $row['montant']);
// }


// Cette fonction sert à créer la liste déroulante des mois dans l'écran ValidationsFrais.php

function SelectMois($current_month, $current_year, $month, $sSelect, $sOption, $selectedDate = null)
{
    $options = sprintf($sOption, '-1', 'Sélectionnez un mois');
    for($i = 0, $m = $current_month, $y = $current_year; $i < 12; $i++, $m--)
    {
        if($m < 1)
        {
            $m = 12;
            $y--;
        }
        $value = sprintf("%02d",$m) .''. $current_year;
        if(!is_null($selectedDate) && $selectedDate == $value)
        {
            $value .= '" selected="selected';
        }
        $label = $month[(int)$m] ." - ". $y;
        $options .= sprintf($sOption, $value, $label);
    }
    $select = sprintf($sSelect, $options);
    return $select;
}

?>