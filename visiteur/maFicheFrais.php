<?php 

require '../php/def.php';
require '../php/connectAD.php';

session_start();

if (!$_SESSION['login']) {
    echo "<p>Vous n'êtes pas connectée.<br />Veuillez le faire <a href='/index.php'>ici</a></p>";
    exit();
} elseif ($_GET) {
	$get = $_GET;
	$ficheFrais = array(
		'idVisiteur' => $_SESSION['id'],
		'mois' => $get['mois'],
		'annee' => $get['annee'],
		'montantValide' => $get['montantValide']
	);
	$ligneFraisForfait = array(
		'idForfait' => array(),
		'quantite' => array()
	);
	foreach ($get as $key => $value) {
		switch ($key) {
			case 'mois':
			case 'annee':
			case 'montantValide':
			case 'calculer':
			case 'update':
			case 'id':
				continue;
				break;
			
			default:
				$ligneFraisForfait['idForfait'][] = $key;
				$ligneFraisForfait['quantite'][] = $value;
				break;
		}
	}
	if (array_key_exists("calculer",$get)) {
		$req = array('INSERT INTO FicheFrais (',') VALUES (',');');
	
		while (list($key,$value) = each($ficheFrais)) {
			if ($key == array_keys($ficheFrais)[0]) {
				$req[0] = $req[0].$key;
				$req[1] = $req[1].$value;
			} else { # Permet de mettre les virgules avant les valeurs
				$req[0] = $req[0].','.$key;
				$req[1] = $req[1].','.$value;
			}
		
		}
		$req = implode($req);
		// echo $req."<br />";
		$res = executeSQL($req);
		
		if ($res) {
			$id = tableSQL("SELECT MAX(id) FROM FicheFrais WHERE idVisiteur='".$_SESSION['id']."';")[0]['MAX(id)'];
			// print_r($id);
			$req = array('INSERT INTO LigneFraisForfait (idFicheForfait',') VALUES ',';');
	
			foreach (array_keys($ligneFraisForfait) as $key) { // Première partie de l'INSERT
				$req[0] = $req[0].','.$key;
			}
	
			for($i = 0; $i < count($ligneFraisForfait['idForfait']); $i++) {
				if ($i == count($ligneFraisForfait['idForfait']) - 1) {
					$req[1] = $req[1].'('.$id.',"'.$ligneFraisForfait['idForfait'][$i].'",'.$ligneFraisForfait['quantite'][$i].')';
				} else {
					$req[1] = $req[1].'('.$id.',"'.$ligneFraisForfait['idForfait'][$i].'",'.$ligneFraisForfait['quantite'][$i].'),';
				}
			}
	
			$req = implode($req);
			// echo $req;
			$res = executeSQL($req); 
		
			if ($res) {
				$etat = "Mise-à-jour réussi !";
			} else {
				$etat = "Erreur !";
			}
		}
	} elseif (array_key_exists("update", $get)) {
		$req = array("UPDATE FicheFrais SET ");
		while (list($key,$value) = each($ficheFrais)) {
			if ($key == 'idVisiteur') {
				continue;
			} elseif ($key == 'mois') {
				$req[0] = $req[0]."$key=$value";
			} else {
				$req[] = "$key=$value";
			}
		}
		$req = implode(",",$req)." WHERE idVisiteur='".$_SESSION['id']."' AND id=".$get['id'];
		$res = executeSQL($req);
		
		if ($res) {
			$reqS = array();
			for ($i = 0; $i < count($ligneFraisForfait['idForfait']); $i++) {
				 $reqS[] = "UPDATE LigneFraisForfait SET quantite=".$ligneFraisForfait['quantite'][$i]." WHERE idFicheForfait=".$get['id']." AND idForfait='".$ligneFraisForfait['idForfait'][$i]."';";
			}
			// print_r($reqS);
			foreach ($reqS as $req) {
				$res = executeSQL($req);
				if ($req == end($reqS)) {
					$etat = "Mise-à-jour réussi !";
				}
			}
		}
	}
}

// print_r($get);

?>


<!DOCTYPE html>
<html>
   <head>
   <meta charset="UTF-8">
   <link rel="stylesheet" href="/PPE2CSS.css" type="text/css" />
  <title>Galaxy Swiss Bourdin</title>
  <script src="/jquery-3.1.1.min.js"></script>
<?php
	if (array_key_exists("id",$_GET)) {
		echo "<script src='js/autoComplete.js'></script>";
	}
?>
</head>
<body>
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
	
	<div id='output'></div>

	<div id="page" class="container">
	<div id="portfolio-wrapper">
		<div id="portfolio" class="container">
			<div class="title">
				<h2>Etablissement de la fiche de frais</h2>
				<br />
				<h4 class="invisible">Chargement des données...</h4>
				<form id="formulaire" action="" method="get">
					<?php
						echo "<h3>".$etat."</h3>";
						if (!$req) {
							echo "<h5>".$req."</h5>";
						}
						
						if (array_key_exists('id', $_GET)) {
							$id = $_GET['id'];
						}
					?>
					<table>
						<tr class='invisible'>
							<th><label for="id" class='invisible'>id</label></th>
							<td><input readonly="readonly" class='invisible' type="number" name="id" id='id' min='0' value="<?=$id  ?>" /></td>
						</tr>
						<tr>
							<td><label for"mois">Mois</label></td>
							<td><input id='mois' name='mois' type='number' value="<?=date('n') ?>" readonly /></td>
						</tr>
						<tr>
							<td><label for"annee">Année</label></td>
							<td><input id='annee' name='annee' type='number' value="<?=date('Y') ?>" readonly /></td>
						</tr>
						<?php 
						$req = "SELECT * FROM Forfait";
						$res = tableSQL($req);
						for ($i = 0; $i < count($res); $i++): ?>
							<tr>
								<th><label for="<?=$res[$i]['id'] ?>"><?=$res[$i]["libelle"] ?></label></th>
								<td><input type='number' name="<?=$res[$i]['id'] ?>" id="<?=$res[$i]['id'] ?>" min='0' class='montant' produit="<?=$res[$i]['montant'] ?>" value='0' /></td>
							</tr>
						<?php endfor; ?>
						<tr>
							<td><label for="montantValide">Montant</label></td>
							<td><input type="number" name="montantValide" id="montantValide" value="<?= $res['ficheFrais'][0]['montantValide'] ?>" readonly /></td>
						</tr>
					</table>
					<button id="calculer" class="buttoncenter" name="calculer">Envoyer</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script>

	function calc() {
		var S = 0;
		for (var i=0; i < $('.montant').length; i++) {
			if (!parseFloat($('.montant')[i].value)) {
				$('.montant')[i].value = 0;
			}
			S += parseFloat($('.montant')[i].value) * parseFloat($('.montant')[i].getAttribute('produit'));
			// alert(S);
		}
		$('#montantValide').val(S);
	}
	
	$('#annee').change(function () {
		checkDate();
	});
	
	$('.montant').change(function () {
		calc();
	});
	
	$('#calculer').click(function () {
		if (!$.trim($("#id").val())) {
			$('#id').attr("disabled",true);
		}
		$('#formulaire').submit();
	});
</script>

  </body>
  </html>