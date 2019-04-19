<!DOCTYPE html>
<html>
<head>	
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Historique de commande</title>
</head>
<body>
	<a href="#menu"> Vers le menu </a><br>
	<!--
	-La table commande disposera de 3 colonnes:
		-id(int)
		-id_client(int)
		-ids_product(text)
		-pTTC(float) -->
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
	<nav id="menu">

		<a href="index.php"> Accueil</a><br>
		<a href="purchase_order.php"> Commander</a><br>
		<!--si pas connecté sinon cacher-->
		<a href="connexion.php"> Connexion</a><br>
		<a href="inscription.php"> Vous inscrire</a><br>
		<!--si connecté sinon cacher-->
		<a href="mon_compte.php"> Mon compte</a><br>
		<a href="Espace_Client.php">Mon espace</a><br>
		<a href="deconnexion.php"> Déconnexion</a><br>

	</nav>
</body>
</html>