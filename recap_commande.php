<?php require 'connect.php';
session_start():
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
	<table id = "commande">
		<thead><h3> Récapitulatif de commande </h3></thead>
		<tr><td>Nom de la Bière</td>
			<td>Prix HT</td>
			<td>Prix TTC</td>
			<td>Quantité</td>
			<td>Total</td>
					<tr></td>
					<td></td>
					<td></td>
					<td></td>
				</div>
			</tr>
	</table>
	<a href="#menu"> Vers le menu </a>
	<?php 
		/*récupérer la liste de bière commandées depuis purchase_order vers tableau mysql commandes tout en affichant les opérations effectuées et les produits achetés*/









		*/
	 ?>
	<nav id="menu">
		<a href="index.php"> Accueil</a><br>
		<a href="purchase_order.php"> Commander</a><br>
		<!--si pas connecté sinon cacher-->
		<a href="connexion.php"> Connexion</a><br>
		<a href="inscription.php"> Vous inscrire</a><br>
		<!--si connecté sinon cacher-->
		<a href="commandes.php"> Mes commandes</a><br>
		<a href="espace_client.php">Mon historique de commandes</a><br>
		<a href="deconnexion.php"> Déconnexion</a><br>
	</nav>

</body>
</html>


<?php 
/*
include('donnees.php');
/*
var_dump($_GET);
die;*/
/*if(isset($_GET['firstname'])) :
		$totalTTC = 0; ?>
		<h1 style='text-align: center'>Bonjour <?= $_GET['firstname'] ?> <?= $_GET['lastname'] ?> !</h1>
		<h3 style='text-align: center'>Voici donc ta confirmation de commande</h3>

		<table style="width: 80%;margin-left:10%; text-align:center;" class="">
			<thead>
				<tr>
					<th>Nom de la bière</th>
					<th>Prix HT</th>
					<th>Prix TTC</th>
					<th>Quantité</th>
					<th>Total TTC</th>
				</tr>
			</thead>
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
<?php endif; ?>