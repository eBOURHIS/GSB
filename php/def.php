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
 * @param string $login Login de l'utilisateur connecté
 * 
 */

function menu ($login) {
  $su = lectureLoginXML();
  
  $admin = array(
      "Liste des visiteurs" => "/admin/ListVisiteur.php", 
      'Gestion visiteur' => "/admin/GestionVisiteur.php",
  );
  
  $compta = array(
      'Valider une fiche de frais' => "/comptable/ValidationFrais.php",
      'Mettre en paiement une fiche de frais' => "/comptable/MettreEnPaiement.php",
      'Modifier les forfaits' => "/comptable/FraisForfaits.php"
  );
   
  $visiteur = array(
      'Lister des fiches de frais' => "/visiteur/listeFicheFrais.php",
      'Renseigner une fiche de frais' => "/visiteur/maFicheFrais.php"
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
 * @param string $login Login de l'utilisateur connecté
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
 * @return attribut string type d'\<input\>
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

?>