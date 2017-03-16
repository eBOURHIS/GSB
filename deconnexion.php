<?php

session_start();

require 'php/def.php';
require 'php/connectAD.php';

if ($_SESSION['login']) {
    $prenom = $_SESSION['prenom'];
    $nom = $_SESSION['nom'];
    try  {
        // remove all session variables
        session_unset();
        // destroy the session
        session_destroy(); 
    } catch (Exception $e) {
        echo "Il y a eu un problème pendant votre déconnexion. Voir erreur : ".$e;
    }
} else {
    header('Location: /index.php');
    exit();
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
			<div id="social">
				<ul class="contact">
					<li><a href="#" class="icon icon-twitter"><span>Twitter</span></a></li>
					<li><a href="#" class="icon icon-facebook"><span></span></a></li>
					<li><a href="#" class="icon icon-dribbble"><span>Pinterest</span></a></li>
					<li><a href="#" class="icon icon-tumblr"><span>Google+</span></a></li>
					<li><a href="#" class="icon icon-rss"><span>Pinterest</span></a></li>
				</ul>
			</div>
		</div>
		<div id="menu" class="container">
			<ul>
				<li><a href="index.php" accesskey="1" title="">Connexion</a></li>
			</ul>
		</div>
	</div>


	<div id="page" class="container">
	<div id="portfolio-wrapper">
		<div id="portfolio" class="container">
			<div class="title">
				<h2>Déconnecté</h2>
	            <br />
				<p><?php echo "Au revoir ".$nom." ".$prenom; ?></p>
				
			</div>
		</div>
	</div>
</div>
  </body>
  </html>
