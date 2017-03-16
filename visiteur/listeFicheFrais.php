<?php

session_start();

require '../php/def.php';
require '../php/connectAD.php';

if ($_GET) {
	$get = $_GET;
	$req = "DELETE FROM LigneFraisForfait WHERE idFicheForfait='".$get['id']."';";
	$res = executeSQL($req);
	if ($res) {
		// echo "Oui.";
		$req = "DELETE FROM FicheFrais WHERE id='".$get['id']."';";
		$res = executeSQL($req);
		if ($res) {
			$etat = "a réussi";
		} else {
			$etat = "a échoué";
		}
	} else {
		$etat = "a échoué";
	}
}

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
			    <?php
			    	$res = executeSQL("SELECT mois,annee,montantValide,idEtat,id FROM FicheFrais WHERE idVisiteur='".$_SESSION['id']."'");
					// print_r($res);
					
			        if (!empty($res->num_rows)) {
			        	$ficheFraisListe = selectData($res);
			            echo "<h2>Fiche frais</h2>";
			            echo "<h3>".$_SESSION['nom']." ".$_SESSION['prenom']."</h3>";
			            echo "<table>";
			            echo "<tr>";
			            foreach (array_keys($ficheFraisListe[0]) as $key) {
			            	if ($key == 'id') {
			            		continue;
			            	} else {
			            		echo "<th>".$key."</th>";
			            	}
			            }
			            echo "<th>Supprimer</th>";
			            echo "<th>Modifier</th>";
			            echo "<th>Voir</th>";
			            echo "</tr>";
			            
			            for ($i = count($ficheFraisListe)-1; $i >= 0; $i--) {
			                echo "<tr>";
			             	foreach ($ficheFraisListe[$i] as $key => $value) {
			             		if ($key == 'id') {
			             			continue;
			             		} else {
			             			echo "<td>".$value."</td>";
			             		}
			                }
			                echo "<td><a href='/visiteur/listeFicheFrais.php?id=".$ficheFraisListe[$i]['id']."' title='supprimer'><img src='/icon/supprimer.png' class='iconPlus' />";
			                
			                if ($ficheFraisListe[$i]['idEtat'] == 'CR') {
			                	echo "<td><a href='/visiteur/maFicheFrais.php?id=".$ficheFraisListe[$i]['id']."' title='Modifier'><img src='/icon/modifier.png' class='iconPlus' /></a>";
			                } else {
			                	echo "<td></td>";
			                }
			                
			                echo "<td><a href='/visiteur/voirFicheFrais.php?id=".$ficheFraisListe[$i]['id']."' title='voir'><img src='/icon/voir.png' class='iconPlus' /></a>";
			                echo "</tr>";
			            }
			            echo "</table>";
			        } else {
			            echo "<h2>Fiche frais</h2>";
			            echo "<h5>Tableau vide.</h5>";
			        }
			        
			    ?>
				<figure id='plus'>
	            	<img src="/icon/plus.png" class='iconPlus' title='Ajouter' id='ajouter' />
	            	<figcaption title='Ajouter'>Ajouter</figcaption>
	            </figure>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var plus = document.getElementById('plus');
	plus.addEventListener('click', function () {
		 location.replace('/visiteur/maFicheFrais.php');
	});
</script>
  </body>
  </html>