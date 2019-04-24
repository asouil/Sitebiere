<?php 
require "connect.php";

?>

<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="col-12">
<!-- niveau affichage : essayer d'aligner un peu les cases des input, voire mettre en deux colonnes 
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
//tableau avecle nom de la bière et le prix ht-->
	<a id="to_nav" href="#menu"> Vers le menu </a>
	<br /><br />
	<div class="row">
		<table id = "commande">
			<thead><h3> Quantités de commande </h3></thead>
			<tr><td>Nom de la Bière</td>
				<td>Prix HT</td>
				<td>Prix TTC</td>
				<td>Quantité</td>
				<td>Total</td>
				<!--td>donne le format du tableau</td>-</tr-->
				<form method="post" action="recap_commande.php">
					<?php 
					require_once "db.php";
					$sql = "SELECT * FROM `beers`" ;
						$statement = $pdo->prepare($sql);
						$statement->execute([$sql]);
						$beers = $statement->fetchAll();
			 			foreach ($beers as $beer): ?>
			 				
								<tr id="Nom<?=$beer['id']?>"><td><?=$beer["nom"] ?></td>
								<td id="ht<?=$beer['id']?>"><?=number_format($beer["prix"],2, ',','.') ?>€ </td>
								<td><?=number_format($beer["prix"]*1.2,2, ',','.') ?>€ </td>
								<td><input id="quantite<?=$beer['id']?>" name="quantite<?=$beer['id']?>" type="number" min="0" max="100" value="0" onclick='valeur("quantite<?=$beer['id']?>","<?=$beer['id']?>")'></td>
								<!-- On veut la valeur dans la case total -->
								<td id="resultat<?= $beer['id'] ?>" ></td></tr>
							
						<?php endforeach; ?>
					</table><br>
					<button type="submit">Valider la commande</button>
				</form>
		</div>
	<br><br><br><br>

	<nav id="menu">
		<a href="index.php"> Accueil</a><br>
		<a href="purchase_order.php"> Commander</a><br>
		<?php 
		if(empty($_SESSION["connect"])) { ?>
			<!--si pas connecté sinon cacher -->
			<a href="connexion.php"> Connexion</a><br>
			<a href="inscription.php"> Vous inscrire</a><br>
		<?php } else if($_SESSION["connect"]) { ?>
			<!--si connecté sinon cacher-->
			<a href="mon_compte.php"> Mon compte</a><br>
			<a href="espace_client.php">Mon historique de commandes</a><br>
			<a href="deconnexion.php"> Déconnexion</a><br>
		<?php  } ?>
	</nav>


<br /><br /><br /><br />
<script type="text/javascript" src="./js/script.js"></script>
</body>
</html>

