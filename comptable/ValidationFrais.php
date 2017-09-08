<?php 

session_start();

require '../php/connectAD.php';
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
<?php
	if (array_key_exists("rembourser",$_GET)) {
	$sql = "UPDATE FicheFrais SET idEtat='RB' WHERE idEtat='VA'";
	$res = executeSQL($sql);
	echo "<h4>Remboursement terminé</h4>";
}
?>
					<br />
				<form id="listVisiteurs" action="MettreEnPaiement.php" method="POST">
				
				<p id="chargementUp" class='invisible'>
	            	Chargement...
	            </p>
	            
	   <fieldset id="FieldsetSelect"> 
			<p><select id='selectVisiteur'> 
			<option value="" disabled='disabled' selected='selected'>Sélectionner un visiteur</option>
			</p>
			<!-- Sur le menu select pour séléctionner les utilisateurs utiliser que la table "Visisteur" car sur FicheFrais il y a une clé étrangère de idVisiteur -->
			
			<?php 
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
		    
		    <select id="selectMois" class="invisible"></select>

		<!--<label for"NbJustificatifs">Nb Justificatifs</label>-->
		<!--<input id="NbJustificatifs" name="NbJustificatifs" /> <br />-->
			<div align="center">
			</div>
        </fieldset>
        
        <table id="TableauFiche" class="invisible">
        	<tr id='entete'></tr>
        	<tr id='corps'></tr>
        </table>
        
        <p id="chargementDown" class='invisible'>
        	Chargement...
        </p>
       
       <input class="buttoncenter" name="ValiderFicheFrais" id="ValiderFicheFrais" value="Soumettre" type="button" />
     </form>

		</div>
	</div>
</div>
<script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="/js/def.js"></script>
<script type="text/javascript" src="/js/Frais.js"></script>


  </body>
  </html>