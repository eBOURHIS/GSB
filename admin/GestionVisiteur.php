<?php 

session_start();

require '../php/def.php';
require '../php/connectAD.php';

function listInput($row) {
	if (gettype($row) == 'array') {
		echo "<table id='visiteurs'>";
		while (list($key, $value) = each($row)) {
			echo "<tr>";
			echo "<td class='".$key."'><label for='".$key."'class='".$key."'>".$key."</label></td>";
				switch ($key) {
					case 'dateEmbauche':
						echo "<td><input name='".$key."' type='date' value='".$value."' placeholder='aaaa-mm-jj' /></td>";
						break;
								
					case 'pwd':
						echo "<td><input name='".$key."' type='password' value='".$value."' /></td>";
						break;
								
					case 'id':
						echo "<td class='".$key."'><input class='".$key."' name='".$key."' type='text' value='".$value."' readonly /></td>";
						break;
									
					default:
						echo "<td><input name='".$key."' type='text' value='".$value."' id='".$key."'/></td>";
						break;
				}
			echo "</tr>";
		}
		echo "</table>";
		echo "<input id='update' class='buttoncenter' name='update' type='submit' />";
	} else {
		$res = executeSQL("SELECT * FROM Visiteur WHERE id='10';");
		$row = $res->fetch_assoc();
		echo "<table id='visiteurs'>";
		while (list($key,$value) = each($row)) {
			echo "<tr>";
			echo "<td class='".$key."'><label for='".$key."'class='".$key."'>".$key."</label></td>";
				switch ($key) {
					case 'dateEmbauche':
						echo "<td><input name='".$key."' type='date' value='' placeholder='aaaa-mm-jj' /></td>";
						break;
								
					case 'pwd':
						echo "<td><input name='".$key."' type='password' value='1234' readonly /></td>";
						break;
								
					case 'id':
						echo "<td class='".$key."'><input id='id' class='".$key."' name='".$key."' type='text' value='' readonly /></td>";
						break;
									
					default:
						echo "<td><input name='".$key."' type='text' value='' id='".$key."'/></td>";
						break;
				}
			echo "</tr>";
		}
		echo "</table>";
		echo "<button id='insert' value='insert' name='insert'>Envoyer</button>";
	}
		
}

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
				$values[] = '"'.AB3.'"';
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
</head>
</body>
<h1></h1>
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
				<h2>Visiteurs</h2>
				<br />
				<form id="formulaire" action="" method="POST">
						<?php 
							if ($_GET) {
								if ($_GET['etat']) {
									echo "<h3>".$_GET['etat']."</h3>";
								} 
								if ($_GET['id']) {
									$req = 'SELECT * FROM Visiteur WHERE id="'.$_GET['id'].'";';
									$res = executeSQL($req);
									listInput($res->fetch_assoc());
								}
							} else {
								listInput('new');
							}
						?>
			</div>
		</div>
	</div>
</div>
</form>	
</div>

<script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">


$(document).ready(function () {
	function writeLogin() {
		if ($.trim($('#nom').val()) && $.trim($('#prenom').val()) != "") {
			var nom = $('#nom').val().toLowerCase(),
				prenom = $('#prenom').val().toUpperCase();
				
			$('#login').val(prenom[0]+nom);
		}
	}

	$('#nom').blur(function () {writeLogin();});
	$('#prenom').blur(function () {writeLogin();});

	$('#insert').click(function () {
		var inputs = $("input"), value;
		for (var i = 0; i < inputs.length; i++) {
			switch ($(inputs[i]).attr("id")) {
				case 'insert':
				case 'id':
				case 'pwd':
					break;
					
				default:
					value = '"' + $(inputs[i]).val() + '"';
					$(inputs[i]).val(value);
			}
		}
	});
});
</script>
  </body>
  </html>