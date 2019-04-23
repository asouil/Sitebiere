<?php
require 'db.php';
require 'connect.php';

?><!--
-Créer un espace client html5
-Celui ci présentera:
	-Un tableau affichant le contenu des commandes passé par l’utilisateur.
-->
<!DOCTYPE html>
<html>
<head>	
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Espace Client</title>
</head>
<body>
	<a href="#menu"> Vers le menu </a><br>
	<h2> Votre historique de commande </h2>
	
<?php
	require_once "db.php";
	$quantite =0;
	$prix = 0;
	$contenu =[];
		//parcourt de la base des commandes
	$sql = "SELECT * FROM `commandes`" ;
	$statement = $pdo->prepare($sql);
	$statement->execute([$sql]);
	$commandes = $statement->fetchAll();
		//pour chaque commande
			
	foreach($commandes as $commande){
		$prix = $commande["pTTC"];
		$idbiere = unserialize($commande["id_biere"]);
		$sql2 = "SELECT * FROM `utilisateurs`" ;
		$state = $pdo->prepare($sql2);
		$state->execute([$sql2]);
		$users = $state->fetchAll();

		foreach($users as $user){
			// si l'utilisateur est l'utilisateur connecté
			if($user["id"]==$commande['id_client']){
				$nomCo=$user['nom'];
				$prenomCo=$user['prenom'];
					//parcourt des bières pour sortir les bières achetées pour cet utilisateur dans le tableau
				$sqlb = "SELECT * FROM `beers`" ;
				$stat = $pdo->prepare($sqlb);
				$stat->execute([$sqlb]);
				$bieres = $stat->fetchAll();	
				foreach($bieres as $biere){
					for($i=0; $i<count($idbiere); $i++){
						if($biere['id']==$idbiere[$i]){
							array_push($contenu, $biere['nom']);
						}
					}
				}
			}
		}
		$quantite= count($contenu);
		echo("Votre Commande ");
		echo("n°:".$commande["id"]).' ';
		echo "pour un montant de ".number_format($prix,2,',','.').'€ contenait '.$quantite.' types de bières.<br>';
		for($j=0;$j<count($contenu);$j++){
			echo($contenu[$j].' <br>');
		}

	}

?>

	<nav id="menu">
		<a href="index.php"> Accueil</a><br>
		<a href="purchase_order.php"> Commander</a><br>
		<!--si connecté sinon cacher-->
		<a href="mon_compte.php">Mon compte</a><br>
		<a href="deconnexion.php"> Déconnexion</a><br>
	</nav>
</body>
</html>