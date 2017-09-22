<?php

session_start();

require '../php/def.php';
require '../php/connectAD.php';

if ($_GET) {
	$req = executeSQL("SET foreign_key_checks = 0;");
	$result = executeSQL('DELETE FROM Visiteur WHERE id="'.$_GET['id'].'";');
	$result = executeSQL("SET foreign_key_checks = 1;");
	header("location: ListVisiteur.php");
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="<?=resolveLink('PPE2CSS.css') ?>" type="text/css" />
  <title>Galaxy Swiss Bourdin</title>
  <script src="<?=resolveLink('js/jquery-3.1.1.min.js') ?>"></script>
  <script src="<?=resolveLink('js/deleteSQL.js') ?>"></script>
  <script src="<?=resolveLink('js/def.js') ?>"></script>
</head>
<body>
	<div id="wrapper">
	<div id="header-wrapper">
		<div id="header" class="container">
			<div id="logo">
				<h1><img src="<?=resolveLink('images/logoGSB.png') ?>" alt="GSB" /></h1>
			</div>
		</div>
		<div id="menu" class="container">
			<ul>
				<li><a href="<?=resolveLink('deconnexion.php') ?>" accesskey="1" title="">Déconnexion</a></li>
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
								echo '<td>';
								echo '<a href="'.resolveLink('admin/GestionVisiteur.php').'?idVisiteur='.$result[$i]['id'].'">';
								echo '<img src="'.resolveLink('icon/modifier.png').'" alt="Modifier" class="iconPlus" ></a>';
								echo '</td>';
								echo '<td>';
								echo '<a href="'.resolveLink('admin/ListVisiteur.php').'?id='.$result[$i]['id'].'" title="Supprimer">'; 
								echo '<img src="'.resolveLink('icon/supprimer.png').'" alt="Supprimer" class="iconPlus" >';
								echo '</a>';
								echo '</td>';
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
