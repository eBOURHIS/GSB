<?php

session_start();

require 'php/def.php';
require 'php/connectAD.php';

if ($_SESSION['login']) { //Dans le cas où l'utilisateur est déjà connecter
	header('location: connexion.php'); //redirection vers la page 'connexion.php'
	exit();
}

?>

<!DOCTYPE html>
<html>
   <head>
   <meta charset="UTF-8">
    <!--<link rel="icon" href="/images/logo2.jpg" type="image/jpg" sizes="16x16"> -->
   <link rel="stylesheet" href="/PPE2CSS.css" type="text/css" />
  <title>Galaxy Swiss Bourdin</title>
</head>
</body>

	<div id="wrapper">
	<div id="header-wrapper">
		<div id="header" class="container">
			<div id="logo">
				<h1><img src="/images/logoGSB.png" alt="GSB" /></h1>
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
	
	</div>

	<div id="page" class="container">
	<div id="portfolio-wrapper">
		<div id="portfolio" class="container">
			<div class="title">
				<h2>Connexion</h2>
	<br />
				<form id="formulaire" action="connexion.php" method="post">
					<fieldset class='fieldFlex'>
						<label for='login'>Identifiant</label>
						<input type='text' name='login' />
					</fieldset>
					<fieldset class='fieldFlex'>
						<label for='password'>Mot de passe</label>
						<input type='password' name='password' />
					</fieldset>
					<input id="Connexion" class="buttoncenter" name="Connexion" type="submit" value="Se connecter" />
				</form>
				
			</div>
		</div>
	</div>
</div>
  </body>
  </html>