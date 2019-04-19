<!--
-Créer un espace client html5
-Celui ci présentera:
	-Une possibilité de modifier ses données personnelle hors adresse mail.
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
	-La table commande disposera de 3 colonnes:
	-id(int)
	-id_client(int)
	-ids_product(text)
	-pTTC(float) -->

	<nav id="menu">

		<a href="index.php"> Accueil</a><br>
		<a href="purchase_order.php"> Commander</a><br>
		<!--si pas connecté sinon cacher-->
		<a href="inscription.php"> Vous inscrire</a><br>
		<a href="Commandes.php"> Mes commandes</a><br>
		<!--si connecté sinon cacher-->
		<a href="mon_compte.php"> Mon compte</a><br>
		<a href="deconnexion.php"> Déconnexion</a><br>

	</nav>
</body>
</html>