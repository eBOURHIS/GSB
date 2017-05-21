
<?php		
	session_start();
	require '../php/def.php';
	require '../php/connectAD.php';

if (array_key_exists("ID",$_GET)) {
	$sql = 'INSERT INTO Forfait (id,libelle,montant) VALUES ("'.$_GET["ID"].'","'.$_GET["Libelle"].'",'.$_GET["Montant"].')';
	$req = executeSQL($sql);
	header("location: FraisForfaits.php");
}

if ($_GET) {
	$get = $_GET;
	$req = "DELETE FROM Forfait WHERE id='".$get['id']."';";
	$res = executeSQL($req);
	if ($res) {
		// echo "Oui.";
		$req = "DELETE FROM Forfait WHERE id='".$get['id']."';";
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
				<h2>Gestion des forfaits</h2>
					<br />
				<form id="listVisiteurs" action="" method="get">
	
	<body>
	    
		<br />
	
 	<form style="text-align:center" id="formulaire" method="get" action="">
	      			<strong>
	        			ID : <input id="ID" name="ID" type="text"  />
	        			Libelle : <input Libelle="Libelle"  name="Libelle" type="text"  />
	        			Montant (€) : <input Montant="Montant" name="Montant" type="number"  />
           			 </strong>	
            <br /><br />


	    		<input class="buttoncenter" type="reset" value="Effacer" />
	   			<input id="submit" class="buttoncenter" type="submit" name="submit" value="Enregistrer le frais" /></td>
	  	
	    
	    </table>
	    
	    <br /><br />
    
    <?php
    
	$forfait = tableSQL("SELECT id, libelle, montant FROM Forfait");
	
	// print_r($forfait);

	echo '<table>'; // En fait tu peux bien utiliser mon script ajax
	echo '<tr>';
	
		foreach ($forfait[0] as $key => $value) { 

				echo "<th>$key</th>";
			}
			
	echo'<th>Modifier</th>';
	echo'<th>Supprimer</th>';
	
	echo '</tr>';
	
	for ($i = 0; $i < count($forfait); $i++) {

	echo '<tr>';

			echo '</tr>';
			echo '<tr>';
			
			foreach ($forfait[$i] as $key => $value) {
			
				echo "<td>$value</td>";
			}
			echo "<td>"."<a href='/comptable/ModificationFrais.php?id=".$forfait[$i]['id']."' title='Modifier'><img src='/icon/modifier.png' alt='Modifier' class='iconPlus' />"."</td>";
			echo "<td>"."<a href='/comptable/FraisForfaits.php?id=".$forfait[$i]['id']."' title='Supprimer'><img src='/icon/supprimer.png' alt='Supprimer' class='iconPlus' />"."</td>";
	echo '</tr>';

	}
	echo '</table>';
?>
    </form>

</body>
</html>