<?php 

session_start();

require '../php/def.php';
require '../php/connectAD.php';

if ($_POST['update']) {
	$sql = "UPDATE Visiteur SET ";
	while (list($key, $value) = each($_POST)) {
		switch ($key) {
			case 'id':
				continue;
				break;
				
			case 'update':
				break;
				
			case 'nom':
				$sql = $sql.$key.'="'.strtoupper($value).'"';
				break;
				
			case 'ville':
				$sql = $sql.", ".$key."='".strtoupper($value)."'";
				break;
			
			case 'prenom':
				$sql = $sql.", ".$key.'="'.ucfirst($value).'"';
				break;
			
			default:
				$sql = $sql.", ".$key.'="'.$value.'"';
				break;
		}
	}
	$sql = $sql." WHERE id='".$_POST['id']."';";
	//echo $sql;
	$res = executeSQL($sql);
	if ($res === true) {
		$etat = "Mise-à-jour réussi !";
		header('location: /admin/GestionVisiteur.php?id='.$_POST['id'].'&etat='.$etat); //Attention id
		exit();
	} elseif ($res === false) {
		$etat = "Mise-à-jour échoué.";
		header('location: /admin/GestionVisiteur.php?etat='.$etat);
		exit();
}
} elseif ($_POST['insert']) {
	$get = $_POST;
	$fields = array();
	$values = array();
	$pwd = motdepasse(12);
	$sql = "";
	
	foreach ($get as $field => $value) {
		switch ($field) {
			case 'insert':
				break;
				
			case 'id':
				$fields[] = $field;
				$values[] = '"'.'AB3'.'"';
				break;
				
			case 'pwd':
				$fields[] = $field;
				$values[] = '"'.md5($pwd).'"';
				break;
			
			default:
				$fields[] = $field;
				$values[] = $value;
				break;
		}
	}
	
	$sql = "INSERT INTO Visiteur (".implode(",",$fields).") VALUES (".implode(",",$values).")";
	$res = executeSQL($sql); //afficher mot de passe ; requête ajax pour update ?
}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
   	<link rel="stylesheet" href="/PPE2CSS.css" type="text/css" />
  	<title>Galaxy Swiss Bourdin</title>
  	<script src="/js/jquery-3.1.1.min.js"></script>
	<script src="/js/def.js"></script>
</head>
</body>
<h1></h1>
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
				<h2>Ajouter un visiteur</h2>
				<br />
				<h5 id='etat' class='invisible'></h5>
				<br />
				<p id='h3pwd' class='invisible'></p>
				<form id="formulaire" action="" method="POST">
						<?php 
							$req = 'SELECT * FROM Visiteur LIMIT 1;';
							$res = tableSQL($req);
							echo "<table>";
							foreach ($res[0] as $key => $value) {
								if ($key == 'id') {
									echo "<tr class='invisible'>";
									echo "<th class=invisible><label class='invisible for='$key'>$key</label></th>";
									if (array_key_exists('id',$_GET)) {
										echo "<td class='invisible'><input name='$key' id='$key' type='hidden' value='".$_GET['id']."' /></td>";
									} else {
										echo "<td class='invisible'><input name='$key' id='$key' type='hidden' value='' /></td>";
									}
									echo "</tr>";
								} else {
									echo "<tr>";
									echo "<th><label for='$key'>$key</label></th>";
									switch ($key) {
										case 'cp':
											echo "<td><input name='$key' id='$key' type='text' pattern='[0-9]{5}' title='Code postal' required='required'/></td>";
											break;
										
										case 'dateEmbauche':
											echo "<td>";
											echo "<table class='tableDate'>";
											echo "<tr>";
											echo "<th>JJ</th><th>MM</th><th>AAAA</th>";
											echo "</tr>";
											echo "<td>";
											echo selectNombre(31,"jour",1,true);
											echo "</td><td>";
											echo selectNombre(12,"mois",1,true);
											echo "</td><td>";
											echo selectNombre(intval(date('Y')),"annee",2002,true);
											echo "</td>";
											echo "</table>";
											echo "</td>";
											break;
											
										case 'pwd':
											echo "<td><input name='$key' id='$key' type='password' value='....' required='required' readonly='readonly' /></td>";
											break;
									
										default:
											echo "<td><input name='$key' id='$key' type='".typeChamp($value)."'required='required' /></td>";
											break;
								}
								echo "</tr>";
							}
								}
							echo "</table>";
							echo "<input class='buttoncenter' type='reset' />";
							echo "<input class='buttoncenter' type='button' name='insert' id='insert' value='Envoyer' />";
						?>
			</div>
		</div>
	</div>
</div>
</form>	
</div>

<script src='js/ListVisiteur.js'></script>

  </body>
  </html>