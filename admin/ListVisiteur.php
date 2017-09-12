<?php

session_start();

require '../php/def.php';
require '../php/connectAD.php';

if ($_GET) {
	$result = executeSQL('DELETE FROM Visiteur WHERE id="'.$_GET['id'].'";');
	header("location: ListVisiteur.php");
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/PPE2CSS.css" type="text/css" />
  <title>Galaxy Swiss Bourdin</title>
  <script src="/js/jquery-3.1.1.min.js"></script>
  <script src="/js/deleteSQL.js"></script>
  <script src="/js/def.js"></script>
</head>
<body>
	<div id="wrapper">
	<div id="header-wrapper">
		<div id="header" class="container">
			<div id="logo">
				<h1><img src="/images/logoGSB.png" alt="GSB" /></h1>
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
				<?php if (!checkAdmin($_SESSION['login'])) {echo "Vous n'avez pas accèes à cette page."; exit();} ?>
				<h2>Liste des visiteurs</h2>
	            <br />
	            <h5 class="invisible"></h5>
	            <p id="chargement" class='invisible'>
	            	Chargement...
	            </p>
	            <?php 
	            	$result = tableSQL("SELECT nom,prenom,adresse,cp,ville,dateEmbauche,id FROM Visiteur");
	            ?>
	            <table id='Visiteur'>
	            	<tr>
	            		<?php 
	            			foreach ($result[0] as $key => $value) {
	            				if ($key != "id") {
	            					echo "<th>".$key."</th>";
	            				}
	            			}
	            		?>
	            		<th>Modifier</th>
	            		<th>Supprimer</th>
	            	</tr>
	            		<?php 
	            			for ($i = 0; $i < count($result); $i++){
	            				echo "<tr id='tr".$result[$i]['id']."'>";
	            				foreach ($result[$i] as $key => $row) {
	            					if ($key != "id") {
	            						echo "<td>".$row."</td>";
	            					}
	            				}
	            				echo "<td><a href=/admin/GestionVisiteur.php?id=".$result[$i]['id']." title='modifier'><img src='/icon/modifier.png' alt='modifier' class='iconPlus' /></a></td>";
	            				echo "<td><img src='/icon/supprimer.png' alt='supprimer' class='iconPlus' title='supprimer' id='suppr".$result[$i]['id']."' /></td>";
	            				echo "</tr>";
	            			}
	            		?>
	            </table>
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
		 location.replace('/admin/GestionVisiteur.php');
	});
</script>
  </body>
  </html>
