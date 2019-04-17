<?php 
/* un formulaire avec :
-nom 
-prénom 
-adresse 
-code postal 
-ville 
-pays 
-téléphone 
-mail 
*une facture avec :
- tableau contenant :
	-le nom de la bière, 
	-le prx ht, 
	-le prix ttc, 
	-une valeur premettant de changer les quantités, 
	- un bouton pour tout envoyer. */
//tableau avecle nom de la bière et le prix ht

	$beerArray2=[
		[
			"La Chouffe Blonde D'Ardenne",
			1.91
		],
		[
			'Duvel',
			1.66
		],
		[
			'Duvel Tripel Hop',
			2.24
		],
		[
			'Delirium Tremens',
			2.08
		],
		[
			'Delirium Nocturnum',
			2.24
		],
		[
			'Cuvée des Trolls',
			1.29
		],
		[
			'Chimay Rouge',
			1.49
		],
		[
			'Chimay Bleue',
			1.74
		],
		[
			'Chimay Triple',
			1.57
		]
	];
?>
<html>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- niveau affichage : essayer d'aligner un peu les cases des input, voire mettre en deux colonnes -->

<body  class="col-12">
	<br /><br />
	<table>
		<form method="get" action>
			<tr><td><label>Nom :</label></td>
			<td><input type="text" name="nom" placeholder="Doe"required></td></tr>
			
			<tr><td><label>Prénom :</label></td>
			<td><input type="text" name="prenom" placeholder="John"required></td></tr>
			
			<tr><td><label>Adresse :</label></td>
			<td><input type="text" name="adresse" placeholder="15 rue des épices" required></td></tr>
			
			<tr><td><label>Code Postal :</label>
			<td><input type="text" name="zipcode" placeholder="72600" required></td></tr>
			
			<tr><td><label>Ville :</label>
			<td><input type="text" name="ville" placeholder="Le Mans" required></td></tr>
			
			<tr><td><label>Pays :</label>
			<td><input type="text" name="pays" placeholder="France" required></td></tr>
			
			<tr><td><label>Téléphone (optionnel):</label>
			<td><input type="text" name="phone" placeholder="0147200001"></td></tr>
			
			<tr><td><label>Mail</label>
			<td><input type="email" name="mail" placeholder="example@serveur.com" required></td></tr>
		</form>
	</table>
	<button type="submit">Envoyer</button>

		<br /><br /><br /><br />

	<table id = "commande">
		<thead ><h3> Quantités de commande </h3></thead>
		<tr><td>Nom de la Bière</td>
			<td>Prix HT</td>
			<td>Prix TTC</td>
			<td>Quantité</td>
			<td>Total</td>
			<!--td>donne le format du tableau</td>-</tr-->
	
	<?php 

		//number_format($nombre,chiffres après la virgule, 'par quoi remplacer','ce qu'on remplace')
		for($i=0 ;$i<count($beerArray2) ;$i++){ 
			$HT =$beerArray2[$i][1];
			$TTC=$beerArray2[$i][1]*1.2; ?>
				<tr><td id="nomBiere<?= $i ?>">	<?= $beerArray2[$i][0] ?></td>
					<td id="ht<?= $i ?>"><?= number_format($HT,2,',','.') ?></td>
					<td id="ttc<?= $i ?>"><?= number_format($TTC,2,',','.')?></td>
					<!-- on veut value = contenu de la cellule * quantité de l'autre cellule-->
					<td><input id="quantite<?= $i ?>" type="number" min="0" max="100" value="1"
						onclick='valeur("quantite<?= $i ?>", <?= $i ?>)'></td>

					<td id="resultat<?= $i ?>"></td>
				</tr>
	<?php } ?>
	
	
	
	</table>

	<br><br><br><br>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>

