<?php 

session_start();

require '../php/def.php';

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
				<h2>Validation des frais par visiteurs</h2>
					<br />
				<form id="listVisiteurs" action="" method="get">
				
	   <fieldset> 
			<p>Choisir le visiteur : <select id='selectVisiteur'> 
			</p>
			<!-- Sur le menu select pour séléctionner les utilisateur utilise que la table "Visisteur" car sur FicheFrais il y a une clé étrangère de idVisiteur -->
			
			<?php 
				echo '<option> Selectionner le visiteur</option>';
	    		$req = "SELECT * FROM Visiteur";
	    		$res = executeSQL($req);
	    		if ($res == true) {
	    			while($row = $res->fetch_assoc()) {
    					echo "<option value=".$row['id']." >".$row['nom']." ".$row['prenom']."</option>";
    				}
	    		} else {
	    			$row = "Erreur !";
	    		}
	    	?>
		    </select>
		    
<?php 
	$month = array(
     1 => 'Janvier',
     2 => 'Février',
     3 => 'Mars',
     4 => 'Avril',
     5 => 'Mai',
     6 => 'Juin',
     7 => 'Juillet',
     8 => 'Août',
     9=> 'Septembre',
    10=> 'Octobre',
    11 => 'Novembre',
    12 => 'Décembre'
);

/**
 * Code du formulaire de sélection du mois
 * Bug : les mois ne sont pas classés dans l'ordre
 */
$sForm = <<<CODE_HTML
<form action="{$_SERVER['PHP_SELF']}" method="post" name="monform" id="monform">
  <p>
%s  </p>
</form>
CODE_HTML;
/**
 * Code de la liste de sélection
 */
$sSelect = <<<CODE_HTML
    <select name="date" id="date" size="1" style="width:200px;" onchange="document.forms['monform'].submit();">
%s    </select>
CODE_HTML;
/**
 * Code pour une option de sélection
 */
$sOption = <<<CODE_HTML
      <option value="%s">%s</option>
CODE_HTML;
$selectedDate = isset($_POST['date']) ? $_POST['date'] : null;
// Recherche de la date du jour
$current_month = date('m');
$current_year  = date('Y');
$listeChoix = SelectMois($current_month, $current_year, $month, $sSelect, $sOption, $selectedDate);
$formulaire = sprintf($sForm, $listeChoix);
echo($formulaire);

?>
	
			
	</p>
<?php 	
	$res = executeSQL("SELECT mois,annee,montantValide,idEtat FROM FicheFrais WHERE idEtat='CR'");
	$ficheFraisListe = selectData($res);
	
	// print_r($ficheFraisListe);



	for ($i = 0; $i < count($ficheFraisListe); $i++) {
	echo '<table>';

			foreach ($ficheFraisListe[$i] as $key => $value) { 

				echo "<th>$key</th>";
				echo "<td>$value</td>";


			// echo "<tr>";
				// echo "<td>".$value."</td>";
			// echo "</tr>";

			}
				echo '<td>	<input type= "radio" name="Valide" value="Valide" checked> Valide';
				echo '		<input type= "radio" name="Non_Valide" value="Non_Valide" > Non Valide</td>';
		
	echo '</table>'; 
				

	}
		
	 
?>
		
		<label for"NbJustificatifs">Nb Justificatifs</label>
		<input id="NbJustificatifs" name="NbJustificatifs" /> <br />
			<div align="center">
			<input id="Calculer" class="buttoncenter" name="Calculer" type="submit" value="Soumettre la requête" />
			</div>
        </fieldset>
     </form>

		</div>
	</div>
</div>
<script type="text/javascript" src="/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
	$('#date').change(function () {
		$('#listVisiteurs').submit();
	});
</script>


  </body>
  </html>