<?php require 'connect.php';

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
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
 			foreach ($beers as $beer):
 				if($_POST['quantite'.$beer['id']]>0){
 					echo $beer['nom'].' ';
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
		<!--si pas connecté sinon cacher-->
		<a href="connexion.php"> Connexion</a><br>
		<a href="inscription.php"> Vous inscrire</a><br>
		<!--si connecté sinon cacher-->
		<a href="mon_compte.php"> Mon compte</a><br>
		<a href="espace_client.php">Mon historique de commandes</a><br>
		<a href="deconnexion.php"> Déconnexion</a><br>
	</nav>

</body>
</html>


<?php 

/*
		$totalTTC = 0; ?>
		<h3 style='text-align: center'>Voici donc ta confirmation de commande</h3>

			<tbody>
				<?php
				foreach ($beerArray as $key => $value) :
					if($_GET['quantity'][$key] > 0) : ?>
						<tr>
							<td><?= $value[0] ?></td>
							<td><?= number_format($value[3], 2, ',', '.')?>€</td>
							<td><?= number_format($value[3] * $tva, 2, ',', '.') ?>€</td>
							<td><?= $_GET['quantity'][$key] ?></td>
							<td><?= number_format(($value[3] * $tva)*$_GET['quantity'][$key], 2, ',', '.') ?>€</td>
						</tr>
						<?php
							$totalTTC += ($value[3] * $tva)*$_GET['quantity'][$key];
					endif ;
				endforeach; ?>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><strong><?= number_format($totalTTC, 2, ',', '.') ?>€</strong></td>
				</tr>
			</tbody>
		</table>
		<p style="text-align: center;">Celle-ci vous sera livrée au <?= $_GET['address'] ?> <?= $_GET['zipcode'] ?> <?= $_GET['city'] ?> sous deux jours</p>
		<p style="text-align:center;">
			<small>Si vous ne réglez pas sous 10 jours, le prix de votre commande sera majorée.(25%/jours de retard)</small>
		</p>
		<p style="text-align:center;"><button><a href="/bondecommande.php">J'en veux encore ! </a></button></p>
<?php endif; ?>*/