<?php

/**
 * 
 * @author Loïc Penaud <lpenaud@zaclys.net>
 * @copyright Loïc Penaud <lpenaud@zaclys.net>
 * 
 * @license Apache-2.0
 * @license https://opensource.org/licenses/Apache-2.0 Apache-2.0
 * 
 */ 

/**
 *
 * Chargement des login et mot de passe du comptable et de l'admin
 * 
 * @return array liste utilisateurs speciaux
 * 
 */
 
function lectureLoginSpecial() {
  // print_r(explode('/',$_SERVER['PHP_SELF']));
  // Sur windows : Array ( [0] => [1] => GSB - PPE [2] => admin [3] => ListVisiteur.php )
  // TODO: Rajouter une boucle pour faire correspondre sur le bon rôle

  $phpSelf = explode('/',$_SERVER['PHP_SELF']);
  $directory = $phpSelf[count($phpSelf) - 2];

  switch ($directory) {
    case 'admin':
    case 'comptable':
    case 'visiteur':
      $su = json_decode(file_get_contents('../php/special.json'), true)['user'];
      break;
  
  default:
    $su = json_decode(file_get_contents('php/special.json'), true)['user'];
    break;
  }
  
  return $su;
}

function resolveLink($page) {
  $future = $_SERVER['CONTEXT_PREFIX'] ? $_SERVER['CONTEXT_PREFIX'] : "";
  $future .= '/';
  // return $_SERVER;

  $future .= $page;
  return $future;
}

/**
 *
 * Génére le menu de navigation pour toute les sessions
 * 
 * @param string $login Login de l'utilisateur connecté
 * 
 */

function menu($login) {
  $su = lectureLoginSpecial();
  
  $admin = array(
      "Liste des visiteurs" => resolveLink("admin/ListVisiteur.php"), 
      'Gestion visiteur' => resolveLink("admin/GestionVisiteur.php"),
  );
  
  $compta = array(
      'Valider une fiche de frais' => resolveLink("comptable/ValidationFrais.php"),
      // 'Mettre en paiement une fiche de frais' => "/comptable/MettreEnPaiement.php",
      'Modifier les forfaits' => resolveLink("comptable/FraisForfaits.php")
  );
   
  $visiteur = array(
      'Lister des fiches de frais' => resolveLink("visiteur/listeFicheFrais.php"),
      'Renseigner une fiche de frais' => resolveLink("visiteur/maFicheFrais.php")
  );
  
   switch ($login) {

     case $su['admin']['login']:
       while (list($key, $item) = each($admin)) {
           echo "<li><a href='$item'>".$key."</a></li>"; 
        }
        break;
      
      
     case $su['comptable']['login']:
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
 * @param string $login Login de l'utilisateur connecté
 * 
 */

function checkAdmin ($login) {
  $su = lectureLoginSpecial();
  
  if ($login == $su['admin']['login']) {
		return true;
	} else {
	  return false;
	}
}

/**
 *
 * Permet de générer un mot de passe aléatoire.
 * 
 * @param int $nbre Nombre de caractère du mot de passe.
 * 
 * @return string mot de passe
 * 
 */
 
function motdepasse($nbre) {
  $pass = "";
  
  for($i = 0; $i < $nbre; $i++) {
    switch ($i%3) {
      case 1:
        $pass .= chr(rand(48,57));
        break;
        
      case 2:
        $pass .= chr(rand(65,90));
        break;
      
      default:
        $pass .= chr(rand(97,122));
        break;
    }
  }
  
  return $pass;
}

/**
 *
 * Cette fonction sert à déterminer le type d'une variable et à le convertir en attribut "type" dans \<input\>
 * 
 * @param mixed $champ variable dont le type doit être déterminé et convertis
 * 
 * @return string attribut type d'input
 * 
 */

function typeChamp($champ) {
  $type = gettype($champ);
  
  switch ($type) {
    case 'integer':
    case 'double':
      return "number";
      break;
      
    default:
      return 'text';
      break;
  }
  
}

/**
 * 
 * Cette fonction permet de générer un menu <select> avec des nombres qui s'incrémente
 * 
 * @param int $max le plus grand nombre qu'il devra apparaitre dans le menu \<select\>
 * 
 * @param string $name l'attribut name de \<select\>
 * 
 * @param int $min le plus petit nombre qu'il devra apparaitre dans le menu \<select\> par défaut 0
 * 
 * @param boolean $required activation de l'attribut required par défaut il n'y en a pas
 * 
 */

function selectNombre($max, $name, $min = 0, $required = false) {
  $result = "<select name='$name' id='$name' ";
  
  if ($required) {
    $result .= "required='required'";
  }
  $result .= ">";
  
  for ($i = $min; $i <= $max; $i++) {
     $result .= "<option value='$i'>";
     
     if ($i < 10) {
       $result .= "0".$i;
     } else {
       $result .= $i;
     }
     
     $result .= "</option>";
  }
  
  return $result."</select>";
}

/**
 * 
 * Cette fonction permet de convertir les dates d'une base de donnée au format AAAA-MM-JJ
 * au format français : JJ-MM-AAAA
 * 
 * @param string $dateStr date au format AAAA-MM-JJ à convertir
 * 
 * @return string date convertie au format JJ-MM-AAAA
 * 
 */

function dateFR($dateStr) {
  $dateList = explode("-",$dateStr);
  
  return $dateList[2]."/".$dateList[1]."/".$dateList[0];
}

?>