<?php 
require "connect.php";
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
?>
<html>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- niveau affichage : essayer d'aligner un peu les cases des input, voire mettre en deux colonnes -->

<body  class="col-12">
	<br /><br />
	<!--table>
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
	<button type="submit">Envoyer</button-->

		<br /><br /><br /><br />

	<table id = "commande">
		<thead ><h3> Quantités de commande </h3></thead>
		<tr><td>Nom de la Bière</td>
			<td>Prix HT</td>
			<td>Prix TTC</td>
			<td>Quantité</td>
			<td>Total</td>
			<!--td>donne le format du tableau</td>-</tr-->
	<form type="post" action="commande.php">
		<?php 
		require_once "db.php";
		$sql = "SELECT * FROM `beers`" ;
			$statement = $pdo->prepare($sql);
			$statement->execute([$sql]);
			$beers = $statement->fetchAll();
 			foreach ($beers as $beer): ?>

 				<div>
					<tr id="Nom<?=$beer['id']?>"><td><?=$beer["nom"] ?></td>
					<td id="ht<?=$beer['id']?>"><?=number_format($beer["prix"],2, ',','.') ?>€ </td>
					<td><?=number_format($beer["prix"]*1.2,2, ',','.') ?>€ </td>
					<td><input id="quantite<?=$beer['id']?>" type="number" min="0" max="100" value="0" onclick='valeur(quantite<?=$beer['id']?>,<?=$beer['id']?>)'></td>
					<!-- On veut la valeur dans la case total -->
					<td id="resultat<?= $beer['id'] ?>"></td>
				</div>
			</tr>
		<?php endforeach; ?>

		
		
		</table>
		<button type="submit">Valider la commande</button>
	</form>
	<br><br><br><br>
	<nav>
	<nav>
		<a href="index.php"> Accueil</a><br>
		<!--si pas connecté sinon cacher-->
		<a href="connexion.php"> Connexion</a><br>
		<a href="inscription.php"> Vous inscrire</a><br>
		<a href="purchase_order.php"> Commander</a><br>
		<!--si connecté sinon cacher-->
		<a href="mon_compte.php"> Mon compte</a><br>
		<a href="deconnexion.php"> Déconnexion</a><br>
	</nav>

	</nav>

<script type="text/javascript" src="./js/script.js"></script>
</body>
</html>

