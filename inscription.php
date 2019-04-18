<?php
session_start();
if (isset($_SESSION["connect"])) {
	$connect = $_SESSION["connect"];
}else{
	$connect = false;
}
if($connect){
	header("Location: page.php");
	//fin du traitement
}
if(!empty($_POST)){
	$username = strtolower($_POST["username"]);
	$password = $_POST["password"];
	$passwordVerif = $_POST["password_verif"];
	if (!empty($username) && !empty($password)){
		require_once 'db.php';
		$sql = "SELECT * FROM users WHERE `nom`= ?";
		$statement = $pdo->prepare($sql);
		$statement->execute([$username]);
		$user = $statement->fetch();
		
		if(!$user){
			if(strlen($password) <= 10 && strlen($password) >= 5){
				if($password === $passwordVerif){
					$password = password_hash($password, PASSWORD_BCRYPT);
					require_once 'db.php';
					$sql = "INSERT INTO `utilisateurs` (`nom`, `password`) VALUES (:nom , :password)";
					$statement = $pdo->prepare($sql);
					$result = $statement->execute([
						":nom"		=>	$username,
						":password"	=>  $password]);
					if($result){
						$_SESSION["connect"] = true;
						$_SESSION["username"] = $username;
						header("Location: page.php");
					}else{
						die("erreur enregistrement en bdd");
						// TODO : signaler erreur
					}
				}else{
					die("mdp différents");
					// TODO : signaler que mdp non identiques
				}
			}else{
				// TODO : signaler que mdp est pas d'un bon format
				die("mdp pas bon format");
			}
		}else{
			die("utilisateur existe");
			// TODO : signaler que username existe
		}
	
	}else{
		// TODO : signaler les champs vides
	}
}
?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Création de compte</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
	<div class="wrapper">
		<section class="login-container">
			<div>
				<header>
					<h2>Inscription</h2>
				</header>
				<form action="" method="Post">
					<input type="text" name="username" placeholder="Nom d'utilisateur"  />
					<input type="password" name="password" placeholder="Mot de passe"  />
					<input type="password" name="password_verif" placeholder="Confirmez le mot de passe"  />
					<button type="submit">S'enregistrer</button>
				</form>
			</div>
		</section>
	</div>
	<a href="connexion.php">Identification</a><br/>
	<a href="index.php">Retour à l'accueil</a>

</body>
</html>