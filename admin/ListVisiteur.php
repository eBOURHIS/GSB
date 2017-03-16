<?php

session_start();

require '../php/def.php';

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
				<li><a href="/deconnexion.php" accesskey="1" title="">Déconnexion</a></li>
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
	            <table id='adminTable'>
	            	<tr>
	            		<th>nom</th>
	            		<th>prenom</th>
	            		<th>adresse</th>
	            		<th>code postal</th>
	            		<th>ville</th>
	            		<th>date embauche</th>
	            		<th>Modifier</th>
	            		<th>Supprimer</th>
	            	</tr>
	            		<?php 
							$result = executeSQL("SELECT nom,prenom,adresse,cp,ville,dateEmbauche,id FROM Visiteur;");
	
							if ($result->num_rows) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>";
									echo "<td>".$row['nom']."</td>";
									echo "<td>".$row['prenom']."</td>";
									echo "<td>".$row['adresse']."</td>";
									echo "<td>".$row['cp']."</td>";
									echo "<td>".$row['ville']."</td>";
									echo "<td>".$row['dateEmbauche']."</td>";
									echo "<td>"."<a href='/admin/GestionVisiteur.php?id=".$row['id']."' title='modifier'><img src='/icon/modifier.png' alt='modifier' class='iconPlus' />"."</td>";
									echo "<td>"."<a href='/admin/ListVisiteur.php?id=".$row['id']."' title='supprimer'><img src='/icon/supprimer.png' alt='supprimer' class='iconPlus' />"."</td>";
									echo "</tr>";
								}
							} else {
								echo "Erreur";
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
