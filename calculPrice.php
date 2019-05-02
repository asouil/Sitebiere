<?php

require_once('includes/function.php');
$user = userOnly();

if(isset($user['mail'])) {
	$sql = "SELECT * FROM `beers`";
	$pdo = getDB($dbuser, $dbpassword, $dbhost,$dbname);
	$statement = $pdo->prepare($sql);
	$statement->execute(); 

	$beerArray = $statement->fetchAll();

	$beerTotal = [];
	foreach ($beerArray as $key => $beer) {
		$beerTotal[$beer['id']]= $beer;
	}

	$priceTTC = 0;
	foreach($_POST['qty'] as $key => $valueQty) { //on boucle sur le tableau $_POST["qty"]
		if($valueQty > 0) {
			$price = $beerTotal[$key]['prix']; 
			$qty[$key] = ['qty' => $valueQty, "prix"=>$price];
			$priceTTC += $valueQty * $price * $tva;
		}
	}

	$serialCommande = serialize($qty); //On convertit le tableau $qty en String pour 												l'envoyer en bdd plus tard.

	$orders = [":id_client"=>(int)$user['id'], ":id_biere"=>$serialCommande, ":pTTC"=>$priceTTC];

	$sql = "INSERT INTO `commandes` (`id_client`,`id_biere`,`pTTC`) VALUES (:id_client, :id_biere, :pTTC)";

	$statement = $pdo->prepare($sql);
	$statement->execute($orders);

	$id = $pdo->lastInsertId(); //On recupère l'id de la dernière insertion en bdd

	header('location: '.uri("confirmationDeCommande.php?id=".$id));
	exit();
}