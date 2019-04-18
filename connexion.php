<?php
session_start();
//vérification si connecté
if (isset($_SESSION["connect"])) {
	$connect = $_SESSION["connect"];
}else{
	$connect = false;
}
if($connect){
	header("Location: ./page.php");
}
//fin vérification connexion

$errusername="";
$errpassword="";

if(!empty($_POST)){

	$username = strtolower($_POST["username"]);
	$password = $_POST["password"];

	if (!empty($username) && !empty($password)){
		/* verifier couple user / mdp */
		//récupération user :
		require_once "db.php";
		$sql = "SELECT * FROM `utilisateurs` WHERE `nom`= ?";
		$statement = $pdo->prepare($sql);
		$statement->execute([$username]);
		$user = $statement->fetch();

		//on va appeler la db pour connecter l'utilisateur
		if($user){
			echo($password);
			if (password_verify($password, $user["password"])){
					
					$_SESSION["connect"] = true;
					$_SESSION["username"] = $user["nom"];
					header("Location: ./page.php");
			}else{
				header("HTTP/1.0 403 Forbidden");
				/* USERNAME ou MDP pas bon */
			}
		}else{
			header("HTTP/1.0 403 Forbidden");
			/* USERNAME ou MDP pas bon */
		}
	}else{

		if(empty($username)){
			$errusername= "class=\"danger\"";
		}

		if(empty($password)){
			$errpassword="class=\"danger\"";
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
					<input <?= $errusername ?> type="text" name="username" placeholder="Nom d'utilisateur" required="required" />
					<input <?= $errpassword ?> type="password" name="password" placeholder="Mot de passe" required="required" />
					<button type="submit">Connexion</button>
					<a href="inscription.php">Création de compte</a><br/>
				</form>
			</div>
		</section>
	</div>
</body>
</html>