<?php
session_start();
if (isset($_SESSION["connect"])) {
	$connect = $_SESSION["connect"];
}else{
	$connect = false;
}
if($connect){
	header("Location: index.php");
	//fin du traitement
}
if(!empty($_POST)){
	$username 	= $_POST["username"];
	$password 	= $_POST["password"];
	$passwordVerif = $_POST["password_verif"];
	$mail 		= strtolower($_POST["mail"]);
	$prenom		= $_POST["forname"]; 
	$adresse 	= $_POST["adresse"];
	$cp 		= $_POST["cp"];
	$ville 		= $_POST["ville"];
	$pays 		= $_POST["pays"];
	$telephone 	= $_POST["phone"];
	$mail 		= $_POST["mail"];


	if (!empty($mail) && !empty($password)){
		require_once 'db.php';
		$sql = "SELECT * FROM users WHERE `mail`= ?";
		$statement = $pdo->prepare($sql);
		$statement->execute([$mail]);
		$user = $statement->fetch();
		
		if(!$user){
			if(strlen($password) <= 10 && strlen($password) >= 5){
				if($password === $passwordVerif){
					$password = password_hash($password, PASSWORD_BCRYPT);
					require_once 'db.php';
					$sql = "INSERT INTO `utilisateurs` (`nom`, `prenom`, `password`, `adresse`, `code_postal`, `ville`, `pays`, `telephone`, `mail`) VALUES (:nom , :prenom,  :password, :adresse, :code_postal, :ville, :pays, :telephone, :mail)";
					//INSERT INTO `utilisateurs`(`id`, `nom`, `prenom`, `password`, `adresse`, `code_postal`, `ville`, `pays`, `telephone`, `mail`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10])
					$statement = $pdo->prepare($sql);
					$result = $statement->execute([
						":nom"		=>	$name,
						":prenom"	=>	$prenom,
						":password"	=>  $password,
						":adresse" 	=>	$adresse,
						":code_postal"=>$cp, 
						":ville" 	=>	$ville,
						":pays"		=>	$pays,
						":telephone"=>	$telephone,
						":mail"		=>	$mail
					]);
					if($result){
						$_SESSION["connect"] = true;
						$_SESSION["username"] = $username;
						header("Location: index.php");
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
				<form action="" method="post">
					<input type="text" name="name" placeholder="Nom" required="required" /><br/>
					<input type="text" name="forname" placeholder="Prénom" required="required" /><br/>
					<input type="password" name="password" placeholder="Mot de passe" required="required" /><br/>
					<input type="password" name="password_verif" placeholder="Confirmez le mot de passe"  /><br/>
					<input type="text" name="adresse" placeholder="Adresse" required="required" /><br/>
					<input type="text" name="ville" placeholder="Ville" required="required" /><br/>
					<input type="text" name="cp" placeholder="Code Postal" required="required" /><br/>
					<input type="text" name="pays" placeholder="Pays" required="required" /><br/>
					<input type="text" name="phone" placeholder="Telephone"  /><br/>
					<input type="email" name="mail" placeholder="Votre email" required="required" /><br/>
					<button type="submit">S'enregistrer</button>
				</form>
			</div>
		</section>
	</div>
	<nav>
		<a href="connexion.php">Identification</a><br/>
		<a href="index.php">Retour à l'accueil</a><br/>
		<a href="PHP/purchase_order.php">Commander</a><br/>
	</nav>
</body>
</html>