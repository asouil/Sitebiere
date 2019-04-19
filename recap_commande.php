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
		//récupérer la liste de bière commandées
	 ?>
<nav id="menu">
	<a href="purchase_order.php"> Commander</a>
	<a href="connexion.php"> Connexion</a>
	<a href="inscription.php"> Vous inscrire</a>
	<a href="deconnexion.php"> Déconnexion</a>

</nav>

</body>
</html>