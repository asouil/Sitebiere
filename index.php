<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./assets/css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bières en vente</title>
</head>


<body>
<a id="to_nav" href="#menu"> Vers le menu </a>
<h1 class="text-center">Les bières</h1>
	<!-- Changement de style de l'affichage des cases du tableau selon i dans la boucle -->
	<div>
			<?php
			session_start();
			/* créer ma page d'accueil */
			require_once "db.php";
			$sql = "SELECT * FROM `beers`" ;
				$statement = $pdo->prepare($sql);
				$statement->execute([$sql]);
				$beers = $statement->fetchAll();
	 			foreach ($beers as $beer){
			?>
					<div>
						<table>
							<tr><td><h2 class="text-center"><?=$beer["nom"] ?></h2></td></tr>
							<tr><td><img src= '<?=$beer["image"] ?>' alt= '<?=$beer["image"] ?>' ></td></tr>
							<tr><td><?= substr ($beer["description"], 0 , 150).'[...]' ?></td></tr>
							<tr><td><?=number_format($beer["prix"],2, ',','.') ?>€  HT </td></tr>
							<tr><td><?=number_format($beer["prix"]*1.2,2, ',','.') ?> € TTC</td></tr>
						</table>
					</div>
				<?php
				}
				?>
		<br/>
	</div>

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
			<a href="espace_client.php"> Mon historique de commandes </a><br>
			<a href="deconnexion.php"> Déconnexion</a><br>
		<?php  } ?>
	</nav>

</body>
</html>