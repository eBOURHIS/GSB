
<?php		
	session_start();
	require '../php/def.php';
	require '../php/connectAD.php';

if (array_key_exists('id', $_GET)) {
							$id = $_GET['id'];
}

if ($_GET) {
	$sql = "UPDATE Forfait SET libelle='".$_GET['Libelle']."', montant='".$_GET['Montant']."' WHERE id='".$_GET['ID']."';";
	$res = executeSQL($sql);
	if ($res) {
		// echo "Oui.";
		$res = executeSQL($sql);
		if ($res) {
			$etat = "a réussi";
		} else {
			$etat = "a échoué";
		}
	} else {
		$etat = "a échoué";
	}
}

//print_r($_GET);
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
				<h2>Modification du frais</h2>
				
	    <br /><br />
	    
   	<form id="formulaire" action="ModificationFrais.php" method="get"> 
					<fieldset class='fieldFlex'>
						
						<label for="id" class='invisible'>id</label>
						<input readonly="readonly" class='invisible' type="text" name="ID" id='id' value="<?=$id  ?>" />
						
						<label for='Libelle'>Libelle</label>
						<input type='text'  name='Libelle' placeholder='Entrer le nouveau Libelle' />
					</fieldset>
					<fieldset class='fieldFlex'>
						<label for='Montant'>Montant (€)</label>
						<input type='number' name='Montant' placeholder='Entrer le nouveau montant' />
					</fieldset>
					<input id="Effacer" class="buttoncenter" name="Effacer" type="reset" value="Effacer" />
					<input id="Soumettre" class="buttoncenter" name="Confirmer" type="submit" value="Confirmer la modification" />
				</form>
				
</body>
</html>