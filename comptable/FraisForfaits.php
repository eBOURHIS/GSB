
<?php		
	session_start();
	require '../php/def.php';
	require '../php/connectAD.php';

	$sql="select * from LigneFraisForfait";
	$cptforfait = compteSQL($sql);
	$results = tableSQL($sql);
	
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
	
 	<form style="text-align:center" id="formulaire" method="get" action="insertfrais.php">
	      				
	        			ID * : <input id="ID" name="ID" type="text" value="" />
	        			Libelle * : <input id="Libelle"  name="Libelle" type="text" value="" />
	        			Montant * : <input id="Montant" name="Montant" type="tewt" value="" />
            
            <br /><br />

	    	<tr>
	    		<input class="buttoncenter" type="reset" value="Effacer" />
	   			<input id="submit" class="buttoncenter" type="submit" name="submit" value=" Enregistrer le frais " /></td>
	  		</tr>
	    
	    </table>
	    
	    <br /><br />
    
    <?php
    
	$forfait = tableSQL("SELECT id, libelle, montant FROM Forfait");
	
	// print_r($forfait);

	echo '<table>';
	for ($i = 0; $i < count($forfait); $i++) {

	echo '<tr>';
			
			foreach ($forfait[$i] as $key => $value) { 

				echo "<th>$key</th>";
			}
			
			echo '</tr>';
			echo '<tr>';
			
			foreach ($forfait[$i] as $key => $value) {
			
				echo "<td>$value</td>";
			}
	echo '</tr>';

	}
	echo '</table>';
		
	 
?>
    </form>

</body>
</html>