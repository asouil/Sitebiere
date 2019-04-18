<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Mon compte</title>
</head>
<body>
<!-- TODO : contenu du profil -->
<?php
	require "connect.php";
	require_once "db.php";
	$sql = "SELECT * FROM `utilisateurs`" ;
		$statement = $pdo->prepare($sql);
		$statement->execute([$sql]);
		$user = $statement->fetchAll();

?>				<div>
					<?= 'Bienvenue <br/>Les utilisateurs sont :<br/>'; 
					foreach($user as $nom){
						echo $nom['nom'].'<br/>';
					}
						?>
				</div>
			<?php
			
			
 			
			?>

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