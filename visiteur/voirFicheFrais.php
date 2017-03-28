<?php

session_start();

require '../php/def.php';
require '../php/connectAD.php';

if (array_key_exists('id', $_GET)) {
	$id = $_GET['id'];
} else {
	$id = tableSQL("SELECT MAX(id) FROM FicheFrais WHERE idVisiteur='".$_SESSION['id']."';")[0]['MAX(id)'];
}
// echo $id;

$reqS = array(
	"FicheFrais" => "SELECT mois,annee,montantValide,dateModif,idEtat FROM FicheFrais WHERE id=".$id,
	"LigneFraisForfait" => "SELECT idForfait, quantite FROM LigneFraisForfait WHERE idFicheForfait=".$id,
	"Etat" => "SELECT libelle FROM Etat WHERE id='",
	"Forfait" => "SELECT id,libelle FROM Forfait"
);
$resS = array(
	"FicheFrais" => tableSQL($reqS["FicheFrais"])[0],
	"LigneFraisForfait" => tableSQL($reqS["LigneFraisForfait"]),
	"Forfait" => tableSQL($reqS["Forfait"])
);
$resS['Etat'] = tableSQL($reqS["Etat"].$resS["FicheFrais"]["idEtat"]."';")[0];
$tmpArray = array();

foreach ($resS["LigneFraisForfait"] as $value) {
	$tmpArray[$value['idForfait']] = $value['quantite'];
}
// print_r($tmpArray);

$resS["LigneFraisForfait"] = $tmpArray;
unset($tmpArray);

print_r($resS);
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
				<li><a href="/deconnexion.php" accesskey="1" title="">Déconnexion</a></li>
				<?php menu($_SESSION['login']); ?>
			</ul>
		</div>
	</div>

	<div id="page" class="container">
	<div id="portfolio-wrapper">
		<div id="portfolio" class="container">
			<div class="title">
				<h2>Fiche frais</h2>
				<h3><?=$_SESSION['nom']." ".$_SESSION['prenom'] ?></h3>
				<br />
				<p>
					Mois : <?=$resS['FicheFrais']['mois'] ?>
					<br />
					Année : <?=$resS['FicheFrais']['annee'] ?>
				</p>
				<div>
					<h3>Frais au forfait</h3>
					<table>
							<?php 
								for ($i = 0; $i < count($resS['Forfait']); $i++) {
									// print_r($resS["Forfait"][$i]);
									echo "<tr>";
									 foreach (array_keys($resS["LigneFraisForfait"]) as $key) {
									 	if ($resS["Forfait"][$i]["id"] == $key) {
									 		$ordretd[] = $resS["Forfait"][$i]["id"];
									 		echo "<th>".$resS["Forfait"][$i]["libelle"]."</th>";
									 		echo "<td>".$resS["LigneFraisForfait"][$resS["Forfait"][$i]["id"]]."</td>";
									 		echo "</tr>";
									 	}
									 }
								}
							?>
						<tr>
							<th>État</th>
							<td><?=$resS['Etat']['libelle'] ?></td>
						</tr>
						<tr>
							<?php
								if ($resS["FicheFrais"]["idEtat"] != "CR") {
									echo "<th>Date opération</th>";
									echo "<td>".$resS['FicheFrais']['dateModif']."</td>";
								} 
							?>
						</tr>
							<th>Montant</th>
							<td><?=$resS['FicheFrais']['montantValide'] ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
  </body>
  </html>