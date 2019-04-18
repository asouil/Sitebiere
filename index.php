<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bières en vente</title>
</head>


<body>

<h1 class="text-center">Les bières</h1>
	<!-- Changement de style de l'affichage des cases du tableau selon i dans la boucle -->
	<div class="col-12 col-sm-8 col-md-3 offset-0 text-center">
		<div class="row col-md-12 offset-0">
<?php
		/* créer ma page d'accueil */

		require_once "db.php";
		$sql = "SELECT * FROM `beers`" ;
			$statement = $pdo->prepare($sql);
			$statement->execute([$sql]);
			$beers = $statement->fetchAll();
 			foreach ($beers as $beer){
?>				<div>
					<h2 class="text-center"><?=$beer["nom"] ?></h2>
					<img src= '<?=$beer["image"] ?>' alt= '<?=$beer["image"] ?>' height="30%" >
					<p class="text-responsive"><?= substr ($beer["description"], 0 , 150).'[...]' ?></p>
					<p><?=number_format($beer["prix"],2, ',','.') ?>€  HT </p>
					<p><?=number_format($beer["prix"]*1.2,2, ',','.') ?> €</p>
				</div>
			<?php
			
			}
 			
			?>
		


<!--?php var_dump($beerArray[$i]) ; ?-->



		<br/>
	</div>
	<nav>

		<a href="index.php"> Accueil</a><br>
		<a href="purchase_order.php"> Commander</a><br>
		<!--si pas connecté sinon cacher-->
		<a href="connexion.php"> Connexion</a><br>
		<a href="inscription.php"> Vous inscrire</a><br>
		<!--si connecté sinon cacher-->
		<a href="mon_compte.php"> Mon compte</a><br>
		<a href="deconnexion.php"> Déconnexion</a><br>

	</nav>

</body>
</html>