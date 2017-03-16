<?php 

require '../php/def.php';

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
		'idForfait' => array('ETP','KM','NUI','REP'),
		'quantite' => array($get['etape'],$get['kilometrage'],$get['nuitee'],$get['repas'])
	);
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
		$res = db($req);
		
		if ($res) {
			$id = selectData(db("SELECT MAX(id) FROM FicheFrais WHERE idVisiteur='".$_SESSION['id']."';"))[0]['MAX(id)'];
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
			$res = db($req); 
		
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
		$res = db($req);
		
		if ($res) {
			$reqS = array();
			for ($i = 0; $i < count($ligneFraisForfait['idForfait']); $i++) {
				 $reqS[] = "UPDATE LigneFraisForfait SET quantite=".$ligneFraisForfait['quantite'][$i]." WHERE idFicheForfait=".$get['id']." AND idForfait='".$ligneFraisForfait['idForfait'][$i]."';";
			}
			// print_r($reqS);
			foreach ($reqS as $req) {
				$res = db($req);
				if (empty($res)) {
					$etat = "Erreur (new) ! <br />".end($resS);
					break;
				} elseif ($req == end($reqS)) {
					$etat = "Mise-à-jour réussi !";
				}
			}
		} else {
			$etat = "Erreur !";
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

	<div id="page" class="container">
	<div id="portfolio-wrapper">
		<div id="portfolio" class="container">
			<div class="title">
				<h2>Etablissement de la fiche de frais</h2>
				<br />
				<form id="formulaire" action="" method="get">
					<?php
						echo "<h3>".$etat."</h3>";
						if (!$req) {
							echo "<h5>".$req."</h5>";
						}
						if ($id or $_GET['id']) {
							if ($_GET['id']) {
								$id = $_GET['id'];
							}
							$res = array(
								"ficheFrais" => selectData(db("SELECT mois,annee,montantValide FROM FicheFrais WHERE id=".$id)),
								"ligneFraisForfait" => selectData(db("SELECT idForfait,quantite FROM LigneFraisForfait WHERE idFicheForfait=".$id))
							);
							$quantite = array();
							$readonly = '';
							// print_r($res);
							foreach ($res['ligneFraisForfait'] as $array) {
								$quantite[$array['idForfait']] = $array['quantite'];
							}
							// print_r($quantite);
							$submit = "update";
						} else {
							$res = array(
								"ficheFrais" => array(
									array(
										"mois"=>date('n'),
										"annee"=>date('Y'),
										"montantValide"=>0
									)
								)
							);
							$quantite = array(
								"ETP"=>0,
								"KM"=>0,
								"NUI"=>0,
								"REP"=>0
							);
							$readonly = 'readonly';
							$submit = "calculer";
						} #Afficher les valeurs un insert
					?>
					<table>
						<tr class='invisible'>
							<label for="id" class='invisible'>id</label>
							<input readonly class='invisible' type="number" name="id" min='0' value="<?=$id ?>" />
						</tr>
						<tr>
							<td><label for"mois">Mois</label></td>
							<td><input id='mois' name='mois' type='number' min='1' max='12' value="<?= $res['ficheFrais'][0]['mois'] ?>" <?=$readonly ?> /></td>
						</tr>
						<tr>
							<td><label for"annee">Année</label></td>
							<td><input id='annee' name='annee' type='number' min='1990' max='2100' value="<?= $res['ficheFrais'][0]['annee'] ?>" <?=$readonly ?> /></td>
						</tr>
						<tr>
							<td><label for"nuitee">Nuitée</label></td>
							<td><input id="nuitee" name="nuitee" type="number" min="0" value="<?= $quantite['NUI'] ?>" class='montant' /></td>
						</tr>
						<tr>
							<td><label for"repas">Repas</label></td>
							<td><input id="repas" name="repas" type="number" min="0"  value="<?= $quantite['REP'] ?>" class='montant' /></td>
						</tr>
						<tr>
							<td><label for"kilometrage">Kilométrage</label></td>
							<td><input id="kilometrage" name="kilometrage" type="number" min="0" value="<?= $quantite['KM'] ?>" class='montant' /></td>
						</tr>
						<tr>
							<td><label for"etape">Etapes</label></td>
							<td><input id="etape" name="etape" type="number" min="0" value="<?= $quantite['ETP'] ?>" class='montant' /></td>
						</tr>
						<tr>
							<td><label for="montantValide">Montant</label></td>
							<td><input type="number" name="montantValide" id="montantValide" value="<?= $res['ficheFrais'][0]['montantValide'] ?>" readonly /></td>
						</tr>
					</table>
					<button id="calculer" class="buttoncenter" name="<?=$submit ?>">Envoyer</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script src="/jquery-3.1.1.min.js"></script>
<?php
echo "<script>";
echo "function calc() {
		var numbers = [];
		var S = 0;";
		
echo "	numbers[0] = parseFloat($('#nuitee').val())*".NUI.";";
echo "	numbers[1] = parseFloat($('#repas').val())*".REP.";";
echo "	numbers[2] = parseFloat($('#kilometrage').val())*".KM.";";
echo "	numbers[3] = parseFloat($('#etape').val())*".ETP.";";
		
echo "	for(var i=0; i < numbers.length; i++) {
			S += numbers[i];
		}
		
		$('#montantValide').val(S);
	}";
echo "</script>";
?>
<script>
	var date = new Date();
	
	$('#annee').attr("max","2017");
	
	function checkDate() {
		var Newdate = new Date($('#annee').val()+'-12-31');
		
		if ($('#annee').val() == date.getFullYear()) {
			$('#mois').attr('max',date.getMonth()+1);
			$('#mois').val(date.getMonth()+1);
		} else {
			$('#mois').attr('max',Newdate.getMonth()+1);
		}
	}
	
	$('#annee').change(function () {
		checkDate();
	});
	
	$('.montant').change(function () {
		calc();
	});
	
	$('#calculer').click(function () {
		$('#formulaire').submit();
	});
</script>

  </body>
  </html>