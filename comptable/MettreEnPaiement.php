<?php 

session_start();

require '../php/def.php';
require '../php/connectAD.php';

$sql = "UPDATE FicheFrais SET idEtat='VA', dateModif='".date('Y-m-d')."' WHERE id='".$_GET['id']."';";
$res = executeSQL($sql);

?>

<!DOCTYPE html>
<html>
   <head>
   <meta charset="UTF-8">
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
			</div>
		</div>
		
		<div id="menu" class="container">
			<ul>
				<li><a href="/deconnexion.php" accesskey="1" title="">Déconnexion</a></li>
				<?php menu($_SESSION['login']); ?>
			</ul>
		</div>
	</div>

	<div id="page" class="container">
	<div id="portfolio-wrapper">
		<div id="portfolio" class="container">
			<div class="title">
				<h2>REMBOURSEMENT</h2>
			<br />	
			<form id="formulaire" action="ValidationFrais.php">
				<button id="Calculer" class="buttoncenter" name="rembourser">Soumettre</button>
			</form>
			</div>
		</div>
	</div>
</div>
  </body>
  </html>