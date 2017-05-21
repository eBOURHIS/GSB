<?php

session_start();

require 'php/def.php';
require 'php/connectAD.php';

if ($_SESSION['login']) { //Si l'utilisateur est déjà connecté
	$etat = "a réussi"; //Prévoir peut-être une autre variable ? 
} else { //Sinon on tente de le connecter
	$login = $_POST["login"];
	$pwd = md5($_POST["password"]);
	$request = "SELECT nom,prenom,login,id,pwd FROM Visiteur WHERE login='".$login."';";
	$result = executeSQL($request);
	// echo $request;

	if ($result->num_rows == 1) { //On obtient les résultat
    	$row = $result->fetch_assoc();
    	if ($row['pwd'] == $pwd) {
    		$_SESSION['nom'] = $row['nom'];
    		$_SESSION['prenom'] = $row['prenom'];
    		$_SESSION['login'] = $row['login'];
    		$_SESSION['id'] = $row['id'];
    		$etat = "a réussi";
    	} else {
    		$etat = "n'a pas abouti";
			$err = "mot de passe incorrect";
    	}
	} else { //Si quelque chose se passe mal ou que c'est l'administareur ou le comptable
		$su = json_decode(file_get_contents('php/special.json'),true)['user'];
		foreach ($su as $value) {
			if ($login == $value['login'] and $pwd == md5($value['pwd'])) {
				$_SESSION['nom'] = $value['nom'];
    			$_SESSION['prenom'] = $value['prenom'];
    			$_SESSION['login'] = $value['login'];
    			$etat = "a réussi";
			}
		}
		if (!array_key_exists('nom',$_SESSION)) {
			$etat = "n'a pas abouti";
			$err = "Login inconnue";
		}
	}
}

?>

<!DOCTYPE html>
<html>
   <head>
   <meta charset="UTF-8">
   <link rel="stylesheet" href="PPE2CSS.css" type="text/css" />
  <title>Galaxy Swiss Bourdin</title>
</head>
</body>

	<div id="wrapper">
	<div id="header-wrapper">
		<div id="header" class="container">
			<div id="logo">
				<h1><img src="images/logoGSB.png" alt="GSB" /></h1>
			</div>
		</div>
		<div id="menu" class="container">
			<ul>
				<li><a href="deconnexion.php" accesskey="1" title="">Déconnexion</a></li>
				<?php menu($_SESSION['login']); ?>
			</ul>
		</div>
	</div>


	<div id="page" class="container">
	<div id="portfolio-wrapper">
		<div id="portfolio" class="container">
			<div class="title">
				<h2>La connexion <?php echo $etat; ?></h2>
	            <br />
	            <p>
	            	<?php 
	            		if ($etat == "a réussi") {
	            			echo "Bonjour, ".$_SESSION['nom']." ".$_SESSION['prenom'];
	            		} else {
	            			echo "Erreur : ".$err.".";
	            		}
	            	?>
	            </p>
				
			</div>
		</div>
	</div>
</div>
  </body>
  </html>