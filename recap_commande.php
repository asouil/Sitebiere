<?php require 'connect.php';

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./assets/css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Votre commande</title>
</head>
<body>
		<a id="to_nav" href="#menu"> Vers le menu </a><br>

	<?php 
		$total = 0;
		$array =[];
		$id;
		/*récupérer la liste de bière commandées depuis purchase_order vers ici tout en affichant les opérations effectuées et les produits achetés et envoyer dans tableau mysql commandes*/
		if(isset($_POST)){
			require_once "db.php";
			$sql = "SELECT * FROM `beers`" ;
				$statement = $pdo->prepare($sql);
				$statement->execute([$sql]);
				$beers = $statement->fetchAll();
				$quantity=0;
 			foreach ($beers as $beer):
 				if($_POST['quantite'.$beer['id']]>0){
 					echo $beer['nom'].' ';
 					$quantity+=$_POST['quantite'.$beer['id']];
 					echo number_format($beer['prix'], 2, ',','.').'€ ';
 					echo 'x'.$_POST['quantite'.$beer['id']].' ';
 					echo 'pour un total de : '.number_format($_POST['quantite'.$beer['id']]*$beer['prix'], 2, ',','.').'€ <br>';
 					$total+=$_POST['quantite'.$beer['id']]*$beer['prix'];
 					array_push($array,$beer['id']);
 				}

 			endforeach;
		}
		echo 'Votre facture totale est de : '.number_format($total, 2, ',','.').'€ <br>';
		echo 'Vous avez une semaine pour régler ce montant! <br> ';
		
		require_once "db.php";
		$sql = "SELECT * FROM `utilisateurs`" ;
		$statement = $pdo->prepare($sql);
		$statement->execute([$sql]);
		$users = $statement->fetchAll();
		
		foreach($users as $user){
			//boucle sur le tableau users
			if(($user["mail"]==$mail) && ($user["mail"]!='')){
				 echo 'Vous serez livré au '.$user["adresse"].' ';
				 echo $user["code_postal"].' '.$user["ville"].' ';
				 echo ' sous dix jours après votre paiement.';
				 $id=$user['id'];
			}
		}
		/*
		TODO : ajout dans la base de données des commandes lié à l'utilisateurs ['id'] avec les id de bières dans un tableau ? et le total $total
				serialize ?*/
		$sqldata = serialize($array);
		$sql = "INSERT INTO `commandes` (`id_client`, `id_biere`, `pTTC`) VALUES (:id_client, :id_biere, :pTTC)"; ;
			$statement = $pdo->prepare($sql);
			$statement->execute([
						':id_biere'		=>$sqldata,
						':id_client'	=>$id,
						':pTTC'			=>$total
					]);
	 ?>
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


</body>
</html>


<?php 
