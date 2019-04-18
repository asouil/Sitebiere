<?php
session_start();
//vérification si connecté
if (isset($_SESSION["connect"])) {
	$connect = $_SESSION["connect"];
}else{
	$connect = false;
}
if($connect){
	header("Location: ./index.php");
}
//fin vérification connexion

$errmail="";
$errpassword="";

if(!empty($_POST)){

	$mail = strtolower($_POST["mail"]);
	$password = $_POST["password"];

	if (!empty($mail) && !empty($password)){
		/* verifier couple user / mdp */
		//récupération user :
		require_once "db.php";
		$sql = "SELECT * FROM `utilisateurs` WHERE `mail`= ?";
		$statement = $pdo->prepare($sql);
		$statement->execute([$mail]);
		$user = $statement->fetch();

		//on va appeler la db pour connecter l'utilisateur
		if($user){
			echo($password);
			if (password_verify($password, $user["password"])){
					
					$_SESSION["connect"] = true;
					$_SESSION["mail"] = $user["mail"];
					header("Location: ./index.php");
			}else{
				header("HTTP/1.0 403 Forbidden");
				/* USERNAME ou MDP pas bon */
			}
		}else{
			header("HTTP/1.0 403 Forbidden");
			/* USERNAME ou MDP pas bon */
		}
	}else{

		if(empty($email)){
			$errmail= "class='danger'";
		}

		if(empty($password)){
			$errpassword="class='danger'";
		}
		
	}

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>formulaire de connexion</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
	<div class="wrapper">
		<section class="login-container">
			<div>
				<header>
					<h2>Identification</h2>
				</header>
				<form action="" method="Post">
					<input <?= $errmail ?> type="text" name="email" placeholder="Votre mail" required="required" />
					<input <?= $errpassword ?> type="password" name="password" placeholder="Mot de passe" required="required" /><br/>
					<button type="submit">Connexion</button>
				
				</form>
			</div>
		</section>
		<nav>
			<a href="inscription.php">Création de compte</a><br/>
			<a href="index.php">Retour à l'accueil</a><br/>
			<a href="PHP/purchase_order.php">Commander</a><br/>
	</div>
</body>
</html>