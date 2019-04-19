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
	<!--
	-La table commande disposera de 4 colonnes:
		-id(int)
		-id_client(int)
		-ids_product(text)
		-pTTC(float) -->
	
	<?php 
		/* ici il suffit de récupérer le ou les tableaux en bdd correspondants à l'identifiant client, ce tableau contenant id des commandes, id de l'utilisateur, tableau d'id des bières achetées et le montant total.

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
		<a href="mon_compte.php">Mon compte</a><br>
		<a href="deconnexion.php"> Déconnexion</a><br>
	</nav>
</body>
</html>