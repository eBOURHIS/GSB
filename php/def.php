<?php

/**
 *
 * Chargement des login et mot de passe du comptable et de l'admin
 * 
 */
 
function lectureLoginXml() {
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
  
  return $su;
}

/**
 *
 * Génére le menu de navigation pour toute les sessions
 * 
 * @param $login string Login de l'utilisateur connecté
 * 
 */

function menu ($login) {
  $su = lectureLoginXML();
  
  $admin = array(
      "Liste des visiteurs" => "/admin/ListVisiteur.php", 
      'Ajouter des visiteurs' => "/admin/GestionVisiteur.php",
  );
  
  $compta = array(
      'Valider une fiche de frais' => "/comptable/ValidationFrais.php",
      'Mettre en paiement une fiche de frais' => "/comptable/MettreEnPaiement.php",
      'Modifier les forfaits' => "/comptable/FraisForfaits.php"
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

/**
 *
 * Permet de vérifier si l'utilisateur est bien l'administrateur
 * 
 * @param $login string Login de l'utilisateur connecté
 * 
 */

function checkAdmin ($login) {
  $su = lectureLoginXml();
  
  if ($login == (string)$su->admin->login) {
		return true;
	} else {
	  return false;
	}
}

/**
 *
 * Permet de générer un mot de passe aléatoire.
 * 
 * @param $nbre integer Nombre de caractère du mot de passe.
 * 
 * @return string mot de passe
 * 
 */
 
function motdepasse($nbre) {
  $pass = "";
  
  for($i = 0; $i < $nbre; $i++) {
    if ($i%3 == 1) {
      $pass .= chr(rand(48,57));
    } elseif ($i%3 == 2) {
      $pass .= chr(rand(65,90));
    } else {
      $pass .= chr(rand(97,122));
    }
  }
  
  return $pass;
}

/**
 *
 * <description fonction>
 * 
 * @param $current_month integer <description>
 * 
 * @param $current_year integer <description>
 * 
 * @param $month integer <description>
 * 
 * @param $sSelect <type> <description>
 * 
 * @param $sOption <type> <description>
 * 
 * @param $selectedDate <type> <description>
 * 
 * @return <type> <description>
 * 
 */

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

/**
 *
 * Cette fonction sert à déterminer le type d'une variable et à le convertir en attribut "type" dans <input>
 * 
 * @param $champ mixed variable dont le type doit être déterminé et converti
 * 
 * @return string attribut type d'<input>
 * 
 */

function typeChamp($champ) {
  $s = "";
  $type = gettype($champ);
  
  switch ($type) {
    case 'integer':
    case 'double':
      $s = "number";
      break;
      
    default:
      $s = 'text';
      break;
  }
  
  return $s;
  
}

?>